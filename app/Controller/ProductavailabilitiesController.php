<?php

class ProductavailabilitiesController extends AppController {

    var $name = 'Productavailabilities';
    var $uses = array('Productavailability', 'Brand', 'Product');
    public $components = array('Paginator', 'Filter');

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->_setViewVariables();
        
        $prodavailcount = $this->Productavailability->find('count');
        $this->set('prodavailcount', $prodavailcount);
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('productavailabilities');
        $this->_setTitleOfPage('Product Availabilities');
    }

    public function index() {
//        $this->_setProductAvailability();
        
        $availabilities = $this->_getComparisonTable();
        $this->set('availabilities', $availabilities);
    }

    public function save() {
        
    }

    public function delete() {
        $id = '';
        if (isset($this->request->data['del-id'])) {
            $id = $this->request->data['del-id'];
        }

        if ($this->Productavailability->delete($id)) {
            $resp['status'] = 1;
            $resp['message'] = "Product availability data successfully deleted";
        } else {
            $resp['status'] = 0;
            $resp['message'] = "Problem deleting product availability data";
        }

        $resp['data'] = $id;
        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    public function get_list_data() {
        $products = $this->Product->find('list');
        $resp = array();
        foreach ($products as $key => $value) {
            $resp["products"][] = array(
                "id" => $key,
                "name" => $value
            );
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }


    public function all() {
        
        $options = $this->Filter->getPostDataFilterOptions($this->modelClass);
        $this->_getFilterDisplayText($this->Filter->getFilterText($this->modelClass)); //set the filter text on the page title
        
        $this->_getAllProductAvailabilityList();
        $prodavails = $this->_getAllProductAvailabilityList();
        $this->set(array('prodavails' => $prodavails));
    }

    public function distribution() {
        
        
        $options = $this->Filter->getUrlFilterOptions($this->modelClass);
        
        $options['fields'] = array (
            'Brand.id',
            'Brand.brandname',
            'Brand.brandcolor',
            'Product.productname',
            'Productavailability.id',
            'Productavailability.quantityavailable',
            'SUM(Productavailability.quantityavailable) AS totalquantity'
        );
        $options['group'] = array('Brand.id');
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
                    'Productavailability.visitid = Visit.id'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.outletid = Outlet.id'
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

        $brands = $this->Productavailability->find('all', $options);
        $response = array();
        $data = array();

        if (isset($brands[0][0]['totalquantity'])) {
            // $max = $brands[0][0]['totalquantity'];
            // $max_index = 0;
            $i = 0;
            foreach ($brands as $brand) {
                $data['name'] = $brand['Brand']['brandname'];
                $data['y'] = intval($brand[0]['totalquantity']);
                // if ($data['y'] > $max) {
                //     $max = $data['y'];
                //     $max_index = $i;
                // }
                $data['color'] = $brand['Brand']['brandcolor'];
                $response[] = $data;
                $i++;
            }

            // $response[$max_index]['selected'] = true;
            // $response[$max_index]['sliced'] = true;
        }

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }
    
    public function distributionbybrandproduct($brandid = null) {
        
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];
        
        $options = $this->Filter->getUrlFilterOptions($this->modelClass);
        
        if(is_null($brandid)) {
            $brandid = $this->_getCurrentBrandId();
        }
        
        $options['fields'] = array (
            'Brand.id',
            'Brand.brandname',
            'Brand.brandcolor',
            'Product.productname',
            'Product.id',
            'Productavailability.id',
            'Productavailability.quantityavailable',
            'SUM(Productavailability.quantityavailable) AS totalquantity'
        );
        $options['conditions']['Brand.id'] = $brandid;
        $options['group'] = array('Product.id');
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
                    'Productavailability.visitid = Visit.id'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.outletid = Outlet.id'
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

        $brandproducts = $this->Productavailability->find('all', $options);
        $response = array();
        $data = array();
        
        if (isset($brandproducts[0][0]['totalquantity'])) {
            // $max = $brandproducts[0][0]['totalquantity'];
            // $max_index = 0;
            $i = 0;
            foreach ($brandproducts as $products) {
                $data['name'] = $products['Product']['productname'];
                $data['y'] = intval($products[0]['totalquantity']);
                // if ($data['y'] > $max) {
                //     $max = $data['y'];
                //     $max_index = $i;
                // }
                $data['color'] = $colors[$i];
                $response[] = $data;
                $i++;
            }

            // $response[$max_index]['selected'] = true;
            // $response[$max_index]['sliced'] = true;
        }

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    public function comparison() {
        
        $options = $this->Filter->getUrlFilterOptions($this->modelClass);
        
        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Brand.brandcolor',
            'Product.id',
            'Product.productname',
            'Product.compareproductid',
            'Productavailability.id',
            'SUM(Productavailability.quantityavailable) AS totalquantity'
        );
        $options['order'] = array('Brand.id', 'Product.compareproductid');
        $options['group'] = array('Product.id');
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
                    'Productavailability.visitid = Visit.id'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.outletid = Outlet.id'
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

        $prodcomps = $this->Productavailability->find('all', $options);

        //get current brand id
        $currentBrandId = $this->_getCurrentBrandId();

        //get all products of current brand
        $brandproducts = $this->_getBrandProduct($currentBrandId);

        //get all brands
        $allbrands = $this->_getAllBrands();

        $categories = array();
        foreach ($brandproducts as $product) {
            $categories[] = $product['Product']['productname'];       //Brand products as first column
        }


        foreach ($allbrands as $brand) {

            $resp[$brand['Brand']['id']]['name'] = $brand['Brand']['brandname'];
            $resp[$brand['Brand']['id']]['color'] = $brand['Brand']['brandcolor'];
            $cfound = false;

            foreach ($brandproducts as $product) {

                $found = false;
                $i = 0;
                for ($i = 0; $i < count($prodcomps); $i++) {
                    if ($prodcomps[$i]['Product']['compareproductid'] == $product['Product']['id'] &&
                            $prodcomps[$i]['Brand']['id'] == $brand['Brand']['id']) {


                        $resp[$brand['Brand']['id']]['data'][] = intval($prodcomps[$i][0]['totalquantity']);
                        $found = true;
                        $prodcomps[$i] = null;
                        break;
                    }
                    if ($prodcomps[$i]['Product']['compareproductid'] == null &&
                            $prodcomps[$i]['Product']['id'] == $product['Product']['id'] &&
                            $prodcomps[$i]['Brand']['id'] == $currentBrandId) {

                        $resp[$brand['Brand']['id']]['data'][] = intval($prodcomps[$i][0]['totalquantity']);
                        $prodcomps[$i] = null;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {

                    $resp[$brand['Brand']['id']]['data'][] = 0;
                }
            }
        }

        $response['series'] = array_values($resp);
        $response['categories'] = $categories;

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    private function _getComparisonTable() {
        
        $options = $this->Filter->getPostDataFilterOptions($this->modelClass);
        $this->_getFilterDisplayText($this->Filter->getFilterText($this->modelClass)); //set the filter text on the page title
//        debug($options);
        $options['fields'] = array(
            'Brand.id',
            'Product.id',
            'Product.productname',
            'Product.compareproductid',
            'Productavailability.id',
            'SUM(Productavailability.quantityavailable) AS totalquantity'
        );
        $options['order'] = array('Product.compareproductid', 'Brand.id');
        $options['group'] = array('Product.id');
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
                    'Productavailability.visitid = Visit.id'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.outletid = Outlet.id'
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

        $prodcomps = $this->Productavailability->find('all', $options);
//        debug($prodcomps);
        //get current brand id
        $currentBrandId = $this->_getCurrentBrandId();

        //get all products of current brand
        $brandproducts = $this->_getBrandProduct($currentBrandId);

        //get all brands
        $allbrands = $this->_getAllBrands();


        //Table calculation starts from here
        $tableMatrix[0][0] = 'Brand Products';

        foreach ($allbrands as $brand) {
            $tableMatrix[0][$brand['Brand']['id']] = $brand;         //Brands as first row
        }

        foreach ($brandproducts as $product) {
            $tableMatrix[$product['Product']['id']][0] = $product;       //Brand products as first column
        }

        foreach ($brandproducts as $product) {

            foreach ($allbrands as $brand) {

                $i = 0;
                for ($i = 0; $i < count($prodcomps); $i++) {
                    if ($prodcomps[$i]['Product']['compareproductid'] == $product['Product']['id'] &&
                            $prodcomps[$i]['Brand']['id'] == $brand['Brand']['id']) {

                        $tableMatrix[$product['Product']['id']][$brand['Brand']['id']] = $prodcomps[$i];
                        break;
                    } else if ($prodcomps[$i]['Product']['compareproductid'] == null &&
                            $prodcomps[$i]['Product']['id'] == $product['Product']['id'] &&
                            $prodcomps[$i]['Brand']['id'] == $currentBrandId) {

                        $tableMatrix[$product['Product']['id']][$currentBrandId] = $prodcomps[$i];
                    } else {

                        $tableMatrix[$product['Product']['id']][$brand['Brand']['id']] = null;
                    }
                }
            }
        }
        
        $firstrow = true; 
        $total = 0;
//        return $tableMatrix;
        
        foreach ($tableMatrix as &$rowitem) {
             if($firstrow) {
                 $firstrow = false;
                 continue;
             }
             $total = 0;
             $comparename = '';
             $comparequantity = '';
             
             $firstcol = true;
             foreach ($rowitem as &$cellitem) {
                 if($firstcol) {
                     $compareproductid = $cellitem['Product']['id'];
                     $comparename = $cellitem['Product']['productname'];
                     $firstcol = false;
                     continue;
                 } else if(isset($cellitem[0]['totalquantity'])) {
                     //calculate the total quantity to be used in obtaining the percentage share
                     $total += intval($cellitem[0]['totalquantity']);
                     //get the product quantity of the current brand product
                     if($compareproductid == $cellitem['Product']['id']) {
                             $comparequantity = $cellitem[0]['totalquantity'];
                     }
                 }
            }
            
            $firstcol2 = true;
            foreach ($rowitem as &$percentItem) {
                 if($firstcol2) {
                     $firstcol2 = false;
                     continue;
                 } else if(isset($percentItem[0]['totalquantity'])) {
                    //test for division by zero
                    $total = $total == 0 ? 1 : $total;
                    $percentItem[1]['percentage'] = round($percentItem[0]['totalquantity'] / $total * 100);
                     
                     $percentItem['Product']['comparename'] = $comparename;
                     $percentItem['Product']['comparequantity'] = $comparequantity;
                 }
            }
            
        }
        
        return $tableMatrix;
        
    }
    
    public function comparisontable() {
        
        $response = $this->_getComparisonTable();
                 
        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
        
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
        if(!isset($currentbrand[0]['Brand']['id'])) {
            return null;
        }
        
        $brandid = $currentbrand[0]['Brand']['id'];
        
        return $brandid;
    }

    private function _getAllBrands() {
        //Get All Brand List except Current Order by ProductId => Columns
        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Brand.brandcolor',
        );
        $options['order'] = array('Brand.id');
        $options['recursive'] = -1;

        $allbrands = $this->Brand->find('all', $options);
        return $allbrands;
    }

    private function _getBrandProduct($brandId) {
        
        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Product.id',
            'Product.productname',
            'Product.compareproductid',
        );
        $options['order'] = array('Product.id');
        //Comment to Include Brands
        $options['conditions'] = array('Brand.id' => $brandId);
        $options['group'] = array('Product.id');
        $options['recursive'] = -1;

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
        $brandproducts = $this->Product->find('all', $options);
        return $brandproducts;
    }

    private function _getAllProductAvailabilityList() {

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
                    'Productavailability.visitid = Visit.id'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.outletid = Outlet.id'
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
        $this->Paginator->settings = $options;
        $prodavails = $this->Paginator->Paginate('Productavailability');
        return $prodavails;
    }

    //Outlet, Visit and Sales performance monitor
    public function performance() {

        $options = $this->Filter->getUrlFilterOptions($this->modelClass);
        if(!isset($options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) <="])) {
            //Use last 2 weeks as default date range for the performance graph
            $today = date('Y-m-d');
            $lastweek = strtotime("-2 weeks");
            $lastweekdate = date('Y-m-d', $lastweek);
            $options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) <="] = $today;
            $options['conditions']["DATE_FORMAT( {$this->modelClass}.createdat,  '%Y-%m-%d' ) >="] = $lastweekdate;
        }
        
        $options['fields'] = array(
            "DATE_FORMAT( Productavailability.createdat,  '%Y-%m-%d' ) as datecreated", 
            'COUNT(Productavailability.createdat) as count'
        );
        $options['recursive'] = -1;
        $options['group'] = array("DATE_FORMAT( Productavailability.createdat,  '%Y-%m-%d' )");
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
                    'Productavailability.visitid = Visit.id'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.outletid = Outlet.id'
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
        

        $rs = $this->Productavailability->find('all', $options);

        $order_data = array();
        foreach ($rs as $result) {
            $order_data[] = array(strtotime($result[0]['datecreated']) * 1000, intval($result[0]['count']));
        }
        
        $response = array();

        $series_prodavail_data['name'] = 'Product Availability';
        $series_prodavail_data['data'] = $order_data;
        $series_prodavail_data['color'] = '#dc3813';

        $response[] = $series_prodavail_data;

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);

//        $jsonresponse = $rs;
//        $this->set('response', print_r($jsonresponse));
    }
    
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
        
        //outlet count by locations
        $pavailability_by_location = $this->_pavailabilityCountByLocation();
        foreach ($pavailability_by_location as $pavailability) {
            
            $id = $pavailability['State']['internalid'];
            $value = $pavailability[0]['elementvalue'];
            
            if(!isset($mapdata['data'][$id]['toolText'])) {
//                $max = $value;
                $tooltext = $pavailability['State']['statename'] . '{br}' . $pavailability['Brand']['brandname'] . " ({$value})";
                $brandcolor = str_replace('#', '', $pavailability['Brand']['brandcolor']);
                $mapdata['data'][$id]['id'] = $id;
                $mapdata['data'][$id]['value'] = $value;
                $mapdata['data'][$id]['toolText'] = $tooltext;
                $mapdata['data'][$id]['color'] = $brandcolor;
                $mapdata['data'][$id]['link'] = 'JavaScript:getAvailDetailFromMap("' . $id . '")';
            } else {
                $tooltext = $mapdata['data'][$id]['toolText'];
                $tooltext .= '{br}' . $pavailability['Brand']['brandname'] . " ({$value})";
                $mapdata['data'][$id]['toolText'] = $tooltext;
            }
            
            
        }
        
        $mapdata['data'] = array_values($mapdata['data']);
        $response = json_encode($mapdata);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    
    private function _pavailabilityCountByLocation() {
        
        //extract query parameter from the $_GET request
        $options = $this->Filter->getUrlFilterOptions($this->modelClass);
        $options['fields'] = array(
            'Brand.brandname, '
            . 'Brand.brandcolor, '
            . 'Productavailability.productid, '
            . 'Product.productname, '
            . 'State.internalid, '
            . 'State.statename, '
            . 'SUM(Productavailability.quantityavailable * Productavailability.unitprice) as elementvalue'
            );
        
        $options['group'] = array('State.internalid', 'Brand.id');
        $options['order'] = array('State.internalid', 'elementvalue DESC');
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
                    'Brand.id = Product.brandid'
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
        $productavailability = $this->Productavailability->find('all', $options);
        
        return $productavailability;
    }
    
    public function mapitemdata($id) {
        $options['fields'] = array(
            'Brand.brandname, '
            . 'Brand.brandcolor, '
            . 'Productavailability.productid, '
            . 'Product.productname, '
            . 'State.internalid, '
            . 'State.statename, '
            . 'SUM(Productavailability.quantityavailable * Productavailability.unitprice) as elementvalue'
            );
        
        $options['conditions']['State.internalid'] = $id;
        $options['group'] = array('State.internalid', 'Product.id');
        $options['order'] = array('State.internalid', 'elementvalue DESC');
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
                    'Brand.id = Product.brandid'
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
        
        $productavailability = $this->Productavailability->find('all', $options);
        foreach ($productavailability as $proditem) {
            $item['productname'] = $proditem['Product']['productname'];
            $item['brandname'] = $proditem['Brand']['brandname'];
            $item['brandcolor'] = $proditem['Brand']['brandcolor'];
            $item['stateid'] = $proditem['State']['internalid'];
            $item['statename'] = $proditem['State']['statename'];
            $value = intval($proditem[0]['elementvalue']);
            $item['value'] = 'N ' . number_format($value, 2, '.', ',');
            $response[] = $item;
        }
        $response = json_encode($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    
    //Helper Generator
    public function generateproductavailabilitydata($count) {
        $purchasepoint = [ 1 => "Benson Products", "Kenny Ventures", "Beat Enterprises", "Cardilous", "Spectacles Limited"];
        $unitprice = [100, 200, 400, 500, 750, 1000, 1500];
        //Generate Planned Visits
        $test_data = array();
        for ($i = 1; $i < $count; $i++) {
//            $test_data['Productavailability']['id'] = $i;
            $test_data['Productavailability']['visitid'] = rand(383, 482);
            $test_data['Productavailability']['productid'] = rand(1, 10);
            $test_data['Productavailability']['quantityavailable'] = rand(1, 20);
            $test_data['Productavailability']['unitprice'] = $unitprice[rand(1, 4)];
            $test_data['Productavailability']['purchasepoint'] = $purchasepoint[rand(1, 5)];
            $test_data['Productavailability']['createdat'] = '2013-' . rand(6, 11) . '-' . rand(1, 30);
            $response[] = $test_data;
        }
        $this->Productavailability->saveMany($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', json_encode($response));
    }

}
