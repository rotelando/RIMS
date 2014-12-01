<?php

class MapsController extends AppController {

    var $name = 'Maps';
    var $uses = array('Visit', 'Schedule', 'Outlet', 'Location', 'User', 'Retailtype', 'Outletchannel', 'Brand', 'Order', 'Product', 'Productavailability', 'Visibilityevaluation', 'Brandelement');
    var $helpers = array('Time', 'MyLink');
    var $components = array('Filter');
    var $options;

    public function index() {
        $this->layout = 'map';
        
    }

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->_setViewVariables();

        //get current user settings :)
        $this->setCurrentUserSettings();
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('maps');
        $this->_setTitleOfPage('Maps');
    }
    
    private function _getBrandNames() {
        $brands = $this->Brand->find('list');
        return $brands;
    }
    
    private function _getOutletTypes() {
        $retailtypes = $this->Retailtype->find('list');
        return $retailtypes;
    }
    
    private function _getOutletDetails($options) {
        
        
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.phonenumber',
            'Outlet.streetnumber',
            'Outlet.streetname',
            'Outlet.town',
            'Outlet.geolocation',
            'Outlet.retailtype_id',
            'Location.locationname',
            'Retailtype.retailtypename',
            'User.id',
            'User.firstname',
            'User.lastname'
        );
        $options['order'] = array('Outlet.created_at desc');
        $options['recursive'] = -1;
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
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            ),
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            ),
            array(
                'table' => 'outletchannels',
                'alias' => 'Outletchannel',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletchannel.id = Outlet.outletchannel_id'
                )
            )
        );
        $outlets = $this->Outlet->find('all', $options);
        return $outlets;
    }
    
    public function outletmapinformation() {
        // $markers = array(
        //     'dot-red.png',
        //     'dot-blue.png',
        //     'dot-green.png',
        //     'dot-yellow.png',
        //     'dot-pink.png',
        //     'dot-purple.png',
        //     'dot-orange.png',
        //     'dot-dark-green.png',
        //     'dot-dark-purple.png',
        //     'dot-grey.png',
        //     'dot-light-grey.png'    
        // );

        // $markers = array(
        //     'red-pushpin.png',
        //     'blue-pushpin.png',
        //     'grn-pushpin.png',
        //     'ylw-pushpin.png',
        //     'pink-pushpin.png',
        //     'purple-pushpin.png',
        //     'ltblu-pushpin.png'    
        // );

        $markers = array(
            'red-dot.png',
            'blue-dot.png',
            'green-dot.png',
            'yellow-dot.png',
            'pink-dot.png',
            'purple-dot.png',
            'orange-dot.png',
            'ltblu-dot.png',
        );

        $iconUrl = 'assets/js/custommarkers/';
        
        $retailtypes = $this->_getOutletTypes();
        
        $markerIndex = array();
        $i = 0;
        foreach ($retailtypes as $key => $value) {
            $markerIndex[$key] = $i++;
        }
        
        $options = array();
        $options = $this->Filter->getUrlFilterOptions('Outlet');
        
        if (isset($this->params['url']['cls'])) {
            $chan = $this->params['url']['cls'];
            $options['conditions']['Outlet.retailtype_id'] = $chan;
        }
        if (isset($this->params['url']['chan'])) {
            $chan = $this->params['url']['chan'];
            $options['conditions']['Outlet.outletchannel_id'] = $chan;
        }

        if (isset($this->params['url']['loc'])) {
            $locParam = $this->params['url']['loc'];
            $options = $this->getOptionValueFromString($locParam, $options);
        }
        
        if (isset($this->params['url']['q'])) {
            $querytext = $this->params['url']['q'];
            $options['conditions']['Outlet.outletname LIKE'] = '%'.$querytext.'%';
        }


        //get outlet details
        $outlets = $this->_getOutletDetails($options);
        
//        $response = $outlets;
        $response = array();
        foreach ($outlets as $outlet) {
            $item['outletid'] = $outlet['Outlet']['id'];
            $item['outletname'] = $outlet['Outlet']['outletname'];
            $pos = $outlet['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $item['latitude'] = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1])) {
                continue;
            }
            
            $item['longitude'] = floatval($arrLatLng[1]);
            $item['phonenumber'] = $outlet['Outlet']['phonenumber'];
            $item['location'] = $outlet['Location']['locationname'];
            $item['retailtype'] = $outlet['Retailtype']['retailtypename'];
            $item['contactname'] = $outlet['User']['firstname'] . ' ' .$outlet['User']['lastname'];
            $item['address'] = $outlet['Outlet']['streetnumber'] . ', ' .$outlet['Outlet']['streetname']
                    . ', ' .$outlet['Outlet']['town'] . '.';
            $typeid = $outlet['Outlet']['retailtype_id'];
            $item['iconUrl'] = $iconUrl . $markers[$markerIndex[$typeid]];
            $response['outlets_location'][] = $item;
        }
        
        //Get outlet classifications
        $types = $this->Retailtype->find('list');
        $response['outlets_class'][] = array('id' => 0, 'name' => "**Class**");
        foreach ($types as $key => $value) {
            $type['id'] = $key;
            $type['name'] = $value;
            $response['outlets_class'][] = $type;
        }
        
        
        //Get outlet channels
        $channels = $this->Outletchannel->find('list');
        $response['outlets_channel'][] = array('id' => 0, 'name' => "**Channel**");
        foreach ($channels as $key => $value) {
            $channel['id'] = $key;
            $channel['name'] = $value;
            $response['outlets_channel'][] = $channel;
        }

        $tempLocData = $this->getLocationData();
        $response['locations'] = $tempLocData['locations'];
        
        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }
    
    public function _getSalesDetails($options) {
        
        
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.geolocation',
            'Outlet.retailtype_id',
            'Location.locationname',
            'Retailtype.retailtypename',
            'Product.id',
            'Product.productname',
            'SUM( Order.quantity * ( Order.unitprice - Order.discount * Order.unitprice ) ) as totalordervalue'
        );
        $options['order'] = array('Order.created_at desc');
        $options['group'] = array('Outlet.id');
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
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Order.productid'
                )
            ),
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            )
        );
        $sales = $this->Order->find('all', $options);
        return $sales;
        
//        $response = $sales;
//        $jsonresponse = json_encode($response);
////        $jsonresponse = json_encode($unvisitedLocations);
//        $this->layout = 'ajax';
//        $this->view = 'ajax_response';
//        $this->set('response', $jsonresponse);
    }
    
    public function salesmapinformation() {
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
        $iconUrl = 'assets/js/custommarkers/';
        
        $retailtypes = $this->_getOutletTypes();
        
        $markerIndex = array();
        $i = 0;
        foreach ($retailtypes as $key => $value) {
            $markerIndex[$key] = $i++;
        }
        
        $options = array();
        $options = $this->Filter->getUrlFilterOptions('Order');
        if (isset($this->params['url']['sp'])) {
            $productid = $this->params['url']['sp'];
            $options['conditions']['Order.productid'] = $productid;
        }
        if (isset($this->params['url']['loc'])) {
            $locParam = $this->params['url']['loc'];
            $options = $this->getOptionValueFromString($locParam, $options);
        }
        
        //get outlet details
        $outlets = $this->_getSalesDetails($options);
//        $response = $outlets;
        $response = array();
        foreach ($outlets as $outlet) {
            $item['outletid'] = $outlet['Outlet']['id'];
            $item['outletname'] = $outlet['Outlet']['outletname'];
            $pos = $outlet['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $item['longitude'] = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1])) {
                continue;
            }
            
            $item['latitude'] = floatval($arrLatLng[1]);
            $item['location'] = $outlet['Location']['locationname'];
            $item['retailtype'] = $outlet['Retailtype']['retailtypename'];
            $item['totalsalesvalue'] = 'N' . $outlet[0]['totalordervalue'];
            $typeid = $outlet['Outlet']['retailtype_id'];
            $item['iconUrl'] = $iconUrl . $markers[$markerIndex[$typeid]];
            $response['sales_location'][] = $item;
        }
        
        //Get current brand product
        $options['conditions'] = array('Brand.id' => $this->_getCurrentBrandId());
        $options['fields'] = array('Product.id', 'Product.productname');
        $products = $this->Product->find('all', $options);
        
        $response['sales_product'][] = array('id' => 0, 'name' => "**Product**");
        foreach ($products as $value) {
            $product['id'] = $value['Product']['id'];
            $product['name'] = $value['Product']['productname'];
            $response['sales_product'][] = $product;
        }

        // ====
        $tempLocData = $this->getLocationData();
        $response['locations'] = $tempLocData['locations'];
        
        //====
        
        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    private function getOptionValueFromString($locParamString, $options) {

        $locArr = explode('_', $locParamString);
        
        if($locArr[0] == 'nat') {
            $options['conditions']['State.countryid'] = $locArr[1];
        } else if($locArr[0] == 'reg') {
            $options['conditions']['State.regionid'] = $locArr[1];
        } else if($locArr[0] == 'sta') {
            $options['conditions']['State.id'] = $locArr[1];
        } else if($locArr[0] == 'loc') {
            $options['conditions']['Location.id'] = $locArr[1];
        }

            return $options;
    }

    private function getLocationData() {

        $response['locations'][] = array('Default' => array( 'id' => '0', 'name' => "**Locations**"));
        $locationsData = $this->_locationLists(false);
        $innerGroup = array();
        foreach ($locationsData as $key => $value) {
            $group = array();
            if(is_array($value)) {
                $innerGroup = array();
                foreach ($value as $innerKey => $InnerValue) {
                    $innerGroup[] = array('id' => $innerKey, 'name' => $InnerValue);
                }

                $group[$key] = $innerGroup;
            } else {
                $group[$key] = $value;
            }
            
            $response['locations'][] = $group;  
        }
        return $response;
    }
    
    public function _getMerchandizeDetails($options) {
        
        if (isset($this->params['url']['pid'])) {
            $id = $this->params['url']['pid'];
            $options['conditions'] = array('Product.id' => $id);
        }
        
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.geolocation',
            'Outlet.retailtype_id',
            'Location.locationname',
            'Retailtype.retailtypename',
            'Brand.id',
            'Brand.brandname',
            'Brandelement.id',
            'Brandelement.brandelementname',
            'SUM( Visibilityevaluation.elementcount ) as totalcount'
        );
        $options['order'] = array('Visibilityevaluation.created_at desc');
        $options['group'] = array('Outlet.id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Visibilityevaluation.visitid'
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
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brand.id = Visibilityevaluation.brandid'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brandelement.id = Visibilityevaluation.visibilityelementid'
                )
            ),
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            )
        );
        $sales = $this->Visibilityevaluation->find('all', $options);
        return $sales;
        
//        $response = $sales;
//        $jsonresponse = json_encode($response);
////        $jsonresponse = json_encode($unvisitedLocations);
//        $this->layout = 'ajax';
//        $this->view = 'ajax_response';
//        $this->set('response', $jsonresponse);
    }
    
    public function merchandizemapinformation() {
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
        $iconUrl = 'assets/js/custommarkers/';
        
        $retailtypes = $this->_getOutletTypes();
        
        $markerIndex = array();
        $i = 0;
        foreach ($retailtypes as $key => $value) {
            $markerIndex[$key] = $i++;
        }
        
        $options = array();
        if (isset($this->params['url']['mb'])) {
            $brandid = $this->params['url']['mb'];
            $options['conditions']['Visibilityevaluation.brandid'] = $brandid;
        }
        if (isset($this->params['url']['mbe'])) {
            $brandelementid = $this->params['url']['mbe'];
            $options['conditions']['Visibilityevaluation.visibilityelementid'] = $brandelementid;
        }

        if (isset($this->params['url']['loc'])) {
            $locParam = $this->params['url']['loc'];
            $options = $this->getOptionValueFromString($locParam, $options);
        }
        
        //get outlet details
        $outlets = $this->_getMerchandizeDetails($options);
//        $response = $outlets;
        $response = array();
        foreach ($outlets as $outlet) {
            $item['outletid'] = $outlet['Outlet']['id'];
            $item['outletname'] = $outlet['Outlet']['outletname'];
            $pos = $outlet['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $item['longitude'] = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1])) {
                continue;
            }
            
            $item['latitude'] = floatval($arrLatLng[1]);
            $item['location'] = $outlet['Location']['locationname'];
            $item['retailtype'] = $outlet['Retailtype']['retailtypename'];
            $item['brandname'] = $outlet['Brand']['brandname'];
            $item['brandelementname'] = $outlet['Brandelement']['brandelementname'];
            $item['totalcount'] = $outlet[0]['totalcount'];
            $typeid = $outlet['Outlet']['retailtype_id'];
            $item['iconUrl'] = $iconUrl . $markers[$markerIndex[$typeid]];
            $response['merchandize_location'][] = $item;
        }
        
        //Get outlet channels
        $brandelements = $this->Brandelement->find('list');
        $response['merchandize_brandelements'][] = array('id' => 0, 'name' => "**Visibility Elements**");
        foreach ($brandelements as $key => $value) {
            $product['id'] = $key;
            $product['name'] = $value;
            $response['merchandize_brandelements'][] = $product;
        }
        
        //Get outlet channels
        $brands = $this->Brand->find('list');
        $response['merchandize_brands'][] = array('id' => 0, 'name' => "**Brands**");
        foreach ($brands as $key => $value) {
            $product['id'] = $key;
            $product['name'] = $value;
            $response['merchandize_brands'][] = $product;
        }
        
        $tempLocData = $this->getLocationData();
        $response['locations'] = $tempLocData['locations'];

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
        //Get all current brand products
        if(!isset($currentbrand[0]['Brand']['id'])) {
            return null;
        }
        
        $brandid = $currentbrand[0]['Brand']['id'];
        
        return $brandid;
    }
    
    public function _getProdAvailDetails($options) {
        
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.geolocation',
            'Outlet.retailtype_id',
            'Location.locationname',
            'Retailtype.retailtypename',
            'Product.id',
            'Product.productname',
            'SUM( Productavailability.quantityavailable * Productavailability.unitprice) as totalvalue'
        );
        $options['order'] = array('Productavailability.created_at desc');
        $options['group'] = array('Outlet.id');
        $options['recursive'] = -1;
        $options['joins'] = array(
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
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'LEFT',
                'conditions' => array(
                    'Product.id = Productavailability.productid'
                )
            ),
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            )
        );
        $pavail = $this->Productavailability->find('all', $options);
        return $pavail;
        
//        $response = $sales;
//        $jsonresponse = json_encode($response);
////        $jsonresponse = json_encode($unvisitedLocations);
//        $this->layout = 'ajax';
//        $this->view = 'ajax_response';
//        $this->set('response', $jsonresponse);
    }
    
    public function pavailmapinformation() {
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
        $iconUrl = 'assets/js/custommarkers/';
        
        $retailtypes = $this->_getOutletTypes();
        
        $markerIndex = array();
        $i = 0;
        foreach ($retailtypes as $key => $value) {
            $markerIndex[$key] = $i++;
        }
        
        $options = array();
        if (isset($this->params['url']['ap'])) {
            $productid = $this->params['url']['ap'];
            $options['conditions']['Product.id'] = $productid;
        }

        if (isset($this->params['url']['loc'])) {
            $locParam = $this->params['url']['loc'];
            $options = $this->getOptionValueFromString($locParam, $options);
        }
        
        //get outlet details
        $outlets = $this->_getProdAvailDetails($options);
//        $response = $outlets;
        $response = array();
        foreach ($outlets as $outlet) {
            $item['outletid'] = $outlet['Outlet']['id'];
            $item['outletname'] = $outlet['Outlet']['outletname'];
            $pos = $outlet['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $item['longitude'] = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1])) {
                continue;
            }
            
            $item['latitude'] = floatval($arrLatLng[1]);
            $item['location'] = $outlet['Location']['locationname'];
            $item['retailtype'] = $outlet['Retailtype']['retailtypename'];
            $item['totalvalue'] = 'N' . $outlet[0]['totalvalue'];
            $typeid = $outlet['Outlet']['retailtype_id'];
            $item['iconUrl'] = $iconUrl . $markers[$markerIndex[$typeid]];
            $response['pavail_location'][] = $item;
        }
        
        //Get outlet channels
        $products = $this->Product->find('list');
        $response['pavail_product'][] = array('id' => 0, 'name' => "**Product**");
        foreach ($products as $key => $value) {
            $product['id'] = $key;
            $product['name'] = $value;
            $response['pavail_product'][] = $product;
        }
        
        $tempLocData = $this->getLocationData();
        $response['locations'] = $tempLocData['locations'];

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }
    
    
    private function _visitedLocation() {
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.phonenumber',
            'Outlet.streetnumber',
            'Outlet.streetname',
            'Outlet.town',
            'Outlet.geolocation',
            'Outlet.retailtype_id',
            'Location.locationname',
            'Retailtype.retailtypename',
            'User.id',
            'User.firstname',
            'User.lastname',
            'Schedule.scheduledate',
            'Schedule.visited'
        );
        $options['order'] = array('Outlet.created_at desc');
        $options['recursive'] = -1;

        //condition set
        $options['conditions'] = array('visited' => 1);
        if (isset($this->params['url']['loc'])) {
            $locParam = $this->params['url']['loc'];
            $options = $this->getOptionValueFromString($locParam, $options);
        }

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
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            ),
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            )
        );
        
        $visitedLocation = $this->Schedule->find('all', $options);
        return $visitedLocation;
    }
    
    private function _unvisitedLocation() {
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.phonenumber',
            'Outlet.streetnumber',
            'Outlet.streetname',
            'Outlet.town',
            'Outlet.geolocation',
            'Outlet.retailtype_id',
            'Location.locationname',
            'Retailtype.retailtypename',
            'User.id',
            'User.firstname',
            'User.lastname',
            'Schedule.scheduledate',
            'Schedule.visited'
        );
        $options['order'] = array('Schedule.created_at desc');
        $options['recursive'] = -1;
        
        //condition set
        $options['conditions'] = array('OR' => array('visited' => false, 'visited' => 0));
        if (isset($this->params['url']['loc'])) {
            $locParam = $this->params['url']['loc'];
            $options = $this->getOptionValueFromString($locParam, $options);
        }

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
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            ),
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            )
        );
        
        $unvisitedLocation = $this->Schedule->find('all', $options);
        return $unvisitedLocation;
    }
    
    public function visitmapinformation() {
        
//        $visited_markers = array(
//            'dot-red.png',
//            'dot-blue.png',
//            'dot-green.png',
//            'dot-yellow.png',
//            'dot-pink.png',
//            'dot-purple.png',
//            'dot-orange.png',
//            'dot-dark-green.png',
//            'dot-dark-purple.png',
//            'dot-grey.png',
//            'dot-light-grey.png'
//        );
//        $unvisited_markers = array(
//            'dot-red-unvisited.png',
//            'dot-blue-unvisited.png',
//            'dot-green-unvisited.png',
//            'dot-yellow-unvisited.png',
//            'dot-pink-unvisited.png',
//            'dot-purple-unvisited.png',
//            'dot-orange-unvisited.png',
//            'dot-dark-green-unvisited.png',
//            'dot-dark-purple-unvisited.png',
//            'dot-grey-unvisited.png',
//            'dot-light-grey-unvisited.png'
//        );
        
//        $iconUrl = 'assets/js/custommarkers/';
        
        $unvisitedIconUrl = 'assets/js/custommarkers/dot-red.png';
        $visitedIconUrl = 'assets/js/custommarkers/dot-green.png';
        
//        $retailtypes = $this->_getOutletTypes();
        
//        $markerIndex = array();
//        $i = 0;
//        foreach ($retailtypes as $key => $value) {
//            if($i > count($unvisited_markers)) { $i = 0; }
//            
//            $markerIndex[$key] = $i++;
//        }
        
        //get outlet details
        
        $visited = '0';
        if (isset($this->params['url']['vs'])) {
            $visited = $this->params['url']['vs'];
        }
        
        if($visited == '1') {
            $alllocations = $this->_visitedLocation();
        } else if($visited == '2'){
            $alllocations = $this->_unvisitedLocation();
        } else {
            $visitedLocations = $this->_visitedLocation();
            $unvisitedLocations = $this->_unvisitedLocation();
            $alllocations = array_merge($visitedLocations, $unvisitedLocations);
        }
        
//        $response = $outlets;
        $response = array();
        foreach ($alllocations as $alocation) {
            $item['outletid'] = $alocation['Outlet']['id'];
            $item['outletname'] = $alocation['Outlet']['outletname'];
            $pos = $alocation['Outlet']['geolocation'];
            $new_pos = str_replace(array('[', ']'), '', $pos);
            $arrLatLng = explode(',', $new_pos);

            $item['longitude'] = floatval($arrLatLng[0]);
            if (!isset($arrLatLng[1])) {
                continue;
            }
            
            $item['latitude'] = floatval($arrLatLng[1]);
            $item['phonenumber'] = $alocation['Outlet']['phonenumber'];
            $item['location'] = $alocation['Location']['locationname'];
            $item['retailtype'] = $alocation['Retailtype']['retailtypename'];
            $item['contactname'] = $alocation['User']['firstname'] . ' ' .$alocation['User']['lastname'];
            $item['address'] = $alocation['Outlet']['streetnumber'] . ', ' .$alocation['Outlet']['streetname']
                    . ', ' .$alocation['Outlet']['town'] . '.';
//            $typeid = $alocation['Outlet']['retailtype_id'];
            $item['scheduledate'] = $alocation['Schedule']['scheduledate'];
            $item['visited'] = $alocation['Schedule']['visited'];
            if($item['visited']) {
//                $item['iconUrl'] = $iconUrl . $visited_markers[$markerIndex[$typeid]];
                $item['iconUrl'] = $visitedIconUrl;
            } else {
//                $item['iconUrl'] = $iconUrl . $unvisited_markers[$markerIndex[$typeid]];
                $item['iconUrl'] = $unvisitedIconUrl;
            }
            
            $response['visit_location'][] = $item;
        }
        
        $response['visit_state'][] = array('id' => 0, 'name' => "All");
        $response['visit_state'][] = array('id' => 1, 'name' => "Visited");
        $response['visit_state'][] = array('id' => 2, 'name' => "Unvisited");
        
        $tempLocData = $this->getLocationData();
        $response['locations'] = $tempLocData['locations'];

        $jsonresponse = json_encode($response);
//        $jsonresponse = json_encode($unvisitedLocations);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }
    
    function search() {
        
    }

    private function _getParameterType($param, $name) {
        
        if(!is_null($param) && strpos($param, $name)) {
            $arrSplit = explode('-', $param);
            if(isset($arrSplit[1])) {
                return $arrSplit[1];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
