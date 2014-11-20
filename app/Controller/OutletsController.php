<?php

class OutletsController extends AppController {

    var $name = 'Outlets';
    var $uses = array('Outlet', 'Outletclass', 'Outletchannel', 'Retailtype', 'Product', 'Brand', 'Outletimage',
        'State', 'Subregion', 'Region', 'Lga', 'Territory', 'Location', 'Outletimage', 'Outletproduct', 'Outletmerchandize', 'Productsource');
    var $helpers = array('GoogleMap', 'TextFormater', 'Time');
    public $components = array('Paginator', 'Filter', 'SSP');

    public $paginate = array(
        'limit' => 30,
        'order' => array(
            'Outlet.created_at' => 'desc'
        )
    );

    public $urloptions = array();
    public $postoptions = array();
    
    public function beforeFilter() {
        parent::beforeFilter();

        $this->_setViewVariables();
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('outlets');
        $this->_setTitleOfPage('Outlets Management');
    }
    
    public function index() {
        
       // $this->_setBreadCrumb(array('Home', 'Outlets'));

        $pop = $this->Location->find('list');
        $lgas = $this->Lga->find('list');
        $territories = $this->Territory->find('list');
        $states = $this->State->find('list');
        $subregions = $this->Subregion->find('list');
        $regions = $this->Region->find('list');

        $outlet_count = $this->Outlet->countOutlet();
        $distrib = $this->Outlet->retailTypeDistribution();
        $least = $this->Outlet->leastCrowdedLocations();
        $most = $this->Outlet->mostCrowdedLocations();
        $outlets = $this->Outlet->getRecentOutlets(10);

        $this->set(
            array(
                'outlet_count' => $outlet_count,
                'outlets' => $outlets,
                'least_location' => $least,
                'most_location' => $most,
                'distributions' => $distrib,
                'regions' => $regions,
                'subregions' => $subregions,
                'states' => $states,
                'territories' => $territories,
                'lgas' => $lgas,
                'pop' => $pop,
            )
        );
        $this->setLegend();
    }

    private function setLegend() {

        $markers = array(
            'dot-red.png',
            'dot-blue.png',
            'dot-green.png',
            'dot-yellow.png',
            'dot-pink.png',
            'dot-purple.png',
            'dot-orange.png',
            'dot-dark-green.png',
            'dot-dark-purple.png',
            'dot-grey.png',
            'dot-light-grey.png'
        );

        $retailtypes = $this->Retailtype->getRetailtypeAsList();

        $markerIndex = array();
        $i = 0;
        foreach ($retailtypes as $key => $value) {
            $markerIndex[$key] = $i++;
        }
        $this->set('markerIndex', $markerIndex);
        $this->set('markers', $markers);
        $this->set('retailtypes', $retailtypes);
    }

    public function all() {

    }

    public function loadall() {

        //location filter [ locationname = 2, statename = 8, regionname = 9, countryname = 11]
        //Use the al for column names returned after the database is queried in data_output function in SSPComponent
        $columns = array(
            array( 
                'db' => 'outlets.outletname',
                'qry' => 'outlets.outletname as outletname',
                'al' => 'outletname', 
                'dt' => '0',),
            array( 
                'db' => 'users.username', 
                'qry' => 'users.username as username', 
                'al' => 'username', 
                'dt' => '1'),
            array( 
                'db' => 'locations.locationname', 
                'qry' => 'locations.locationname as locationname', 
                'al' => 'locationname', 
                'dt' => '2'),
            array( 
                'db' => 'outlets.contactphonenumber',
                'qry' => 'outlets.contactphonenumber as contactphonenumber',
                'al' => 'contactphonenumber',
                'dt' => '3'),
            array(
                'db' => 'outletclasses.outletclassname',
                'qry' => 'outletclasses.outletclassname as outletclassname',
                'al' => 'outletclassname',
                'dt' => '4'),
            array( 
                'db' => 'retailtypes.retailtypename',
                'qry' => 'retailtypes.retailtypename as retailtypename',
                'al' => 'retailtypename',
                'dt' => '5'),
            array( 
                'db' => 'outlets.created_at',
                'qry' => 'outlets.created_at as created_at',
                'al' => 'created_at',
                'dt' => '6'),
            array( 
                'db' => 'outlets.id',
                'qry' => 'outlets.id as id',
                'al' => 'id', 
                'dt' => '7'),
            array( 
                'db' => 'users.id',
                'qry' => 'users.id as userid',
                'al' => 'userid', 
                'dt' => '8'),
            array(
                'db' => 'states.statename',
                'qry' => 'states.statename as statename',
                'al' => 'statename', 
                'dt' => '9'),
            array(
                'db' => 'regions.regionname',
                'qry' => 'regions.regionname as regionname',
                'al' => 'regionname', 
                'dt' => '10'),
            array( 
                'db' => 'countries.countryname',
                'qry' => 'countries.countryname as countryname',
                'al' => 'countryname', 
                'dt' => '11')
        );

        $table_name = "outlets";
        $joins = " LEFT JOIN retailtypes ON retailtypes.id = outlets.retailtype_id " .
                 "LEFT JOIN locations ON locations.id = outlets.location_id " .
                 "LEFT JOIN lgas ON lgas.id = locations.lga_id " .
                 "LEFT JOIN territories ON territories.id = lgas.territory_id " .
                 "LEFT JOIN states ON states.id = territories.state_id " .
                 "LEFT JOIN subregions ON subregions.id = states.subregion_id " .
                 "LEFT JOIN regions ON regions.id = subregions.region_id " .
                 "LEFT JOIN countries ON countries.id = regions.country_id " .
                 "LEFT JOIN users ON users.id = outlets.user_id " .
                 "LEFT JOIN outletclasses ON outletclasses.id = outlets.outletclass_id ";

        $primaryKey = "outlets.id";

        // SQL server connection information
        $dbconfig = get_class_vars('DATABASE_CONFIG');
        
        $sql_details = array(
            'user' => $dbconfig['default']['login'],
            'pass' => $dbconfig['default']['password'],
            'db'   => $dbconfig['default']['database'],
            'host' => $dbconfig['default']['host'],
        );

        $response = $this->SSP->simple( $_POST , $sql_details, $table_name, $joins, $primaryKey, $columns );
        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    public function view($id = null) {

        $outlet = [];
        $outletimages = [];
        $outletproducts = [];
        $outletmerchandize = [];
        $productsources = [];

        $this->Outlet->id = $id;

        if (!$this->Outlet->exists() || !$id) {
            //$this->Session->setFlash('Invalid Outlet selected', 'page_notification_error');
            $this->redirect($this->referer());
        }

        //$this->_setBreadCrumb(array('Home','Outlets','View'));
        $outlet = $this->Outlet->outletDetails($id);

        $this->request->data = $outlet;

        $outletimages = $this->Outletimage->imagesForOutlet($id);

        $outletproducts = $this->Outletproduct->productsForOutlet($id);

        $outletmerchandize = $this->Outletmerchandize->merchandizeForOutlet($id);

        $productsources = $this->Productsource->productsourcesForOutlet($id);

        $outletclasses = $this->Outletclass->getClassAsList();
        $retailtypes = $this->Retailtype->getRetailtypeAsList();
        $userlist = $this->User->getUsersAsList();

        $this->set(
            array (
                'outlet'            => $outlet,
                'outletimages'      => $outletimages,
                'outletproducts'    => $outletproducts,
                'outletmerchandize' => $outletmerchandize,
                'productsources'    => $productsources,
                'outletclasses'     => $outletclasses,
                'retailtypes'        => $retailtypes,
                'userlist'          => $userlist
            )
        );
    }

    public function edit() {

        if($this->request->is('POST')) {

            $id = $this->request->data['id'];
            $outlet = $this->Outlet->findById($id);
            $outlet['Outlet']['outletname'] = $this->request->data['outletname'];
            $outlet['Outlet']['streetnumber'] = $this->request->data['streetnumber'];
            $outlet['Outlet']['streetname'] = $this->request->data['streetname'];
            $outlet['Outlet']['town'] = $this->request->data['town'];
            $outlet['Outlet']['contactfirstname'] = $this->request->data['contactfirstname'];
            $outlet['Outlet']['contactlastname'] = $this->request->data['contactlastname'];
            $outlet['Outlet']['contactphonenumber'] = $this->request->data['contactphonenumber'];
            $outlet['Outlet']['contactalternatenumber'] = $this->request->data['contactalternatenumber'];
            $outlet['Outlet']['vtunumber'] = $this->request->data['vtunumber'];
            $outlet['Outlet']['outletclass_id'] = $this->request->data['outletclass_id'];
            $outlet['Outlet']['retailtype_id'] = $this->request->data['retailtype_id'];
            $outlet['Outlet']['user_id'] = $this->request->data['user_id'];
            $outlet['Outlet']['updated_at'] = $this->_createNowTimeStamp();

            if($this->Outlet->save($outlet)) {
                $this->Session->setFlash('Outlet has been updated successfully!', 'page_notification_info');
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash('Unable to updated outlet. Please, try again', 'page_notification_error');
            }
        } else {
            $this->view = 'index';
        }
    }

    public function _getMerchandingForVisit($visitId) {
        $VE_options['fields'] = array(
            'Visibilityevaluation.id',
            'Visibilityevaluation.visitid',
            'Brand.brandname',
            'Brandelement.brandelementname',
            'Visibilityevaluation.elementcount'
        );
        $VE_options['order'] = array('Visibilityevaluation.createdat DESC');
        $VE_options['recursive'] = -1;
        $VE_options['joins'] = array(
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brandelement.id = Visibilityevaluation.visibilityelementid'
                )
            ),
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brand.id = Visibilityevaluation.brandid'
                )
            )
        );
        
        $VE_options['conditions'] = array('visitid' => $visitId);
        $merchandising = $this->Visibilityevaluation->find("all", $VE_options);
        return $merchandising;
    }

    public function _getSalesForVisit($visitId) {
        $OD_options['fields'] = array(
            'Order.id',
            'Order.visitid',
            'Order.quantity',
            'Order.discount',
            'Orderstatus.id',
            'Orderstatus.orderstatusname',
            'Outlet.id',
            'Outlet.outletname',
            'Product.id',
            'Product.productname'
        );
        $OD_options['order'] = array('Order.createdat DESC');
        $OD_options['recursive'] = -1;
        $OD_options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Order.visitid'
                )
            ),
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Order.productid'
                )
            ),
            array(
                'table' => 'orderstatuses',
                'alias' => 'Orderstatus',
                'type' => 'LEFT',
                'conditions' => array(
                    'Orderstatus.id = Order.orderstatusid'
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

        $OD_options['conditions'] = array('visitid' => $visitId);
        $sales = $this->Order->find("all", $OD_options);
        return $sales;
    }

    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid outlet selected', 'page_notification_error');
            $this->redirect($this->referer());
        }

        $this->Outlet->id = $id;

        if ($this->Outlet->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Outlet has been deleted', 'page_notification_info');
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash('Unable to delete outlet. Please, try again', 'page_notification_error');
        }
    }

    public function outletlocations() {


        $locations = [];
        $outletsLocation = $this->Outlet->outletGeolocations();

        foreach ($outletsLocation as $loc) {
            $name = $loc['Outlet']['outletname'];
            $pos = $loc['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $lon = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1]))
                continue;
            $lat = floatval($arrLatLng[1]);
            $locations[] = array('outletname' => $name, 'latitude' => $lat, 'longitude' => $lon);
        }

        $jsonresponse = json_encode($locations);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    public function outletclassdistribution() {

        $resp = [];
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];

        $rs = $this->Outlet->outletClassDistribution();

        $total = $this->Outlet->countOutlet();

        $i = 0;

        foreach ($rs as $value) {
            $data['name'] = $value['Outletclass']['outletclassname'];
            $data['y'] = intval($value[0]["count"]);
            // if ($data['y'] > $max) {
            //     $max = $data['y'];
            //     $max_index = $i;
            // }
            $data['color'] = $colors[$i];
            $resp[] = $data;
            $i++;
        }

        // $resp[$max_index]['selected'] = true;
        // $resp[$max_index]['sliced'] = true;

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    public function outletchanneldistribution() {

        $resp = [];
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];
        $rs = $this->Outlet->outletChannelDistribution();
        $total = $this->Outlet->countOutlet();
        $i = 0;

        foreach ($rs as $value) {
            $data['name'] = $value['Outletchannel']['outletchannelname'];
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

    public function retailtypedistribution() {

        $resp = [];
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];
        $rs = $this->Outlet->retailTypeDistribution();
        $total = $this->Outlet->countOutlet();
        $i = 0;

        foreach ($rs as $value) {
            $data['name'] = $value['Retailtype']['retailtypename'];
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

    public function outletperformance() {

        $options = $this->urloptions;
        $rs = $this->Outlet->PerformanceTrend($options);

//        debug($rs);
        $response = array();
        $len = count($rs);
        $i = 0;
        $formerdate = new DateTime($rs[$i]['Outlet']['created_at']);
        $pointstart = new DateTime($rs[$i]['Outlet']['created_at']);
        $response[] = intval($rs[$i][0]['count']);

        do {
            if(!isset($rs[$i + 1][0]['count'])) break;

            $count = $rs[$i + 1][0]['count'];
            $created_at = new DateTime($rs[$i + 1]['Outlet']['created_at']);

            $currDay = $created_at->format('j');
            $formerDay = $formerdate->format('j');

            $formerTotalNoOfDaysInMonth = $formerdate->format('t');

            if (($formerDay + 1) == $currDay) {
                $response[] = intval($rs[$i + 1][0]['count']);
            } else {
                if (($formerDay + 1) <= $formerTotalNoOfDaysInMonth) {
                    $response[] = 0;
                } else {
                    if ($currDay == 1) {
                        $response[] = intval($rs[$i + 1][0]['count']);
                    } else {
                        $formerdate->modify("+1 days");
                        continue;
                    }
                }
            }

            $formerdate = $created_at;
            $i++;
        } while ($i != $len - 1);

        $series_data['type'] = 'area';
        $series_data['name'] = 'Total Outlet';
        $series_data['pointInterval'] = 24 * 3600 * 1000;
        $series_data['pointStart'] = strtotime($pointstart->format('Y-m-d')) * 1000;
        $series_data['data'] = $response;

        $jsonresponse = json_encode($series_data);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }



    public function _generateRandomHexadecimalColorCode() {
        $min = 0;
        $max = 15;
        $hexa_digit = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'A', 'B', 'C', 'D', 'E', 'F');
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $hexa_digit[intval(rand($min, $max))];
        }
//        debug('generated color: ' + $color);
        return $color;
    }
    
    public function generateoutletsdatedata() {

        //Generate Actual Visits - for Visit Model
        $test_data = array();
        for ($i = 4000; $i <= 5148; $i++) {   //1532
            $test_data['Outlet']['id'] = $i;
            $test_data['Outlet']['createdat'] = date('Y-m-d H:i:s', rand(1385856000, 1396310400));

            $response[] = $test_data;
        }

        $this->Outlet->SaveAll($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', json_encode($response));
    }
}
