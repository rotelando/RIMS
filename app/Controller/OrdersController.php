<?php

//Please note the number of colours of the product in the distribution action method. It will surely increase more than 10

class OrdersController extends AppController {

    var $name = 'Orders';
    var $uses = array('Order', 'Visit', 'Outlet', 'Product', 'Brand');
    var $helpers = array('Form', 'Html');
    public $components = array('Paginator', 'Filter', 'SSP');
    
    public $urloptions = array();
    public $postoptions = array();

    public function beforeFilter() {
        parent::beforeFilter();

//        $allowed = $this->UserAccessRight->isAllowedSalesModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }

        $this->urloptions = $this->Filter->getUrlFilterOptions($this->modelClass);
        $this->postoptions = $this->Filter->getPostDataFilterOptions($this->modelClass);
        
        $this->_setViewVariables();
        $this->_fetchAndSetAllOrders(10);

        //get current user settings :)
        $this->setCurrentUserSettings();
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('orders');
        $this->_setTitleOfPage('Orders Management');
    }

    public function index() {
        $ordercount = $this->_getOrderCount($this->postoptions);
        $this->set('ordercount', $ordercount);

        $actual_vs_target = $this->_getActualVsTargetOrders($this->postoptions);
        $this->set('actual_vs_target', $actual_vs_target);

        $salesvalues = $this->_salesdistribution();
//        debug($salesvalues);
        $this->set('sales', $salesvalues);
        
        $currentbrandid = $this->_getCurrentBrandId();
        $brandproductlist = $this->_getBrandProduct($currentbrandid);
//        debug($salesvalues);
        $this->set('brandproductlist', $brandproductlist);
    }

    private function _getBrandProduct($brandId) {
        //Comment to Include Brands
        $options['conditions'] = array('Brand.id' => $brandId);
        $options['joins'] = array(
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.brandid = Brand.id'
                )
            )
        );
        $brandproducts = $this->Product->find('list', $options);
        return $brandproducts;
    }
    
    private function _getCurrentBrandId() {
        //Get the Current Brand
        $currentbrand = $this->Brand->find('all', array(
            'recursive' => -1,
            'fields' => array('Brand.id'),
            'conditions' => array('Brand.current' => 1)));
        $this->set('currentbrand', $currentbrand);
//        debug($currentbrand);
        //Get all current brand products
        if(isset($currentbrand[0]['Brand']['id'])) {
            $brandid = $currentbrand[0]['Brand']['id'];
        } else {
            $brandid = -1;
        }
        
        return $brandid;
    }
    
    private function _getOrderCount($postoptions = null) {
        $options = $postoptions;
        $options['fields'] = array(
            'SUM( quantity * ( unitprice - discount * unitprice ) ) as totalordervalue'
        );
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
        $ordercount = $this->Order->find('all', $options);
        if (isset($ordercount[0][0]['totalordervalue'])) {
            $intActual = intval($ordercount[0][0]['totalordervalue']);
        } else {
            $intActual = 0;
        }
        return $intActual;
    }

    private function _getActualVsTargetOrders($postoptions = null) {
            $actual = $this->_getOrderCount($postoptions);
            $settings = $this->setCurrentUserSettings();
            $target = intval($settings['Setting']['TargetOrder']);
            if (isset($target) && $target != 0) {
                $actual_vs_target = intval(($actual / $target) * 100);
            } else {
                $actual_vs_target = 100;
            }
            return $actual_vs_target;        
    }

    private function _fetchAndSetAllOrders($number = null) {
//        SELECT `Order`.`id`, `Outlet`.`id`, `Outlet`.`outletname`, `Product`.`id`,
//        `Product`.`name`
//        FROM `papyrus`.`orders` AS `Order`
//        LEFT JOIN `papyrus`.`visits` AS `Visit`
//        ON (`Order`.`visitid` = `Visit`.`id`)
//        LEFT JOIN `papyrus`.`products` AS `Product` ON (`Order`.`productid` = `Product`.`id`)
//        WHERE `Order`.`deletedat` IS NULL ORDER BY `Order`.`createdat` DESC LIMIT 10
        //########## Filter Conditions #######################//
        //condition for location filter
        $options = $this->postoptions;
        //########## End Filter Conditions #######################//

        $options['fields'] = array(
            'Order.id',
            'Order.quantity',
            'Order.discount',
            'Orderstatus.id',
            'Orderstatus.orderstatusname',
            'Outlet.id',
            'Outlet.outletname',
            'Product.id',
            'Product.productname',
            'Order.visitid'
        );
        $options['order'] = array('Order.createdat DESC');
        $options['limit'] = $number;
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

        $orders = $this->Order->find('all', $options);

        $this->set(array('orders' => $orders));
    }

    public function all() {
        

    }

    public function loadsales() {

        //########## Filter Conditions #######################//
        $options = $this->urloptions;
        //########## End Filter Conditions #######################//
        
        //Use the al for column names returned after the database is queried in data_output function in SSPComponent
        $columns = array(
            array( 
                'db' => 'outlets.outletname',
                'qry' => 'outlets.outletname as outletname',
                'al' => 'outletname', 
                'dt' => '0',),
            array( 
                'db' => 'products.productname', 
                'qry' => 'products.productname as productname', 
                'al' => 'productname', 
                'dt' => '1'),
            array( 
                'db' => 'orders.quantity', 
                'qry' => 'orders.quantity as quantity', 
                'al' => 'quantity', 
                'dt' => '2'),
            array( 
                'db' => 'orders.discount', 
                'qry' => 'orders.discount as discount', 
                'al' => 'discount', 
                'dt' => '3'),
            array( 
                'db' => 'orderstatuses.orderstatusname', 
                'qry' => 'orderstatuses.orderstatusname as orderstatusname', 
                'al' => 'orderstatusname', 
                'dt' => '4'),
            array(
                'db' => 'visits.id', 
                'qry' => 'visits.id as id', 
                'al' => 'id', 
                'dt' => '5'),
            array(
                'db' => 'orders.id', 
                'qry' => 'orders.id as sales_id', 
                'al' => 'sales_id', 
                'dt' => 'sales_id'),
            array(
                'db' => 'outlets.id', 
                'qry' => 'outlets.id as out_id', 
                'al' => 'out_id', 
                'dt' => 'out_id')
        );

        $table_name = "orders";
        $joins = " LEFT JOIN visits ON visits.id = orders.visitid " .
                 "LEFT JOIN products ON products.id = orders.productid " .
                 "LEFT JOIN orderstatuses ON orderstatuses.id = orders.orderstatusid " .
                 "LEFT JOIN outlets ON outlets.id = visits.outletid ";

        $primaryKey = "orders.id";

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

    public function performance() {

        $options = $this->urloptions;
        
        if(!isset($options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }

        $options['fields'] = array("DATE_FORMAT( Order.createdat,  '%Y-%m-%d' ) as datecreated", 'COUNT(Order.createdat) as count');
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
        
        $rs = $this->Order->find('all', $options);


        $response = array();
        $data = array();
        foreach ($rs as $result) {
            $data[] = array(strtotime($result[0]['datecreated']) * 1000, intval($result[0]['count']));
        }

        $series_data['name'] = 'Product';
        $series_data['data'] = $data;
        $response[] = $series_data;

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);

//        $jsonresponse = $rs;
//        $this->set('response', print_r($jsonresponse));
    }

    private function _salesdistribution() {

        $options = $this->urloptions;
        
        $options['fields'] = array(
            'Order.id',
            'Order.quantity',
            'Outlet.id',
            'Outlet.outletname',
            'Product.productname',
            'Product.id',
            'Count(Product.id) as count',
            'SUM( Order.quantity * ( Order.unitprice - Order.discount * Order.unitprice ) ) as totalordervalue'
        );
        $options['group'] = array('productid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Order.productid'
                )
            ),
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

        $rs = $this->Order->find('all', $options);
        return $rs;
    }

    public function distribution() {

        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];
        //Unbind Visit from Outlet to control the amount of data pulled from the database

        $rs = $this->_salesdistribution();

        $total = $this->Order->find('count');

        // $max = $rs[0][0]['count'];
        // $max_index = 0;
        $i = 0;


        foreach ($rs as $value) {
            $data['name'] = $value['Product']['productname'];
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

    public function generateordersdata() {

        //Generate Actual Visits - for Visit Model
        $test_data = array();
        for ($i = 1; $i <= 350; $i++) {

            $test_data['Order']['id'] = $i;
            $test_data['Order']['visitid'] = rand(384, 470);
            $test_data['Order']['productid'] = rand(1, 8);
            $test_data['Order']['quantity'] = rand(1, 20);
            $test_data['Order']['discount'] = floatval('0.' . rand(1, 2) . rand(0, 5));
            $test_data['Order']['status'] = rand(0, 1);
            $test_data['Order']['createdat'] = '2013-' . rand(11, 12) . '-' . rand(1, 30) . ' '
                    . rand(10, 18) . ':' . rand(0, 59) . ':' . rand(0, 59);

            $response[] = $test_data;
        }
        $this->Order->SaveAll($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', json_encode($response));
    }

}
