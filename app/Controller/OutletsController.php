<?php

class OutletsController extends AppController {

    var $name = 'Outlets';
    var $uses = array('Outlet', 'Outlettype', 'Outletchannel', 'Location', 'Visit', 'Visibilityevaluation', 'Order',
        'Productavailability', 'Product', 'Brand', 'Image', 'State', 'Town', 'Region', 'LocationGroup');
    var $helpers = array('GoogleMap', 'TextFormater', 'Time');
    public $components = array('Paginator', 'Filter', 'SSP');
    public $paginate = array(
        'limit' => 30,
        'order' => array(
            'Outlet.createdat' => 'desc'
        )
    );

    public $urloptions = array();
    public $postoptions = array();
    
    public function beforeFilter() {
        parent::beforeFilter();

        $this->_setViewVariables();
        
        $this->urloptions = $this->Filter->getUrlFilterOptions($this->modelClass);
        $this->postoptions = $this->Filter->getPostDataFilterOptions($this->modelClass);
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('outlets');
        $this->_setTitleOfPage('Outlets Management');
    }
    
    public function index() {
        
        $this->_setBreadCrumb(array('Home', 'Outlets'));
        $this->_fetchAndSetAllOutlets(10);

        $distrib = $this->_outletdistribution(true);
        
        $least = $this->_leastCrowdedLocations();
        $most = $this->_mostCrowdedLocations();
        $states = $this->State->find('list');
        $pop = $this->LocationGroup->find('list');
        $territories = $this->Location->find('list');
        $regions = $this->Region->find('list');

        $this->set(array
            (
                'least_location' => $least, 
                'most_location' => $most, 
                'distributions' => $distrib,
                'regions' => $regions,
                'states' => $states,
                'pop' => $pop,
                'territories' => $territories
            ));

        $this->_getLegend();
    }

    private function _getOutletTypes() {
        $outlettypes = $this->Outlettype->find('list');
        return $outlettypes;
    }
    
    private function _getLegend() {
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
        $outlettypes = $this->_getOutletTypes();
        
        $markerIndex = array();
        $i = 0;
        foreach ($outlettypes as $key => $value) {
            $markerIndex[$key] = $i++;
        }
        $this->set('markerIndex', $markerIndex);
        $this->set('markers', $markers);
        $this->set('outlettypes', $outlettypes);
//        debug($markerIndex);
//        debug($markers);
//        debug($outlettypes);
    }

    public function distributions() {
        
    }

    public function all() {

        // $options = $this->postoptions;
        $this->_setBreadCrumb(array('Home','Outlets','All Outlets'));
        // $options['limit'] = 2000;
        
        // $outletname = isset($this->params['url']['query']) ? $this->params['url']['query'] : null;
        // if(!is_null($outletname)) {
        //     $options['conditions']['Outlet.outletname LIKE'] = "%{$outletname}%";
        // }
        
        // $typeid = isset($this->params['url']['otype']) ? $this->params['url']['otype'] : null;
        // if(!is_null($typeid)) {
        //     $options['conditions']['Outlet.outlettypeid'] = $typeid;
        // }
        
        
        // $this->Paginator->settings = $options;
        // $outlets = $this->Paginator->paginate('Outlet');

        
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
                'db' => 'outlets.phonenumber', 
                'qry' => 'outlets.phonenumber as phonenumber', 
                'al' => 'phonenumber',
                'dt' => '3'),
            array( 
                'db' => 'outlettypes.outlettypename', 
                'qry' => 'outlettypes.outlettypename as outlettypename', 
                'al' => 'outlettypename', 
                'dt' => '4'),
            array( 
                'db' => 'outletchannels.outletchannelname', 
                'qry' => 'outletchannels.outletchannelname as outletchannelname', 
                'al' => 'outletchannelname', 
                'dt' => '5'),
            array( 
                'db' => 'outlets.createdat',
                'qry' => 'outlets.createdat as createdat',
                'al' => 'createdat', 
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
        $joins = " LEFT JOIN outlettypes ON outlettypes.id = outlets.outlettypeid " .
                 "LEFT JOIN locations ON locations.id = outlets.locationid " .
                 "LEFT JOIN states ON states.id = locations.stateid " .
                 "LEFT JOIN regions ON regions.id = states.regionid " .
                 "LEFT JOIN countries ON countries.id = states.countryid " .
                 "LEFT JOIN users ON users.id = outlets.userid " .
                 "LEFT JOIN outletchannels ON outletchannels.id = outlets.outletchannelid ";

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

//        App::uses('CakeTime', 'Utility');

        $this->Outlet->id = $id;

        if (!$this->Outlet->exists() || !$id) {
            $this->Session->setFlash('Invalid oOutlet selected', 'page_notification_error');
            $this->redirect($this->referer());
        }

        $this->_setBreadCrumb(array('Home','Outlets','View'));
        $this->set(array('outlet' => $this->Outlet->read()));
        $this->request->data = $this->Outlet->read();

        $outletdata = $this->request->data;
        $visit_ids = array();
        if (isset($outletdata["Visit"])) {
            foreach ($outletdata["Visit"] as $visit) {
                $visit_ids[] = $visit["id"];
            }
            $merchandising = $this->_getMerchandingForVisit($visit_ids);
            $sales = $this->_getSalesForVisit($visit_ids);
            $prodavail = $this->_getProductAvailabilityForVisit($visit_ids);
            
        }

        $images = $this->_getResentImages(null, $id);  //$id = outlet id
        
        $this->set(
                array(
                    'merchandising' => $merchandising,
                    'sales' => $sales,
                    'prodavail' => $prodavail,
                    'images' => $images
                )
        );
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

//        $sales = array();
//        foreach ($visitId as $id) {
//            $OD_options['conditions'] = array('visitid' => $id);
//            $temp_sales = $this->Order->find("all", $OD_options);
//            $sales = array_merge($sales, $temp_sales);
//        }
        $OD_options['conditions'] = array('visitid' => $visitId);
        $sales = $this->Order->find("all", $OD_options);
        return $sales;
    }

    public function _getProductAvailabilityForVisit($visitId) {
        $PA_options['fields'] = array(
            'Productavailability.id',
            'Productavailability.visitid',
            'Product.productname',
            'Productavailability.quantityavailable',
            'Productavailability.unitprice',
            'Productavailability.purchasepoint'
        );
        $PA_options['order'] = array('Productavailability.createdat DESC');
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

//        $prodavail = array();
//        foreach ($visitId as $id) {
//            $PA_options['conditions'] = array('visitid' => $id);
//            $temp_prodavail = $this->Productavailability->find("all", $PA_options);
//            $prodavail = array_merge($prodavail, $temp_prodavail);
//        }
        $PA_options['conditions'] = array('visitid' => $visitId);
        $prodavail = $this->Productavailability->find("all", $PA_options);
        return $prodavail;
    }
    
    private function _getResentImages($limit, $id = null) {
        
        if(!is_null($id)) {
            $options['conditions']['Outlet.id'] = $id;
        } else {
            $options = $this->postoptions;
        }
        
        if(!is_null($limit)) {
            $options['limit'] = $limit;
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

    public function outletdetails($id) {
        
    }

    private function _fetchAndSetAllOutlets($number = null) {
        
        $options = $this->postoptions;
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.contactfirstname',
            'Outlet.contactlastname',
            'Outlet.phonenumber',
            'Outlettype.outlettypename',
            'Outletchannel.outletchannelname',
            'Location.locationname'
        );
        $options['order'] = array('Outlet.id DESC');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outletchannels',
                'alias' => 'Outletchannel',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletchannel.id = Outlet.outletchannelid'
                )
            ),
            array(
                'table' => 'outlettypes',
                'alias' => 'Outlettype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlettype.id = Outlet.outlettypeid'
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

        $outlets = $this->Outlet->find('all', $options);
        // debug($outlets);
        $this->set(array('outlets' => $outlets));
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

    public function outletdistr() {
    
        $response = json_encode($this->_outletdistribution(true));
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
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

    public function outletdistribution() {

        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];
        //Unbind Visit from Outlet to control the amount of data pulled from the database
        $this->Outlet->unbindModel(
                array('hasMany' => array('Visit'))
        );

        $rs = $this->_outletdistribution();

        $total = $this->Outlet->find('count');

        // $max = $rs[0][0]['count'];
        // $max_index = 0;
        $i = 0;


        foreach ($rs as $value) {
            $data['name'] = $value['Outlettype']['outlettypename'];
            $data['y'] = intval($value[0]["count"]);
            // if ($data['y'] > $max) {
            //     $max = $data['y'];
            //     $max_index = $i;
            // }
//            $data['color'] = $this->_generateRandomHexadecimalColorCode();
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
    
    //Outlet Channel Distribution
    private function _outletChannelDistribution($postdata = false) {
        
        if($postdata) {
            $options = $this->postoptions;
        } else {
            $options = $this->urloptions;
        }
        
        $options['fields'] = array(
            'Outletchannel.outletchannelname', 
            'Outlet.outletchannelid', 
            'Count(Outlet.outletchannelid) as count'
        );
        $options['group'] = array('Outlet.outletchannelid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outletchannels',
                'alias' => 'Outletchannel',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.outletchannelid = Outletchannel.id'
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
    
    public function outletchanneldistribution() {

        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];
        
        $rs = $this->_outletChannelDistribution();

        $total = $this->Outlet->find('count');

        // $max = $rs[0][0]['count'];
        // $max_index = '';
        $i = 0;
        $retailersum = 0;
        
        // $rmax = 0;
        // $rmax_index = '';

        foreach ($rs as $value) {
            
            $name = $value['Outletchannel']['outletchannelname'];
            
            if(!strpos($name, 'Retailer')) {
                //Channel names without the retailer value
                $data['name'] = $value['Outletchannel']['outletchannelname'];
                $data['y'] = intval($value[0]["count"]);
                // if ($data['y'] > $max) {
                //     $max = $data['y'];
                //     $max_index = $data['name'];
                // }
                $data['color'] = $colors[$i];
                $resp[$data['name']] = $data;

            } else {
                //Grouping retail in Channel Distribution
                $data['name'] = 'Retailer';
                $retailersum += intval($value[0]["count"]);
                $data['y'] = $retailersum;
                // if ($data['y'] > $max) {
                //     $max = $data['y'];
                //     $max_index = $data['name'];
                // }
                $data['color'] = $colors[$i];
                $resp[$data['name']] = $data;
                
                //for retailer type distribution
                $rname = $value['Outletchannel']['outletchannelname'];
                $sResult = str_replace(array("Retailer", "(", ")"), "", $rname);
                $rdata['name'] = trim($sResult);
                $rdata['y'] = intval($value[0]["count"]);
                // if ($rdata['y'] > $rmax) {
                //     $rmax = $rdata['y'];
                //     $rmax_index = $rdata['name'];
                // }
                $rdata['color'] = $colors[$i];
                $retailer_resp[$rdata['name']] = $rdata;
            }
            
            $i++;
        }

        // $resp[$max_index]['selected'] = true;
        // $resp[$max_index]['sliced'] = true;
        
        // $retailer_resp[$rmax_index]['selected'] = true;
        // $retailer_resp[$rmax_index]['sliced'] = true;

        $output['channel_dist'] = array_values($resp);
        $output['retailer_dist'] = array_values($retailer_resp);
        
        $response = json_encode($output);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    public function outletperformance() {

        $options = $this->urloptions;
        
        if(!isset($options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }
        
        $options['recursive'] = -1;
        $options['fields'] = array('Outlet.createdat', 'COUNT(Outlet.createdat) as count');
        $options['group'] = array("DATE_FORMAT( Outlet.createdat,  '%Y-%m-%d' )");
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

        $rs = $this->Outlet->find('all', $options);
//        debug($rs);
        $response = array();
        $len = count($rs);
        $i = 0;
        $formerdate = new DateTime($rs[$i]['Outlet']['createdat']);
        $pointstart = new DateTime($rs[$i]['Outlet']['createdat']);
        $response[] = intval($rs[$i][0]['count']);

        do {
            if(!isset($rs[$i + 1][0]['count'])) break;
            
            $count = $rs[$i + 1][0]['count'];
            $createdat = new DateTime($rs[$i + 1]['Outlet']['createdat']);

            $currDay = $createdat->format('j');
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

            $formerdate = $createdat;
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

//        $jsonresponse = $rs;
//        $this->set('response', print_r($jsonresponse));
    }

    public function outletlocations() {

        
        $outletsLocation = $this->Outlet->find('all', array(
            'fields' => array('Outlet.geolocation', 'Outlet.outletname'),
            'recursive' => -1,
        ));

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
    
    public function schedulevisit() {
        
        $this->_outletList();   //get current outlets list based on the location handled by the user and sends it to the view
        
        if(!isset($this->request->data)) {
            $this->set('data', $this->request->data);
        } else {
            if($this->request->is('POST') || $this->request->is('PUT')) {
                $schedule['Schedule']['outletid'] = $this->request->data['Calendar']['outletid'];
                $schedule['Schedule']['scheduledate'] = $this->request->data['Calendar']['scheduledate'];
                $schedule['Schedule']['visited'] = 0;
                $schedule['Schedule']['created'] = $this->_createNowTimeStamp();
                if($this->Schedule->save($schedule)) {
                    $this->Session->setFlash('Outlet has been scheduled', 'page_notification_info');
                    $this->redirect(array('controller' => 'calendars', 'action' => 'index'));
                } else {
                    $this->Session->setFlash('Error scheduling outlet. Please, try again', 'page_notification_error');
                }
            }
        }
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
