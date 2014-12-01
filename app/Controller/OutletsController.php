<?php

class OutletsController extends AppController {

    var $name = 'Outlets';
    var $uses = array('Outlet', 'Outletclass', 'Outletchannel', 'Retailtype', 'Product', 'Brand', 'Outletimage',
        'State', 'Subregion', 'Region', 'Lga', 'Territory', 'Location', 'Outletimage', 'Outletproduct', 'Outletmerchandize', 'Productsource');
    var $helpers = array('GoogleMap', 'TextFormater', 'Time');
    public $components = array('Paginator', 'PagerHelper', 'Filter', 'SSP');

    public $urloptions = array();
    public $postoptions = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();
        $this->urloptions = $this->Filter->getUrlFilterOptions('Outlet');
        $this->postoptions = $this->Filter->getPostDataFilterOptions('Outlet');
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

        $outlet_count = $this->Outlet->countOutlet($this->postoptions);
        $distrib = $this->Outlet->retailTypeDistribution($this->postoptions);
        $least = $this->Outlet->leastCrowdedLocations($this->postoptions);
        $most = $this->Outlet->mostCrowdedLocations($this->postoptions);
        $outlets = $this->Outlet->getRecentOutlets(10, $this->postoptions);

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

    public function paginatedOutlets() {

        $dataResponse = [];

        $options = $this->Filter->getUrlFilterOptions('Outlet');
        $options['order'] = array('Outlet.created_at' => 'DESC');



        $pagOptions = $this->getParamOptions($options);

        $paginatedOutlets = $this->Outlet->getPaginatedOutlets($this->Paginator, $options);

        $this->PagerHelper->setParams($pagOptions['count'], $pagOptions['pgSize'], $pagOptions['page']);
        $pagers = $this->PagerHelper->getPagesForLinks(7);

        $dataResponse['outlets'] = $paginatedOutlets;
        $dataResponse['pagination'] = $pagers;
        $jsonresponse = json_encode($dataResponse);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    private function getParamOptions(&$options) {

        $request = $this->request;

        $page = isset($request['url']['page']) ? $request['url']['page'] : 0;
        $pgSize = isset($request['url']['pgSize']) ? $request['url']['pgSize'] : 25;
        if(isset($request['url']['srt'])) {
            $this->setSortOptions($options, $request['url']['srt']);
        }
        if(isset($request['url']['q'])) {
            $q = $request['url']['q'];

            $options['conditions']['OR'] = array(
                'Outlet.outletname LIKE' => "%{$q}%",
                'Location.locationname LIKE' => "%{$q}%"
            );
        }

        $count = $this->Outlet->getPaginatedOutlets($this->Paginator, $options, true);

        return $this->setPaginateOptions($options, $page, $pgSize, $count);
    }

    private function setSortOptions(&$options, $sortString) {

        if(strpos($sortString, ':') != -1) {
            $arrSort = explode(':', $sortString);
            $srtColumn = $arrSort[0];
            $srtDirection = isset($arrSort[1]) ? $arrSort[1] : 'ASC';

            $options['order'] = array($srtColumn => $srtDirection);
        }
    }

    private function setPaginateOptions(&$options, $page, $pageSize, $count)
    {
        //if the page number requested for is more than the last page number
        //serve the last page
        $lastPage = intval(ceil($count / $pageSize)) - 1;

        if ($lastPage < $page) {
            $page = $lastPage;
        }

        //if the page number requested for is less than the first page number
        //serve the first page
        if ($page < 0) {
            $page = 0;
        }

        $offset = $page * $pageSize;
        $limit = $pageSize;

        $options['limit'] = $limit;
        $options['offset'] = $offset;

        return array('page' => $page, 'pgSize' => $pageSize, 'count' => $count);
    }
    //End pagination for outlet display all


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
        $options = $this->urloptions;
        $outletsLocation = $this->Outlet->outletGeolocations($options);

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
        $i = 0;
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];

        $options = $this->urloptions;
        $rs = $this->Outlet->outletClassDistribution($options);
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
        $i = 0;
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];

        $options = $this->urloptions;
        $rs = $this->Outlet->outletChannelDistribution($options);
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
        $i = 0;

        $options = $this->urloptions;
        $rs = $this->Outlet->retailTypeDistribution($options);
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

    public function reversegeolocation() {
        $outletsGeolocations = $this->Outlet->find('all', array(
            'fields' => array('id', 'geolocation'),
            'conditions' => array('id >=' => '4554')
        ));

        foreach($outletsGeolocations as &$geolocation) {
            $geolocWithBracket = $geolocation['Outlet']['geolocation'];
            $geoloc = substr($geolocWithBracket, 1, strlen($geolocWithBracket) - 2);
            $splitArray = explode(',', $geoloc);
            $geolocation['Outlet']['geolocation'] = "[{$splitArray[1]},{$splitArray[0]}]";
        }

        $this->Outlet->saveMany($outletsGeolocations);
        //var_dump($outletsGeolocations);
        //$this->Outlet->SaveAll($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', json_encode($outletsGeolocations));

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
