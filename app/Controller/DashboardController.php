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

    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();

        //get current user settings :)
        $this->setCurrentUserSettings();
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('dashboard');
        $this->_setTitleOfPage('Dashboard');
        $this->set(array('controller' => 'dashboard', 'action' => 'index'));
    }

    public function _setSidebarActiveItem($topMenu) {
        $this->set(array('active_item' => $topMenu));
    }

    function index() {

        $this->urloptions = $this->Filter->getUrlFilterOptions('Outlet');
        $this->postoptions = $this->Filter->getPostDataFilterOptions('Outlet');

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

    public function outletProductDistribution() {

        $resp = [];
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];

        $this->urloptions = $this->Filter->getUrlFilterOptions('Outlet');
        $outletproducts = $this->Outletproduct->outletProductDistribution($this->urloptions);

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

        $this->urloptions = $this->Filter->getUrlFilterOptions('Outlet');
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
        $this->urloptions = $this->Filter->getUrlFilterOptions('Outlet');
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
