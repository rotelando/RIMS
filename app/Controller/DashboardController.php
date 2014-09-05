<?php

class DashboardController extends AppController {

    public $name = 'dashboard';
    //The first item is assumed to be the Model!
    public $uses = array('Order', 'Productavailability', 'Brand', 'Product', 'Image', 'User', 'Location', 'State', 'Brief', 'Schedule');
    public $components = array('Paginator', 'Filter');
    public $helpers = array('MyLink');

    public $urloptions = array();
    public $postoptions = array();
    
    function index() {
        
        $modelcounts['actualvsplannedvisit'] = $this->_getActualVsPlannedVisitToday();
        $modelcounts['totalsales'] = $this->_getTotalSalesToday();
        $modelcounts['actualvstotalstaff'] = $this->_getActualVsTotalFieldStaffToday();
        $modelcounts['actualvstotallocation'] = $this->_getActualVsTotalLocationsToday();
        $modelcounts['visitexceptions'] = $this->_getVisitExceptionsToday();
        
        
        $this->set($modelcounts);

        $this->_fetchAndSetAllVisits(5);

        $this->_visitaccuracy();

        $this->_setProductAvailability();
        
        $recentImages = $this->_getResentImages(16);
//        debug($recentImages);
        $this->set('images', $recentImages);
//        debug(hash('sha512', 'hello'));

        $distrib = $this->_outletdistribution(true);
        $least = $this->_leastCrowdedLocations();
        $most = $this->_mostCrowdedLocations();
        $this->set(array('least_location' => $least, 'most_location' => $most, 'distributions' => $distrib));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();

        //get current user settings :)
        $this->setCurrentUserSettings();
       
    }

    private function _outletdistribution($postdata = false) {
        
        if($postdata) {
            $options = $this->postoptions;
        } else {
            $options = $this->urloptions;
        }
        
        $options['fields'] = array(
            'Outlettype.outlettypename', 
            'Outlettype.id', 
            'Count(Outlet.outlettypeid) as count'
        );
        $options['group'] = array('outlettypeid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlettypes',
                'alias' => 'Outlettype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.outlettypeid = Outlettype.id'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );
        $rs = $this->Outlet->find('all', $options);
        return $rs;
    }
    
    private function _leastCrowdedLocations($number = 3) {
        $result = $this->Outlet->find('all', array(
            'fields' => array('Outlet.locationid', 'Location.locationname', 'COUNT(Outlet.locationid) as count'),
            'group' => array('Outlet.locationid'),
            'limit' => $number,
            'recursive' => -1,
            'order' => array('count asc'),
            'joins' => array(
                array(
                    'table' => 'locations',
                    'alias' => 'Location',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Location.id = Outlet.locationid'
                    )
                ))
        ));
        return $result;
    }

    private function _mostCrowdedLocations($number = 3) {
        $result = $this->Outlet->find('all', array(
            'fields' => array('Outlet.locationid', 'Location.locationname', 'COUNT(Outlet.locationid) as count'),
            'group' => array('Outlet.locationid'),
            'limit' => $number,
            'recursive' => -1,
            'order' => array('count desc'),
            'joins' => array(
                array(
                    'table' => 'locations',
                    'alias' => 'Location',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Location.id = Outlet.locationid'
                    )
                ))
        ));
        return $result;
    }

    private function _visitaccuracy() {

        $options = $this->Filter->getPostDataFilterOptions('Schedule');
        $this->_getFilterDisplayText($this->Filter->getFilterText($this->modelClass)); //set the filter text on the page title
        
        $options['recursive'] = -1;
        if (isset($options)) {
            $options['joins'] = array(
                array(
                    'table' => 'outlets',
                    'alias' => 'Outlet',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Outlet.id = Schedule.outletid'
                    )
                ),
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'User.id = Outlet.userid'
                    )
                )
            );
        }

        $planned = $this->Schedule->find('count', $options);

        $options['conditions']['visited'] = 1;
        $actual = $this->Schedule->find('count', $options);

        $settings = $this->setCurrentUserSettings();
        $target = isset($settings['Setting']['TargetVisit']) ? intval($settings['Setting']['TargetVisit']) : null;

        if ($planned != 0) {
            $actual_vs_planned = intval(($actual / $planned) * 100);
        } else {
            $actual_vs_planned = 100;
        }

        if (isset($target) || $target > 0) {
            $actual_vs_target = intval(($actual / $target) * 100);
            $planned_vs_target = intval(($planned / $target) * 100);
        } else {
            $actual_vs_target = 100;
            $planned_vs_target = 100;
        }
        $response = array(
            'planned' => $planned,
            'actual' => $actual,
            'target' => $target,
            'actual_vs_planned' => $actual_vs_planned,
            'actual_vs_target' => $actual_vs_target,
            'planned_vs_target' => $planned_vs_target
        );
        $this->set('vaccuracy', $response);
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('dashboard');
        $this->_setTitleOfPage('Dashboard');
    }

    public function _setSidebarActiveItem($topMenu) {
        $this->set(array('active_item' => $topMenu));
    }

    //All visit in the visit table are completed!
    private function _fetchAndSetAllVisits($limit) {

        //========================================================================================
        $options = $this->Filter->getPostDataFilterOptions('Visit');
        //========================================================================================

        $options['order'] = array('Visit.createdat DESC');
        $options['limit'] = $limit;
        $options['recursive'] = -1;
        $options['fields'] = array(
            'Visit.id',
            'Visit.starttimestamp',
            'Visit.duration',
            'Visit.distancefromoutlet',
            'Outlet.id',
            'Outlet.outletname',
        );
        
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );
        $visits = $this->Visit->find('all', $options);
        $this->set(array('visits' => $visits));
    }
    
    private function _getOrderCount($options = null) {
        
        $options = $this->Filter->getPostDataFilterOptions('Order');
        
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Order.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );
        
        $ordercount = $this->Order->find('count', $options);
        return $ordercount;
    }
    
    private function _getScheduleCount($options = null) {
        $schedulecount = $this->Schedule->find('count', $options);
        return $schedulecount;
    }

    private function _getFieldStaffCount() {        
        
        $fieldstaffcount = $this->_fieldrepLists(false, true);
//        debug($fieldstaffcount);
        return $fieldstaffcount;
    }

    private function _getLocationCount() {
        $locationcount = $this->Location->find('count');
        return $locationcount;
    }

    private function _getProductCount() {
        $productcount = $this->Product->find('count');
        return $productcount;
    }

    private function _getBriefCount() {
        $options['joins'] = array(
            array(
                'table' => 'Brief2',
                'alias' => 'Brief2',
                'type' => 'INNER',
                'conditions' => array(
                    'Brief.groupidentity = Brief2.groupidentity',
                    'Brief.createdat = Brief2.createdat'
                )
            )
        );

        //Now you can use the paginate option
        $briefcount = $this->Brief->find('count', $options);
        return $briefcount;
    }

    //Setting product availabilities
    private function _setProductAvailability() {
        
        //Get All Brand List except Current Order by ProductId => Columns
        $brands = $this->Brand->find('all', array(
            'recursive' => -1,
            'fields' => array('Brand.id', 'Brand.brandname', 'Brand.brandcolor'),
            'order' => array('Brand.id'),
//            Comment to Include Brands
            'conditions' => array('NOT' => array('Brand.current' => array(1)))
        ));
        $this->set(array('brands' => $brands));

        //Get the Current Brand
        $currentbrand = $this->Brand->find('all', array(
            'recursive' => -1,
            'fields' => array('Brand.id', 'Brand.brandname'),
            'conditions' => array('Brand.current' => 1)));
        $this->set('currentbrand', $currentbrand);
//        debug($currentbrand);
        //Get all current brand products
        if(!isset($currentbrand[0]['Brand']['id'])) {
            $this->set('prodavails', array());
            return;
        }
        $brandproducts = $this->_getBrandProduct($currentbrand[0]['Brand']['id']);
//        debug($brandproducts);
        $this->set(array('brandproducts' => $brandproducts));

        //Get Product Availability Information without current brand details
        $prodcomps = $this->_getProductAvailabilityWithoutCurrentBrand($currentbrand[0]['Brand']['id']);
//        debug($prodcomps);
        $this->set(array('prodcomps' => $prodcomps));

        //Get all product availability list for table
        $prodavails = $this->_getAllProductAvailabilityList();
//        debug($prodavails);
        $this->set(array('prodavails' => $prodavails));
    }

    private function _getBrandProduct($brandId) {
//        if (isset($this->params['url']['floc'])) {
//            $options['conditions']['locationid'] = $this->params['url']['floc'];
//        }
//        //condition for fieldrep filter
//        if (isset($this->params['url']['fuid'])) {
//            $options['conditions']['userid'] = $this->params['url']['fuid'];
//        }
        
        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Product.id',
            'Product.productname',
            'Product.compareproductid',
            'Productavailability.id',
            'Productavailability.quantityavailable',
            'SUM(Productavailability.quantityavailable) AS totalquantity'
        );
        $options['order'] = array('Product.id');
        //Comment to Include Brands
        $options['conditions']['Brand.id'] = $brandId;
        $options['group'] = array('Product.id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Productavailability.productid'
                )
            ),
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Productavailability.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );
        $brandproducts = $this->Productavailability->find('all', $options);
        return $brandproducts;
    }

    private function _getProductAvailabilityWithoutCurrentBrand($currentId) {
        //Get Product Availability data for other Brands apart from the current ordered by how they will be added
        //to the Matrix - Row => Compareproductid, Column => Brandid
        if (isset($this->params['url']['floc'])) {
            $options['conditions']['locationid'] = $this->params['url']['floc'];
        }
        //condition for fieldrep filter
        if (isset($this->params['url']['fuid'])) {
            $options['conditions']['userid'] = $this->params['url']['fuid'];
        }
        
        $options['fields'] = array(
            'Brand.id',
            'Product.id',
            'Product.productname',
            'Product.compareproductid',
            'Productavailability.id',
            'Productavailability.quantityavailable',
            'SUM(Productavailability.quantityavailable) AS totalquantity'
        );
        $options['order'] = array('Product.compareproductid', 'Brand.id');
        //Comment to Include Brands
//        $options['conditions'] = array('NOT' => array('Brand.id' => $currentId));
        $options['group'] = array('Product.id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Productavailability.productid'
                )
            ),
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Productavailability.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );

        $prodcomps = $this->Productavailability->find('all', $options);
        return $prodcomps;
    }

    private function _getAllProductAvailabilityList() {

        if (isset($this->params['url']['floc'])) {
            $options['conditions']['locationid'] = $this->params['url']['floc'];
        }
        //condition for fieldrep filter
        if (isset($this->params['url']['fuid'])) {
            $options['conditions']['userid'] = $this->params['url']['fuid'];
        }
        
        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Product.id',
            'Product.productname',
            'Productavailability.id',
            'Productavailability.visitid',
            'Productavailability.quantityavailable',
            'Productavailability.unitprice',
            'Productavailability.purchasepoint'
        );
        $options['recursive'] = -1;
        $options['limit'] = 20;
        $options['order'] = array('Productavailability.createdat');
        $options['joins'] = array(
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Productavailability.productid'
                )
            ),
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Productavailability.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );
        $this->Paginator->settings = $options;
        $prodavails = $this->Paginator->Paginate('Productavailability');
        return $prodavails;
    }

    //        link="j-myJSFunction-China, 90"
//        animation='0' showShadow='0' showBevel='0' showMarkerLabels='1' fillColor='F1f1f1' 
//        borderColor='00FFFF' hoverColor='000000' baseFont='Verdana' baseFontSize='10' 
//        markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' 
//        legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'
//        "bordercolor": "005879",
//        "hoverOnEmpty": "0",
//        "numbersuffix": "M",
//        "includevalueinlabels": "1",
//              "labelsepchar": ":",
//        {"id": "NG.OY", "value": "727", "link": "j-entityclicked-NA,515"},
    
    public function mapdata() {
        $mapdata["map"]["fillcolor"] = "ffffff";
        $mapdata["map"]["basefontsize"] = "10";
        $mapdata["map"]["showBevel"] = "0";
        $mapdata["map"]["borderColor"] = "105687";
        $mapdata["map"]["useHoverColor"] = "1";
        $mapdata["map"]["hoverColor"] = "105687";
        $mapdata["map"]["canvasBorderColor"] = "ffffff";
        $mapdata["map"]["toolTipBgColor"] = "ffffff";
        $mapdata["map"]["toolTipBorderColor"] = "000000";
        $mapdata["map"]["showToolTipShadow"] = "1";

//        $mapdata = <<< EOF
//        {
//              "map": {
//              "fillcolor": "ffffff",
//              "basefontsize": "10",
//              "showBevel": "0",
//              "borderColor": "ff5e63",
//              "useHoverColor": "1",
//              "hoverColor": "ff790f",  
//              "canvasBorderColor": "ffffff"
//                
//            },
//            "data": [
//              {"id": "NG.LA", "value": "30", "toolText": "Lagos {br}Actual Visit:245 {br}Planned Visit: 420", "color":"ff0000"},
//              {"id": "NG.ON", "value": "40"},
//              {"id": "NG.OS", "value": "100"},
//              {"id": "NG.OY", "value": "727", "link": "JavaScript:myFunction('USA', 235);"},
//              {"id": "NG.FC", "value": "885"}
//            ]
//        }
//EOF;
        //outlet count by locations
        $outletbylocation = $this->_outletCountByLocation();
        foreach ($outletbylocation as $outletdetail) {
            $id = $outletdetail['State']['internalid'];
            $value = $outletdetail[0]['outletcount'];
            $tooltext = '';
            if (isset($mapdata['data'][$id]['toolText'])) {
                $tooltext = $mapdata['data'][$id]['toolText'] . '{br}';
            }

            $tooltext = 'Outlet Count: ' . $value;

            $mapdata['data'][$id] = array(
                'id' => $id,
                'value' => $value,
                'toolText' => $tooltext,
                'link' => 'JavaScript:mapDashboardFunction("' . $id . '")'
            );
        }

        //Scheduled visit count by locations
        $schedulevisitbylocation = $this->_scheduleVisitCountByLocation();
        foreach ($schedulevisitbylocation as $visitdetail) {
            $id = $visitdetail['State']['internalid'];
            $value = $visitdetail[0]['schedulecount'];
            $tooltext = '';
            if (isset($mapdata['data'][$id]['toolText'])) {
                $tooltext = $mapdata['data'][$id]['toolText'] . '{br}';
            }
            $tooltext .= 'Schedule Visit: ' . $value;

            $mapdata['data'][$id] = array(
                'id' => $id,
                'value' => $value,
                'toolText' => $tooltext,
                'link' => 'JavaScript:mapDashboardFunction("' . $id . '")'
            );
        }

        //Actual visit count by locations
        $actualvisitbylocation = $this->_actualVisitCountByLocation();
        foreach ($actualvisitbylocation as $visitdetail) {
            $id = $visitdetail['State']['internalid'];
            $value = $visitdetail[0]['visitcount'];
            $tooltext = '';
            if (isset($mapdata['data'][$id]['toolText'])) {
                $tooltext = $mapdata['data'][$id]['toolText'] . '{br}';
            }
            $tooltext .= 'Actual Visit: ' . $value;

            $mapdata['data'][$id] = array(
                'id' => $id,
                'value' => $value,
                'toolText' => $tooltext,
                'link' => 'JavaScript:mapDashboardFunction("' . $id . '")'
            );
        }

        //Order Count by Locations
        $orderbylocation = $this->_orderCountByLocation();
        foreach ($orderbylocation as $visitdetail) {
            $id = $visitdetail['State']['internalid'];
            $value = $visitdetail[0]['ordercount'];
            $tooltext = '';
            if (isset($mapdata['data'][$id]['toolText'])) {
                $tooltext = $mapdata['data'][$id]['toolText'] . '{br}';
            }
            $tooltext .= 'Order Count: ' . $value;

            $mapdata['data'][$id] = array(
                'id' => $id,
                'value' => $value,
                'toolText' => $tooltext,
                'link' => 'JavaScript:mapDashboardFunction("' . $id . '")'
            );
        }

        $mapdata['data'] = array_values($mapdata['data']);
        $response = json_encode($mapdata);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    private function _orderCountByLocation() {
        $options['fields'] = array('State.internalid, COUNT(Outlet.locationid) as ordercount');
        $options['group'] = array('State.internalid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Order.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );
        $orderbylocation = $this->Order->find('all', $options);

        return $orderbylocation;
    }

    private function _outletCountByLocation() {
        //outlet count by locations
        $options['fields'] = array('State.internalid, COUNT(State.internalid) as outletcount');
        $options['group'] = array('State.internalid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );
        $outletbylocation = $this->Outlet->find('all', $options);

        return $outletbylocation;
        //End outlet count by locations
    }

    private function _actualVisitCountByLocation() {
        $options['fields'] = array('State.internalid, COUNT(State.internalid) as visitcount');
        $options['group'] = array('State.internalid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );
        $visitbylocation = $this->Visit->find('all', $options);
        return $visitbylocation;
    }

    private function _scheduleVisitCountByLocation() {
        $options['fields'] = array('State.internalid, COUNT(State.internalid) as schedulecount');
        $options['group'] = array('State.internalid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );
        $schedulebylocation = $this->Schedule->find('all', $options);
        return $schedulebylocation;
    }

    //Outlet, Visit and Sales performance monitor
    public function performance() {

        $options = $this->Filter->getPostDataFilterOptions('Order');
        
        if(!isset($options['conditions']["DATE_FORMAT( Order.createdat,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( Order.createdat,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( Order.createdat,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }

        $options['fields'] = array(
            "DATE_FORMAT( Order.createdat,  '%Y-%m-%d' ) as datecreated", 
            'COUNT(Order.createdat) as count');
        $options['recursive'] = -1;
        $options['group'] = array("DATE_FORMAT( Order.createdat,  '%Y-%m-%d' )");
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Order.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            )
        );
        $rs = $this->Order->find('all', $options);

        $order_data = array();
        foreach ($rs as $result) {
            $order_data[] = array(strtotime($result[0]['datecreated']) * 1000, intval($result[0]['count']));
        }

        //Outlet Performance Data
        $options = $this->Filter->getPostDataFilterOptions('Outlet');
        if(!isset($options['conditions']["DATE_FORMAT( Outlet.createdat,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( Outlet.createdat,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( Outlet.createdat,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }
        $options['fields'] = array(
            "DATE_FORMAT( Outlet.createdat,  '%Y-%m-%d' ) as datecreated", 
            'COUNT(Outlet.createdat) as count');
        $options['recursive'] = -1;
        $options['group'] = array("DATE_FORMAT( Outlet.createdat,  '%Y-%m-%d' )");
        $rs = $this->Outlet->find('all', $options);

        $outlet_data = array();
        foreach ($rs as $result) {
            $outlet_data[] = array(strtotime($result[0]['datecreated']) * 1000, intval($result[0]['count']));
        }

        //Visit Performance Data
         $options = $this->Filter->getPostDataFilterOptions('Visit');
        if(!isset($options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }
        $options['fields'] = array(
            "DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' ) as datecreated", 
            'COUNT(Visit.createdat) as count');
        $options['recursive'] = -1;
        $options['group'] = array("DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' )");
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            )
        );
        
        $rs = $this->Visit->find('all', $options);

        $visit_data = array();
        foreach ($rs as $result) {
            $visit_data[] = array(strtotime($result[0]['datecreated']) * 1000, intval($result[0]['count']));
        }

        $response = array();

        $series_outlet_data['name'] = 'Outlet';
        $series_outlet_data['data'] = $outlet_data;
        $series_outlet_data['color'] = '#438eb8';

        $series_visit_data['name'] = 'Visit';
        $series_visit_data['data'] = $visit_data;
        $series_visit_data['color'] = '#109619';

        $series_order_data['name'] = 'Sales';
        $series_order_data['data'] = $order_data;
        $series_order_data['color'] = '#dc3813';


        $response[] = $series_outlet_data;
        $response[] = $series_visit_data;
        $response[] = $series_order_data;

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);

//        $jsonresponse = $rs;
//        $this->set('response', print_r($jsonresponse));
    }

    public function visitaccuracy($stateInternalId = null) {

        $statename = 'Overall';
        if (!is_null($stateInternalId)) {
            $options['conditions'] = array('State.internalid' => $stateInternalId);
            $nameofstate = $this->State->find('all', array(
                'fields' => array('State.statename'),
                'conditions' => array('State.internalid' => $stateInternalId)));
//            debug($nameofstate);
            if (isset($nameofstate[0]['State']['statename'])) {
                $statename = $nameofstate[0]['State']['statename'];
            } else {
                $statename = "Unnamed";
            }
        }
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );

        $planned = $this->Schedule->find('count', $options);

        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );
        $actual = $this->Visit->find('count', $options);

        $settings = $this->setCurrentUserSettings();
        $target = intval($settings['Setting']['TargetVisit']);
        if ($planned != 0) {
            $actual_vs_planned = intval(($actual / $planned) * 100);
        } else {
            $actual_vs_planned = 100;
        }

        if (isset($target) || $target > 0) {
            $actual_vs_target = intval(($actual / $target) * 100);
            $planned_vs_target = intval(($planned / $target) * 100);
        } else {
            $actual_vs_target = 100;
            $planned_vs_target = 100;
        }

        $options['joins'] = array(
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );
        $outletcount = $this->Outlet->find('count', $options);

        //Order Relationship
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Order.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );
        $ordercount = $this->Order->find('count', $options);

        $response = array(
            'planned' => $planned,
            'actual' => $actual,
            'target' => $target,
            'actual_vs_planned' => $actual_vs_planned,
            'actual_vs_target' => $actual_vs_target,
            'planned_vs_target' => $planned_vs_target,
            'outletcount' => $outletcount,
            'ordercount' => $ordercount,
            'statename' => $statename,
        );



        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    private function _getResentImages($number) {
        
        $options = $this->Filter->getPostDataFilterOptions('Image');
        
        $options['fields'] = array(
            'Image.id',
            'Image.description',
            'Image.filename',
            'Image.createdat',
            'Outlet.id',
            'CONCAT(User.firstname," ",User.lastname) as fullname',
            'Outlet.outletname',
            'Location.locationname',
        );
        $options['order'] = array('Image.createdat DESC');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Image.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );

        $images = $this->Image->find('all', $options);
        return $images;
    }
    
    function _getActualVsPlannedVisitToday() {
        $today = date('Y-m-d');
        $options['conditions']["DATE_FORMAT( createdat,  '%Y-%m-%d' )"] = $today;
        $options['recursive'] = -1;
        $plannedvisit = $this->Schedule->find('count', $options);
        
        $actualvisit = $this->Visit->find('count', $options);
//        debug($actualvisit . '/' . $plannedvisit);
        return $actualvisit . '/' . $plannedvisit;
    }
    
    function _getActualVsTotalFieldStaffToday() {
        
        $totalstaff = $this->User->find('count', array('conditions' => array('userroleid' => 3)));
                
        $today = date('Y-m-d');
        $options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' )"] = $today;
        $options['recursive'] = -1;
        $options['fields'] = array(
            'COUNT(DISTINCT Outlet.userid) AS count'
        );
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            )
        );
        $actualstaff = $this->Visit->find('first', $options);
        $actualstaffcount = isset($actualstaff[0]['count']) ? $actualstaff[0]['count'] : 0;
        return $actualstaffcount . '/' . $totalstaff;
    }
    
    function _getTotalSalesToday() {
        $today = date('Y-m-d');
        $options['conditions']["DATE_FORMAT( createdat,  '%Y-%m-%d' )"] = $today;
        $options['recursive'] = -1;
        $options['fields'] = array('SUM( Order.quantity * ( Order.unitprice - Order.discount * Order.unitprice ) ) as totalordervalue');
        $ordervalue = $this->Order->find('first', $options);
        $totalvalue = isset($ordervalue[0]['totalordervalue']) ? round($ordervalue[0]['totalordervalue'], 2) : 0.00;
        return 'N ' . $totalvalue;
    }
    
    function _getActualVsTotalLocationsToday() {
        
        $totallocations = $this->Location->find('count');
                
        $today = date('Y-m-d');
        $options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' )"] = $today;
        $options['recursive'] = -1;
        $options['fields'] = array(
            'COUNT(DISTINCT Outlet.locationid) AS count'
        );
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            )
        );
        $actuallocation = $this->Visit->find('first', $options);
        $actuallocationcount = isset($actuallocation[0]['count']) ? $actuallocation[0]['count'] : 0;
        return $actuallocationcount . '/' . $totallocations;
    }
    
    function _getVisitExceptionsToday() {
        
        $settings = $this->setCurrentUserSettings();
        $visitexception = intval($settings['Setting']['VisitException']);
        
        $today = date('Y-m-d');
        $options['conditions']["DATE_FORMAT( createdat,  '%Y-%m-%d' )"] = $today;
        $options['conditions']["distancefromoutlet >="] = $visitexception;
        $options['recursive'] = -1;        
        $visitexceptioncount = $this->Visit->find('count', $options);

        return $visitexceptioncount;
    }
    
    

}
