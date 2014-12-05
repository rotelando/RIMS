<?php

class DashboardController extends AppController {

    public $name = 'dashboard';
    //The first item is assumed to be the Model!
    public $uses = array('Outlet', 'Brand', 'Product', 'Image', 'User', 'Location', 'State', 'Subregion', 'Brief', 'Outletproduct',
        'Outletmerchandize', 'Outletimage', 'Productcategory');
    public $components = array('Paginator', 'Filter');
    public $helpers = array('MyLink');

    public $urloptions = array();
    public $postoptions = array();
    
    function index() {

        $outlet_count = $this->Outlet->countOutlet($this->postoptions);
        $merchandize_count = $this->Outletmerchandize->countMerchandize($this->postoptions);

        $recentImages = $this->Outletimage->recentImages(6, $this->postoptions);
        $this->set(array('oimages' => $recentImages));

        $distrib = $this->Outlet->retailTypeDistribution($this->postoptions);
        $outclass = $this->Outlet->outletTypeDistribution($this->postoptions);

        //Instead of doing this, you can actually use one and ur array_slice to get the first three and last three
        $least = $this->Outlet->leastCrowdedLocations($this->postoptions);
        $most = $this->Outlet->mostCrowdedLocations($this->postoptions);
        $leastvis = $this->Outletmerchandize->leastVisibilityTerritories($this->postoptions);
        $mostvis = $this->Outletmerchandize->mostVisibilityTerritories($this->postoptions);

        $prodSub = $this->Outletproduct->getOutletProductsBySubregion($this->postoptions);
        $retailSub = $this->Outlet->getRetailClassBySubregion($this->postoptions);

        $productList = $this->Productcategory->getProductCategoryList();
        $subregionList = $this->Subregion->getSubregionList();
        $retailtypeList = $this->Retailtype->getRetailtypeAsList();

        $productSubRegion = $this->getProductSubregionMatrix($prodSub, $productList, $subregionList);
        $retailSubRegion = $this->getRetailSubregionMatrix($retailSub, $retailtypeList, $subregionList);


        $this->set(
            array(
                'outlet_count' => $outlet_count,
                'merchandize_count' => $merchandize_count,
                'least_location' => $least,
                'most_location' => $most,
                'least_visibility' => $leastvis,
                'most_visibility' => $mostvis,
                'distributions' => $distrib,
                'outclass' => $outclass,
                'product_sub_region' => $productSubRegion,
                'retail_class_sub_region' => $retailSubRegion,
                'product_list' => $productList,
                'subregion_list' => $subregionList,
                'retailtype_list' => $retailtypeList
            )
        );
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();

        //get current user settings :)
        $this->setCurrentUserSettings();

        $this->urloptions = $this->Filter->getUrlFilterOptions('Outlet');
        $this->postoptions = $this->Filter->getPostDataFilterOptions('Outlet');
       
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('dashboard');
        $this->_setTitleOfPage('Dashboard');
    }

    public function _setSidebarActiveItem($topMenu) {
        $this->set(array('active_item' => $topMenu));
    }

    public function outletProductDistribution() {

        $resp = [];
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];

        $outletproducts = $this->Outletproduct->outletProductDistribution($this->postoptions);

        $i = 0;

        foreach ($outletproducts as $value) {
            $data['name'] = $value['Productcategory']['productcategoryname'];
            $data['y'] = intval($value[0]["count"]);
            $data['color'] = $colors[$i];
            $resp[] = $data;
            $i++;
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);

    }

    public function outletMerchandizeDistribution() {

        $resp = [];
        $i = 0;

        $outletmerchandize = $this->Outletmerchandize->outletMerchandizeDistribution($this->urloptions);
        foreach ($outletmerchandize as $value) {
            $data['name'] = $value['Brand']['brandname'];
            $data['y'] = intval($value[0]["count"]);
            $data['color'] = $value['Brand']['brandcolor'];
            $resp[] = $data;
            $i++;
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);

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


    private function _getBrandProduct($brandId) {
//        if (isset($this->params['url']['floc'])) {
//            $options['conditions']['location_id'] = $this->params['url']['floc'];
//        }
//        //condition for fieldrep filter
//        if (isset($this->params['url']['fuid'])) {
//            $options['conditions']['userid'] = $this->params['url']['fuid'];
//        }
        
        /*$options['fields'] = array(
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
        return $brandproducts;*/
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
        $outletbylocation = $this->Outlet->getOutletCountByLocation($this->urloptions);
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

        //Merchandize count by locations
        $outletmerchandizebylocation = $this->Outletmerchandize->OutletMerchandizeByLocation($this->urloptions);
        foreach ($outletmerchandizebylocation as $omcount) {
            $id = $omcount['State']['internalid'];
            $value = $omcount[0]['merchandizecount'];
            $tooltext = '';
            if (isset($mapdata['data'][$id]['toolText'])) {
                $tooltext = $mapdata['data'][$id]['toolText'] . '{br}';
            }
            $tooltext .= 'Weighted Merchandize: ' . $value;

            $mapdata['data'][$id] = array(
                'id' => $id,
                'value' => $value,
                'toolText' => $tooltext,
                'link' => 'JavaScript:mapDashboardFunction("' . $id . '")'
            );
        }

        //Scheduled visit count by locations
        $outletproductbylocation = $this->Outletproduct->OutletProductByLocation($this->urloptions);
        foreach ($outletproductbylocation as $opcount) {
            $id = $opcount['State']['internalid'];
            $value = $opcount[0]['productcount'];
            $tooltext = '';
            if (isset($mapdata['data'][$id]['toolText'])) {
                $tooltext = $mapdata['data'][$id]['toolText'] . '{br}';
            }
            $tooltext .= 'Product Count: ' . $value;

            $mapdata['data'][$id] = array(
                'id' => $id,
                'value' => $value,
                'toolText' => $tooltext,
                'link' => 'JavaScript:mapDashboardFunction("' . $id . '")'
            );
        }

        /*//Scheduled visit count by locations
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
        }*/

        $mapdata['data'] = array_values($mapdata['data']);
        $response = json_encode($mapdata);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    private function _orderCountByLocation() {
        $options['fields'] = array('State.internalid, COUNT(Outlet.location_id) as ordercount');
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
                    'Location.id = Outlet.location_id'
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
                    'Location.id = Outlet.location_id'
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
                    'Location.id = Outlet.location_id'
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
                    'Location.id = Outlet.location_id'
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
                    'Location.id = Outlet.location_id'
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
                    'Location.id = Outlet.location_id'
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
                    'Location.id = Outlet.location_id'
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
                    'Location.id = Outlet.location_id'
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
            'COUNT(DISTINCT Outlet.location_id) AS count'
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

    private function getProductSubregionMatrix($productSub, &$products, &$subregions) {

        $prodSubMatrix = array();
        $responseMatrix = array();
        foreach ($productSub as $prodSub) {

            if(!isset($prodSubMatrix[$prodSub['Subregion']['id']]['total'])) {
                $prodSubMatrix[$prodSub['Subregion']['id']]['total'] = 0;
            }

            $prodSubMatrix[$prodSub['Subregion']['id']][$prodSub['Productcategory']['id']] = $prodSub;
            $prodSubMatrix[$prodSub['Subregion']['id']]['subregionname'] = $prodSub['Subregion']['subregionname'];
            $prodSubMatrix[$prodSub['Subregion']['id']]['total'] += $prodSub[0]['productcount'];

        }

        /*sort($products);
        sort($subregions);*/
        $responseMatrix[0][0] = '\\';
        $responseMatrix[0][1] = 'Subregion';
        $responseMatrix[0][2] = 'Total Outets';
        $i = 2;
        foreach ($products as $product) {
            $responseMatrix[0][++$i] = $product;
        }

        $j = 1;
        foreach ($subregions as $subregionKey => $subregion) {

            if(!isset($prodSubMatrix[$subregionKey])) { continue; }

            $k = 0;
            $responseMatrix[$j][$k++] = $j;
            $responseMatrix[$j][$k++] = $subregion;
            $responseMatrix[$j][$k++] = $prodSubMatrix[$subregionKey]['total'];
            foreach ($products as $productKey => $product) {

                if(isset($prodSubMatrix[$subregionKey][$productKey])) {
                    $responseMatrix[$j][$k++] = $prodSubMatrix[$subregionKey][$productKey]['0']['productcount'];
                } else {
                    $responseMatrix[$j][$k++] = 0;
                }
            }

            $j++;
        }

        return $responseMatrix;
    }

    private function getRetailSubregionMatrix($retailSub, &$retailtypes, &$subregions) {

        $retSubMatrix = array();
        $responseMatrix = array();
        foreach ($retailSub as $retSub) {

            if(!isset($retSubMatrix[$retSub['Subregion']['id']]['total'])) {
                $retSubMatrix[$retSub['Subregion']['id']]['total'] = 0;
            }

            $retSubMatrix[$retSub['Subregion']['id']][$retSub['Retailtype']['id']] = $retSub;
            $retSubMatrix[$retSub['Subregion']['id']]['subregionname'] = $retSub['Subregion']['subregionname'];
            $retSubMatrix[$retSub['Subregion']['id']]['total'] += $retSub[0]['retailcount'];

        }

        /*sort($products);
        sort($subregions);*/
        $responseMatrix[0][0] = '\\';
        $responseMatrix[0][1] = 'Subregion';
        $responseMatrix[0][2] = 'Total Outets';
        $i = 2;
        foreach ($retailtypes as $retailtype) {
            $responseMatrix[0][++$i] = $retailtype;
        }

        $j = 1;
        foreach ($subregions as $subregionKey => $subregion) {

            if(!isset($retSubMatrix[$subregionKey])) { continue; }

            $k = 0;
            $responseMatrix[$j][$k++] = $j;
            $responseMatrix[$j][$k++] = $subregion;
            $responseMatrix[$j][$k++] = $retSubMatrix[$subregionKey]['total'];
            foreach ($retailtypes as $retailtypeKey => $retailtype) {

                if(isset($retSubMatrix[$subregionKey][$retailtypeKey])) {
                    $responseMatrix[$j][$k++] = $retSubMatrix[$subregionKey][$retailtypeKey]['0']['retailcount'];
                } else {
                    $responseMatrix[$j][$k++] = 0;
                }
            }

            $j++;
        }

        return $responseMatrix;
    }


}
