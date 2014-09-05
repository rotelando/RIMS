<?php

class VisitsController extends AppController {

    var $name = 'Visits';
    var $uses = array('Visit', 'Schedule', 'Productavailability', 'Visibilityevaluation', 'Order', 'Note', 'Image');
    var $helpers = array('Time');
    public $components = array('Paginator', 'Filter', 'SSP');

    public $urloptions = array();
    public $postoptions = array();
    
    public function index() {
        
        $this->_visitaccuracy();
        $this->_averageTimeSpentForVisit();
        
        $actualVisit = $this->_getActualVisitToday();
        $plannedVisit = $this->_getPlannedVisitToday();
        $targetVisit = $this->_getTargetVisitToday();
        
        $divplannedVisit = ($plannedVisit == 0) ? 1 : $plannedVisit;
        $actvsplanned = intval(($actualVisit * 100) / $divplannedVisit);
        
        $divtargetVisit = ($targetVisit == 0) ? 1 : $targetVisit;
        $actvstarget = intval(($actualVisit * 100) / $divtargetVisit);
        $planvstarget = intval(($plannedVisit * 100) / $divtargetVisit);
        
        $modelcounts['actualvsplannedvisit'] = $actualVisit . '/' . $plannedVisit;
        $modelcounts['percentageactualvsplannedvisit'] =  $actvsplanned . ' %';
        $modelcounts['percentageactualvstargetvisit'] = $actvstarget . ' %';
        $modelcounts['percentageplannedvstargetvisit'] = $planvstarget . ' %';
        $modelcounts['visitexceptions'] = $this->_getVisitExceptionsToday();
        
        $this->set($modelcounts);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedVisitModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
//        
        $this->urloptions = $this->Filter->getUrlFilterOptions($this->modelClass);
        $this->postoptions = $this->Filter->getPostDataFilterOptions($this->modelClass);
//        debug($this->urloptions);
//        debug($this->postoptions);
        
        $this->_getFilterDisplayText($this->Filter->getFilterText($this->modelClass)); //set the filter text on the page title
        
        $this->_setViewVariables();
        $this->_fetchAndSetAllVisits(10);
        $images = $this->_getResentImages(6);
        $this->set('images', $images);
        //get current user settings :)
        $this->setCurrentUserSettings();
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('visits');
        $this->_setTitleOfPage('Visits Management');
    }

    //All visit in the visit table are completed!
    private function _fetchAndSetAllVisits($limit) {

        $this->postoptions = $this->Filter->getPostDataFilterOptions($this->modelClass);
        $options = $this->postoptions;
        
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Visit.id',
            'Visit.starttimestamp',
            'Visit.stoptimestamp',
            'Visit.duration',
            'Visit.distancefromoutlet',
            'Location.locationname'
        );
        $options['order'] = array('Visit.createdat DESC');
        $options['limit'] = $limit;
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
        
        $visits = $this->Visit->find('all', $options);
        $this->set(array('visits' => $visits));
    }

    private function _visitaccuracy() {
        
        $options = $this->Filter->getPostDataFilterOptions('Schedule');
        $actual = $this->Visit->find('count', $options);
        $options['conditions']['Schedule.outletid NOT'] = array('0, -1');
        $planned = $this->Schedule->find('count', $options);
        
        $settings = $this->setCurrentUserSettings();
        $target = intval($settings['Setting']['TargetVisit']);
        if($planned != 0) {
            $actual_vs_planned = intval(($actual / $planned) * 100);
        } else {
            $actual_vs_planned = 100;
        }
        
        if(isset($target) || $target > 0) {
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

    public function visitperformance() {

        
        $options = $this->Filter->getUrlFilterOptions('Schedule');
        
        if(!isset($options['conditions']["DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }
        
        $response = [];
        
        $options['fields'] = array(
            "Schedule.scheduledate", 
            'COUNT(Schedule.scheduledate) as Count'
        );
        $options['group'] = array('Schedule.scheduledate');
        $options['order'] = array('Schedule.scheduledate asc');
        
        $rs = $this->Schedule->find('all', $options);


        foreach ($rs as $value) {
            $count = intval($value[0]["Count"]);
            $datevalue = $value['Schedule']['scheduledate'];
            $response['planned'][] = [ strtotime($datevalue) * 1000, $count];
        }


        
        //Actual Visits
        $options = array();
        $options = $this->Filter->getUrlFilterOptions('Visit');
        if(!isset($options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( Visit.createdat,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }
         $options['fields'] = array(
            "DATE_FORMAT(FROM_UNIXTIME(`Visit`.`stoptimestamp`),'%Y-%m-%d') as visitstoptime", 
            'COUNT(Visit.stoptimestamp) as Count'
        );
        $options['group'] = array('visitstoptime');
        $options['order'] = array('Visit.stoptimestamp asc');
        
        $rs_ac = $this->Visit->find('all', $options);

        foreach ($rs_ac as $value_ac) {
            $count = intval($value_ac[0]["Count"]);
            $datevalue = $value_ac[0]['visitstoptime'];
            $response['actual'][] = [ strtotime($datevalue) * 1000, $count];  //Note that stoptimestamp in Visit table is a long value
        }

        
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        
//        $this->set('response', print_r($response));
        $this->set('response', json_encode($response));
        
    }

    public function all($sort = 'id') {
        
//        debug($this->request->data);
        
        // if ($sort == 'outletname')
        //     $colname = 'Outlet.outletname';
        // else if ($sort == 'startdate')
        //     $colname = 'Visit.starttimestamp';
        // else if ($sort == 'stopdate')
        //     $colname = 'Visit.stoptimestamp';
        // else
        //     $colname = 'Visit.id';

        
        // $options = $this->Filter->getPostDataFilterOptions($this->modelClass);
        // $options['limit'] = 25;
        // $options['order'] = array("{$colname}" => 'desc');

        // $this->Paginator->settings = $options;

        // $visits = $this->Paginator->paginate('Visit');

        // $this->set('visits', $visits);
//        debug($visits);
    }

    public function loadall() {

        //Use the al for column names returned after the database is queried in data_output function in SSPComponent
        $columns = array(
            array( 
                'db' => 'outlets.outletname',
                'qry' => 'outlets.outletname as outletname',
                'al' => 'outletname', 
                'dt' => '0'),
            array( 
                'db' => 'visits.starttimestamp',
                'qry' => 'visits.starttimestamp as starttimestamp',
                'al' => 'starttimestamp', 
                'dt' => '1'),
            array( 
                'db' => 'visits.stoptimestamp',
                'qry' => 'visits.stoptimestamp as stoptimestamp', 
                'al' => 'stoptimestamp', 
                'dt' => '2'),
            array(
                'db' => 'visits.duration',
                'qry' => 'visits.duration as duration',
                'al' => 'duration', 
                'dt' => '3'),
            array( 
                'db' => 'visits.distancefromoutlet',
                'qry' => 'visits.distancefromoutlet as distancefromoutlet',
                'al' => 'distancefromoutlet', 
                'dt' => '4'),
            array( 
                'db' => 'visits.createdat',
                'qry' => 'visits.createdat as createdat',
                'al' => 'createdat', 
                'dt' => '5'),
            array( 
                'db' => 'visits.id',
                'qry' => 'visits.id as id',
                'al' => 'id', 
                'dt' => '6'),
            array( 
                'db' => 'outlets.id',
                'qry' => 'outlets.id as out_id', 
                'al' => 'out_id', 
                'dt' => 'out_id')
        );

        $table_name = "visits";
        $joins = " LEFT JOIN outlets ON outlets.id = visits.outletid " .
                 "LEFT JOIN locations ON locations.id = outlets.locationid " .
                 "LEFT JOIN users ON users.id = outlets.userid ";

        $primaryKey = "visits.id";

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
    
    public function planned() {

        $options = $this->Filter->getPostDataFilterOptions('Schedule');
        
        $options['fields'] = array(
            'Schedule.id',
            'Schedule.scheduledate',
            'Schedule.visited',
            'Schedule.createdat',
            'Outlet.id',
            'Outlet.outletname',
            'User.id',
            'User.firstname',
            'User.lastname'
        );
        $options['order'] = array('Schedule.createdat DESC');
        $options['limit'] = 25;
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
        
        $this->Paginator->settings = $options;

        $visits = $this->Paginator->paginate('Schedule');
//        debug($visits);
        $this->set('visits', $visits);
    }

    public function delete($id) {
        if (!$id) {

            $this->Session->setFlash('Invalid visit selected', 'page_notification_error');
            $this->redirect($this->redirect($this->referer()));
        }

        $this->Visit->id = $id;

        if ($this->Visit->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Visit has been deleted', 'page_notification_info');
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash('Unable to delete visit. Please, try again', 'page_notification_error');
        }
    }

    public function edit($id) {
        
    }

    public function view($id) {
        //Visit
        $this->Visit->id = $id;

        if (!$this->Visit->exists() || !$id) {
            $this->Session->setFlash('Invalid visit selected', 'page_notification_error');
            $this->redirect($this->referer());
        }

        //get information for a visit
        $visit = $this->Visit->findById($id);
        
        //----------------- get product availabilities for a visit -----------------//
        $PA_options['fields'] = array(
            'Productavailability.id',
            'Product.productname',
            'Productavailability.quantityavailable',
            'Productavailability.unitprice',
            'Productavailability.purchasepoint'
        );
        $PA_options['order'] = array('Productavailability.createdat DESC');
        $PA_options['conditions'] = array('visitid' => $id);
        $PA_options['recursive'] = -1;
        $PA_options['joins'] = array(
            
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Productavailability.productid'
                )
            )
        );
        $productavailabilities = $this->Productavailability->find('all', $PA_options);
        
        //----------------- Get visibility evaluations for a particular visit -----------------//
        $VE_options['fields'] = array(
            'Visibilityevaluation.id',
            'Brand.brandname',
            'Brandelement.brandelementname',
            'Visibilityevaluation.elementcount'
        );
        $VE_options['order'] = array('Visibilityevaluation.createdat DESC');
        $VE_options['conditions'] = array('visitid' => $id);
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
        $visibilityevaluations = $this->Visibilityevaluation->find('all', $VE_options);
        
        //----------------- get orders for a visit with $id -----------------//
        $orders = $this->Order->find('all', array(
            'fields' => array(
                'Order.id',
                'Order.quantity',
                'Order.discount',
                'Orderstatus.id',
                'Orderstatus.orderstatusname',
                'Outlet.id',
                'Outlet.outletname',
                'Product.id',
                'Product.productname'
            ),
            'order' => array('Order.createdat DESC'),
            'conditions' => array('visitid' => $id),
            'recursive' => -1,
            'joins' => array(
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
                )
            )
                )
        );

        
        //get notes for a visit (id)
        $NOT_options['fields'] = array(
            'Note.id',
            'Note.note',
            'Note.createdat'
        );
        $NOT_options['order'] = array('Note.createdat DESC');
        $NOT_options['conditions'] = array('visitid' => $id);
        $NOT_options['recursive'] = -1;
        $NOT_options['joins'] = array(
            
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Note.visitid = Visit.id'
                )
            )
        );
        $notes = $this->Note->find('all', $NOT_options);
        //get images for a particular visit
        $images = $this->_getResentImages(6, $id);

        $this->set(array(
            'visit' => $visit,
            'productavailabilities' => $productavailabilities,
            'orders' => $orders,
            'visibilityevaluations' => $visibilityevaluations,
            'notes' => $notes,
            'images' => $images
        ));
    }

    public function visitlocations() {
        
        $options = $this->Filter->getUrlFilterOptions('Schedule');
        $options['conditions']['visited'] = 1;
        $options['recursive'] = -1;
        $options['fields'] = array(
            'Outlet.geolocation', 
            'Outlet.outletname'
        );
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
         
        $visitedLocation = $this->Schedule->find('all', $options);
        
        $options['conditions']['visited'] = array('IN' => array(0, null));
        $unvisitedLocation = $this->Schedule->find('all', $options);

        foreach ($visitedLocation as $visited) {
            $name = $visited['Outlet']['outletname'];
            $pos = $visited['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $lon = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1]))
                continue;
            $lat = floatval($arrLatLng[1]);
            $locations[] = array('outletname' => $name, 'latitude' => $lat, 'longitude' => $lon, 'visited' => true);
        }
        foreach ($unvisitedLocation as $unvisited) {
            $name = $unvisited['Outlet']['outletname'];
            $pos = $unvisited['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $lon = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1]))
                continue;
            $lat = floatval($arrLatLng[1]);
            $locations[] = array('outletname' => $name, 'latitude' => $lat, 'longitude' => $lon, 'visited' => false);
        }

        $jsonresponse = json_encode($locations);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    //recent visit images
    private function _getResentImages($number, $id = null) {
        
        
        if(!is_null($id)) {
            $options['conditions']['Image.visitid'] = $id;
        } else {
            $options = $this->Filter->getPostDataFilterOptions($this->modelClass);
        }
        
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

        $images = $this->Image->find('all', $options);
        return $images;
    }

    private function _averageTimeSpentForVisit() {
        
        $options = $this->Filter->getPostDataFilterOptions('Visit');
        $options['fields'] = array(
            'AVG(Visit.stoptimestamp - Visit.starttimestamp) as average'
        );
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
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
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
        
        $avgTimeInSec = $this->Visit->find('all', $options);
        $avgTime = date('h:i:s', intval($avgTimeInSec[0][0]['average']));
        $this->set('avgTimeSpent', $avgTime);
    }
    
    function _getPlannedVisitToday() {
        $today = date('Y-m-d');
        $options['conditions']["DATE_FORMAT( createdat,  '%Y-%m-%d' )"] = $today;
        $options['recursive'] = -1;
        $plannedvisit = $this->Schedule->find('count', $options);
        return $plannedvisit;
    }
    
    function _getActualVisitToday() {
        $today = date('Y-m-d');
        $options['conditions']["DATE_FORMAT( createdat,  '%Y-%m-%d' )"] = $today;
        $options['recursive'] = -1;
        $actualvisit = $this->Visit->find('count', $options);
        return $actualvisit;
    }
    
    function _getTargetVisitToday() {
        $settings = $this->setCurrentUserSettings();
        $targetVisit = intval($settings['Setting']['TargetVisit']);
        return $targetVisit;
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

    //Helper Generator
    public function generatevisitdata() {

        //Generate Planned Visits
        $schedule_data = [];
        $response_schedule_data = [];
        $visit_data = [];
        $response_visit_data = [];
        $response = [];
        
        
        for ($j = 1219, $i = 1520; $i <= 1650; $i++) {

            $schedule_data['Schedule']['id'] = $i;
            $schedule_data['Schedule']['scheduledate'] = date('Y-m-d', rand(1385856000, 1396310400));
            $schedule_data['Schedule']['outletid'] = rand(1, 5148);
            $schedule_data['Schedule']['visited'] = 1;
//            $schedule_data['Schedule']['visited'] = 0;
//            $schedule_data['Schedule']['visited'] = rand(0, 1);
            $schedule_data['Schedule']['createdat'] = date('Y-m-d H:i:s', rand(1385856000, 1396310400));
            
            
            if($schedule_data['Schedule']['visited'] == 1) {
                $visit_data['Visit']['id'] = $j++;
                $visit_data['Visit']['outletid'] = $schedule_data['Schedule']['outletid'];
                $visit_data['Visit']['starttimestamp'] = strtotime($schedule_data['Schedule']['createdat']);
                $visit_data['Visit']['stoptimestamp'] = $visit_data['Visit']['starttimestamp'] + rand(1800, 3600 * 2);

                $visit_data['Visit']['duration'] = $visit_data['Visit']['stoptimestamp'] - $visit_data['Visit']['starttimestamp'];
                $visit_data['Visit']['geolocation'] = '[' . rand(5,11).'.'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9). ','. rand(6,11).'.'. rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9) . ']';
                $visit_data['Visit']['distancefromoutlet'] = rand(70, 250);
                $visit_data['Visit']['createdat'] = date('Y-m-d H:i:s', $visit_data['Visit']['stoptimestamp']);
                $response_visit_data[] = $visit_data;
                
                $prod_avail_count = rand(1, 2);
                $visitid = $visit_data['Visit']['id'];
                $createdat = $visit_data['Visit']['createdat'];
                $this->_generateproductavailabilitydata($visitid, $prod_avail_count, $createdat);
                $order_count = rand(1, 2);
                $this->_generateordersdata($visitid, $order_count, $createdat);
                $vis_count = rand(1, 10);
                $this->_generatevisibilitydata($visitid, $vis_count, $createdat);
            }
            
            $response_schedule_data[] = $schedule_data;
        }
        
        $this->Schedule->saveMany($response_schedule_data);
        $this->Visit->saveMany($response_visit_data);
        
        $response['data']['scheduled'] = $response_schedule_data;
        $response['data']['visit'] = $response_visit_data;
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', json_encode($response));
    }
    
    //Helper Generator
    private function _generateproductavailabilitydata($visitid, $count, $createdat) {
        $purchasepoint = [ 1 => "Benson Products", "Kenny Ventures", "Beat Enterprises", "Cardilous", "Spectacles Limited"];
        $unitprice = [100, 200, 400, 500, 750, 1000, 1500];
        //Generate Planned Visits
        $test_data = array();
        for ($i = 1; $i <= $count; $i++) {
//            $test_data['Productavailability']['id'] = $i;
            $test_data['Productavailability']['visitid'] = $visitid;
            $test_data['Productavailability']['productid'] = rand(1, 10);
            $test_data['Productavailability']['quantityavailable'] = rand(1, 20);
            $test_data['Productavailability']['unitprice'] = $unitprice[rand(1, 4)];
            $test_data['Productavailability']['purchasepoint'] = $purchasepoint[rand(1, 5)];
            $test_data['Productavailability']['createdat'] = $createdat;
            $response[] = $test_data;
        }
        $this->Productavailability->saveMany($response);
    }
    
    private function _generateordersdata($visitid, $count, $createdat) {

        //Generate Actual Visits - for Visit Model
        $test_data = array();
        for ($i = 1; $i <= $count; $i++) {

//            $test_data['Order']['id'] = $i;
            $test_data['Order']['visitid'] = $visitid;
            $test_data['Order']['productid'] = rand(1, 8);
            $test_data['Order']['quantity'] = rand(1, 20);
            $test_data['Order']['discount'] = floatval('0.' . rand(1, 2) . rand(0, 5));
            $test_data['Order']['status'] = rand(0, 1);
            $test_data['Order']['createdat'] = $createdat;

            $response[] = $test_data;
        }
        $this->Order->SaveAll($response);
    }
    
    private function _generatevisibilitydata($visitid, $count, $createdat) {

        //Generate Visibility Evaluation data
        $test_data = array();
        for ($i = 1; $i <= $count; $i++) {

//            $test_data['Visibilityevaluation']['id'] = $i;
            $test_data['Visibilityevaluation']['visitid'] = $visitid;
            $test_data['Visibilityevaluation']['brandid'] = rand(3, 4);
            $test_data['Visibilityevaluation']['visibilityelementid'] = rand(1, 4);
            $test_data['Visibilityevaluation']['elementcount'] = rand(1, 10);
            $test_data['Visibilityevaluation']['createdat'] = $createdat;

            $response[] = $test_data;
        }

        $this->Visibilityevaluation->SaveAll($response);
    }

}