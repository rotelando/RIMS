<?php

class OutletmerchandizeController extends AppController {

    var $name = 'outletmerchandize';
    var $uses = array('Outletmerchandize', 'Outlet', 'Brand', 'Merchandize', 'Location');
    var $components = array('Paginator', 'Filter');

    public $urloptions = array();
    public $postoptions = array();
    

    public function beforeFilter() {
        parent::beforeFilter();
      
        $this->_setViewVariables();
        
        $this->urloptions = $this->Filter->getUrlFilterOptions($this->modelClass);
        $this->postoptions = $this->Filter->getPostDataFilterOptions($this->modelClass);
        $this->_getFilterDisplayText($this->Filter->getFilterText($this->modelClass));
    }

    public function index() {
        
        
        $outletmerchandize = $this->_getVisibilityEvaluations(10);
        $this->set('visibilities' , $outletmerchandize);
        
        $visibilitycount = $this->Outletmerchandize->find('count');
        $this->set('visibilitycount' , $visibilitycount);
        
        $merchandizecount = $this->Merchandisecount->find('count');
        $this->set('merchandizecount' , $merchandizecount);
        
        $brands = $this->_getAllBrands();
        $this->set('brands', $brands);
        $brandelements = $this->_getAllBrandElements();
        $this->set('brandelements', $brandelements);
        $visibilitytable = $this->_getVisibilitySummary();
        $this->set('visibilitytable', $visibilitytable);
        
//        debug($this->request->data);
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('visibilities');
        $this->_setTitleOfPage('Visibility Evaluations');
    }

    public function save() {

        $id = '';
        $outletmerchandize = array();
        if (isset($this->params['url']['id'])) {
            $outletmerchandize["Outletmerchandize"]['id'] = $this->params['url']['id'];
            $id = $outletmerchandize["Outletmerchandize"]['id'];            
            $outletmerchandize["Outletmerchandize"]["updated_at"] = $this->_createNowTimeStamp();
        } else {
            $outletmerchandize["Outletmerchandize"]["created_at"] = $this->_createNowTimeStamp();
        }

        if (isset($this->params['url']['oid'],
                  $this->params['url']['bn'],
                  $this->params['url']['ben'],
                  $this->params['url']['amt'])) {

            $outletmerchandize["Outletmerchandize"]['outlet_id'] = $this->params['url']['oid'];
            $outletmerchandize["Outletmerchandize"]['brandid'] = $this->params['url']['bn'];
            $outletmerchandize["Outletmerchandize"]['visibilityelementid'] = $this->params['url']['ben'];
            $outletmerchandize["Outletmerchandize"]['elementcount'] = $this->params['url']['amt'];

            if($this->Outletmerchandize->save($outletmerchandize)) {
                $resp['status'] = 1;
                $resp['message'] = "visibility evaluations data successfully updated";
                $resp['data'] = $this->_getVisibilityEvaluation($id);
            } else {
                $resp['status'] = 0;
                $resp['message'] = "Problem updating visibility evaluations data";
            }

        } else {
            $resp['status'] = 0;
            $resp['message'] = "Incomplete data available";
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response); 
    }

    public function delete($id) {


        if (isset($id)) {

            if ($this->Outletmerchandize->delete($id)) {
                $resp['status'] = 1;
                $resp['message'] = "Merchandize data successfully deleted";
            } else {
                $resp['status'] = 0;
                $resp['message'] = "problem deleting Merchandize data ";
            }
        }  else {
            $resp['status'] = 0;
            $resp['message'] = "problem deleting Merchandize data ";
        }

        $resp['data'] = $id;
        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    private function _getVisibilityEvaluation($id) {
        if($id == '') {
            $id = $this->Outletmerchandize->getLastInsertID();
        }

        $options['fields'] = array(
            'Brand.brandname',
            'Brandelement.brandelementname',
            'Outletmerchandize.id',
            'Outletmerchandize.elementcount',
            'Outletmerchandize.visitid',
            'Outletmerchandize.brandid',
            'Outletmerchandize.elementcount'
        );
        $options['recursive'] = -1;
        $options['joins'] = array(
            
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.visibilityelementid = Brandelement.id'
                )
            )
        );
        $options['conditions']['Outletmerchandize.id'] = $id;
        $visibilityEvaluation = $this->Outletmerchandize->find('first', $options);
        return $visibilityEvaluation;
    }

    public function get_list_data() {
        $merchandize = $this->Merchandize->find('list');
        $brands = $this->Brand->find('list');
        $resp = array();
        foreach ($brands as $key => $value) {
            $resp["brands"][] = array(
                "id" => $key,
                "name" => $value
            );
        }
        foreach ($merchandize as $key => $value) {
            $resp["merchandize"][] = array(
                "id" => $key,
                "name" => $value
            );
        } 
        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);       
    }

    public function visibilityshares() {

        $options = $this->urloptions;
//        from visibilityevaluations group by brandid, visibilityelementid'
        
        $options['fields'] = array(
            'Brand.brandname',
            'Brand.brandcolor', 
            'Outletmerchandize.brandid',
            'SUM(Outletmerchandize.elementcount * Brandelement.weight) as elementvalue'
        );
        $options['group'] = array('Outletmerchandize.brandid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Outletmerchandize.visitid'
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
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.visibilityelementid = Brandelement.id'
                )
            )
        );
        
        $rs = $this->Outletmerchandize->find('all', $options);

        //Calculate the total element value share
        $total = 0;
        foreach ($rs as $value) {
            $total += intval($value['0']['elementvalue']);
        }

        $resp = array();

        if (isset($rs[0][0]['elementvalue'])) {

            // $max = $rs[0][0]['elementvalue'];
            // $max_index = 0;
            $i = 0;
            
            foreach ($rs as $value) {
                $data['name'] = $value['Brand']['brandname'];
                $data['y'] = intval($value[0]["elementvalue"]);
//                $data['y'] = round((intval($value[0]["elementvalue"]) / $total) * 100, 2);
                // if ($data['y'] > $max) {
                //     $max = $data['y'];
                //     $max_index = $i;
                // }
                $data['color'] = $value['Brand']['brandcolor'];
                $resp[] = $data;
                $i++;
            }

            // $resp[$max_index]['selected'] = true;
            // $resp[$max_index]['sliced'] = true;
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    public function merchandizegiveoutshare() {

        $options = $this->urloptions;
//        from visibilityevaluations group by brandid, visibilityelementid'
        
        $options['fields'] = array(
            'Brandelement.id',
            'Brandelement.brandelementname', 
            'SUM(Merchandisecount.elementcount * Brandelement.weight) as elementvalue'
        );
        $options['group'] = array('Brandelement.id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Merchandisecount.visitid'
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
                    'Outlet.userid = User.id'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Merchandisecount.visibilityelementid = Brandelement.id'
                )
            )
        );
        
        $rs = $this->Merchandisecount->find('all', $options);

        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607', '#8b0607', '#8b0607', '#8b0607'];
        
        //Calculate the total element value share
        $total = 0;
        foreach ($rs as $value) {
            $total += intval($value['0']['elementvalue']);
        }

        $resp = array();

        if (isset($rs[0][0]['elementvalue'])) {
            // $max = $rs[0][0]['elementvalue'];
            // $max_index = 0;
            $i = 0;
            
            foreach ($rs as $value) {
                $data['name'] = $value['Brandelement']['brandelementname'];
                $data['y'] = intval($value[0]["elementvalue"]);
//                $data['y'] = round((intval($value[0]["elementvalue"]) / $total) * 100, 2);
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
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    
    public function merchandise_distribution() {

        $options = $this->urloptions;
//        from visibilityevaluations group by brandid, visibilityelementid'
        
        $options['fields'] = array(
            'Brandelement.id',
            'Brandelement.brandelementname',
            'SUM(Merchandisecount.elementcount) as elementvalue'
            // 'SUM(Merchandisecount.elementcount * Brandelement.weight) as elementvalue'
        );
        $options['group'] = array('Brandelement.id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Merchandisecount.visitid'
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
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Merchandisecount.visibilityelementid = Brandelement.id'
                )
            )
        );
        
        $rs = $this->Merchandisecount->find('all', $options);

        //Calculate the total element value share
        $total = 0;
        foreach ($rs as $value) {
            $total += intval($value['0']['elementvalue']);
        }

        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];
        $resp = array();

//        debug($rs);
        
        if (isset($rs[0][0]['elementvalue'])) {
            // $max = $rs[0][0]['elementvalue'];
            // $max_index = 0;
            $i = 0;
            
            foreach ($rs as $value) {
                $data['name'] = $value['Brandelement']['brandelementname'];
                $data['y'] = intval($value[0]["elementvalue"]);
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
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    public function elementperformance() {

        $options = $this->urloptions;
//        from visibilityevaluations group by brandid, visibilityelementid'
        
        $options['fields'] = array(
            'Brand.brandname',
            'Brand.brandcolor',
            'Brandelement.brandelementname',
            // 'ISNULL(SUM(Outletmerchandize.elementcount), 0) AS count'
            'SUM(Outletmerchandize.elementcount * Brandelement.weight) as count'
        );
        $options['group'] = array('Outletmerchandize.brandid', 'Outletmerchandize.visibilityelementid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Outletmerchandize.visitid'
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
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.visibilityelementid = Brandelement.id'
                )
            )
        );
        
        $rs = $this->Outletmerchandize->find('all', $options);

        $resp = array();
        $categories = array();
        $series = array();
        
        foreach ($rs as $value) {
            
            $brandelementname = $value['Brandelement']['brandelementname'];
            $categories[] = $brandelementname;
            
            $brandname = $value['Brand']['brandname'];

            $series[$brandname]['name'] = $brandname;
            $series[$brandname]['color'] = $value['Brand']['brandcolor'];
            if(isset($value[0]['count'])) {
                $series[$brandname]['data'][] = intval($value[0]['count']);
            } else {
                $series[$brandname]['data'][] = 0;
            }
            
        }
        
        $resp['categories'] = array_values(array_unique($categories));
        $resp['series'] = array_values($series);
        $response = json_encode($resp);
        
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    private function _getVisibilityEvaluations($number = null) {
        
        $options = $this->postoptions;
        
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Brand.brandname',
            'Brandelement.brandelementname',
            'Outletmerchandize.elementcount',
            'Outletmerchandize.visitid',
            'Outletmerchandize.id',
            '(Outletmerchandize.elementcount * Brandelement.weight) as grandvalue'
        );
        $options['order'] = array('Outletmerchandize.createdat DESC');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Outletmerchandize.visitid'
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
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.visibilityelementid = Brandelement.id'
                )
            )
        );

        $this->Paginator->settings = $options;
        $outletmerchandize = $this->Paginator->Paginate('Outletmerchandize');
        return $outletmerchandize;
    }
    
    public function all() {
        $outletmerchandize = $this->_getVisibilityEvaluations(25);
        $this->set('visibilities' , $outletmerchandize);
    }

    public function shares() {
        $visibilitycount = $this->Outletmerchandize->find('count');
        $this->set('visibilitycount' , $visibilitycount);
    }

    public function brandelementshare() {
        
        $options = $this->urloptions;

        $options['fields'] = array(
            'Brandelement.brandelementname',
            'Brandelement.id',
            'Brand.brandname',
            'Brand.brandcolor', 
            'Outletmerchandize.brandid',
            'SUM(Outletmerchandize.elementcount * Brandelement.weight) as elementvalue'
        );
        $options['group'] = array('Brandelement.id', 'Outletmerchandize.brandid');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Outletmerchandize.visitid'
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
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.visibilityelementid = Brandelement.id'
                )
            )
        );
        
        $pieData = $this->Outletmerchandize->find('all', $options);

        $pieItem = array();        
        $resp = array();
        $ids = array();

        foreach ($pieData as $key => $value) {
            
            $elementname = $value['Brandelement']['brandelementname'];
            $beid = intval($value['Brandelement']['id']);
            if(!in_array($beid, $ids)) {
                $pieItem[$beid] = [];
                $ids[] = $beid;
            }

            $data['name'] = $value['Brand']['brandname'];
            $data['y'] = intval($value[0]["elementvalue"]);
            $data['color'] = $value['Brand']['brandcolor'];

            $pieItem[$beid]['elementname'] = $elementname;
            $pieItem[$beid]['data'][] = $data;
        }

        $respArray = array();
        $brandelements = $this->Brandelement->find('all');

        foreach ($brandelements as $key => $value) {
            $brandelementid = $value['Brandelement']['id'];
            if(isset($pieItem[$brandelementid])) {
                $respArray[] = $pieItem[$brandelementid];
            }
        }

        
        $response = json_encode($respArray);
        // $response = json_encode($resp);


        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
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
        $visibility_by_location = $this->_visibilityCountByLocation();
        foreach ($visibility_by_location as $visibility) {
            
            $id = $visibility['State']['internalid'];
            $value = $visibility[0]['elementvalue'];
            
            if(!isset($mapdata['data'][$id]['toolText'])) { 
                
                $tooltext = $visibility['State']['statename'] . '{br}' . $visibility['Brand']['brandname'] . " ({$value})";
                $brandcolor = str_replace('#', '', $visibility['Brand']['brandcolor']);
                $mapdata['data'][$id]['id'] = $id;
                $mapdata['data'][$id]['value'] = $value;
                $mapdata['data'][$id]['toolText'] = $tooltext;
                $mapdata['data'][$id]['color'] = $brandcolor;
                $mapdata['data'][$id]['link'] = 'JavaScript:getVisibilityDetailFromMap("' . $id . '")';
                
            } else {
                
                $tooltext = $mapdata['data'][$id]['toolText'];
                 $tooltext .= '{br}' . $visibility['Brand']['brandname'] . " ({$value})";
                $mapdata['data'][$id]['toolText'] = $tooltext;
               
            }
           
        }
        

        $mapdata['data'] = array_values($mapdata['data']);
        $response = json_encode($mapdata);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    
    private function _visibilityCountByLocation() {
        
        $options = $this->urloptions;
        
        $options['fields'] = array(
            'Brandelement.brandelementname, '
            . 'Brand.brandname, '
            . 'Brand.brandcolor, '
            . 'Outletmerchandize.brandid, '
            . 'State.internalid, '
            . 'State.statename, '
            // . 'SUM(Outletmerchandize.elementcount * Brandelement.weight) as elementvalue'
            . 'SUM(Outletmerchandize.elementcount) as elementvalue'
            );
        $options['group'] = array('State.internalid', 'Brand.id');
        $options['order'] = array('State.internalid', 'elementvalue DESC');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brand.id = Outletmerchandize.brandid'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brandelement.id = Outletmerchandize.visibilityelementid'
                )
            ),
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Outletmerchandize.visitid'
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
        $visibilitybylocation = $this->Outletmerchandize->find('all', $options);
        
        return $visibilitybylocation;
    }
    
    public function mapitemdata($id) {
        $options['fields'] = array(
            'Brandelement.brandelementname, '
            . 'Brand.brandname, '
            . 'Brand.brandcolor, '
            . 'Outletmerchandize.brandid, '
            . 'State.internalid, '
            . 'State.statename, '
            . 'SUM(Outletmerchandize.elementcount) as elementvalue'
            );
        $options['conditions']['State.internalid'] = $id;
        $options['group'] = array('State.internalid', 'Brand.id', 'Brandelement.id');
        $options['order'] = array('Brandelement.id', 'elementvalue DESC');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brand.id = Outletmerchandize.brandid'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brandelement.id = Outletmerchandize.visibilityelementid'
                )
            ),
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Outletmerchandize.visitid'
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
        $visibilitybylocation = $this->Outletmerchandize->find('all', $options);
        foreach ($visibilitybylocation as $branditem) {
            $item['brandelementname'] = $branditem['Brandelement']['brandelementname'];
            $item['brandname'] = $branditem['Brand']['brandname'];
            $item['brandcolor'] = $branditem['Brand']['brandcolor'];
            $item['stateid'] = $branditem['State']['internalid'];
            $item['statename'] = $branditem['State']['statename'];
            $value = intval($branditem[0]['elementvalue']);
            $item['count'] = $value;
            $response[] = $item;
        }
        $response = json_encode($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    
    private function _getVisibilitySummary() {
    
        $allbrands = $this->_getAllBrands();
        $allbrandelements = $this->_getAllBrandElements();
        $brandelementcount = $this->_getBrandElementCountByBrand();
        
        $tableMatrix = array();
        //Table calculation starts from here
        $tableMatrix[0][0] = 'Merchandising Elements';

        foreach ($allbrands as $brand) {
            $tableMatrix[0][] = $brand;         //Brands as first row
        }      
        
        for ($i = 0; $i < count($allbrandelements); $i++) {
            
            $total = 0;
            for ($j = 0; $j < count($allbrands); $j++) {
                
                $found = false;
                
                for ($k = 0; $k < count($brandelementcount); $k++) {
                    if($brandelementcount[$k]['Brand']['id'] == $allbrands[$j]['Brand']['id'] &&
                            $brandelementcount[$k]['Brandelement']['id'] == $allbrandelements[$i]['Brandelement']['id']) {
                        
                        $tableMatrix[$i][$j] = $brandelementcount[$k];
                        $total += intval($brandelementcount[$k][0]['totalquantity']);
                        $found = true;
                        break;
                    }
                }
                
                if(!$found) {
                    $tableMatrix[$i][$j] = null;
                }
            }
            
            $tableMatrix[$i][$j]['sumtotal'] = $total;
        }
        
        return $tableMatrix;
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
    
    private function _getAllBrandElements() {
        //Get All Brand Elements
        $options['fields'] = array(
            'Brandelement.id',
            'Brandelement.brandelementname',
            'Brandelement.weight',
        );
        $options['order'] = array('Brandelement.id');
        $options['recursive'] = -1;

        $allbrandelements = $this->Brandelement->find('all', $options);
        return $allbrandelements;
    }
    
    private function _getBrandElementCountByBrand() {
        
        $options = $this->postoptions;
        
        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Brandelement.id',
            'Brandelement.brandelementname',
            'Brandelement.weight',
            'Outletmerchandize.id',
            'SUM(Outletmerchandize.elementcount) AS totalquantity'
        );
        $options['recursive'] = -1;
        $options['order'] = array('Outletmerchandize.visibilityelementid');
        $options['group'] = array('Outletmerchandize.visibilityelementid, Outletmerchandize.brandid');
        
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Outletmerchandize.visitid'
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
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brandid = Brand.id'
                )
            ),
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.visibilityelementid = Brandelement.id'
                )
            )
        );
        
        $outletmerchandizetable = $this->Outletmerchandize->find('all', $options);
        return $outletmerchandizetable;
        
    }
    
    public function _generateRandomHexadecimalColorCode() {
        $min = 0;
        $max = 15;
        $hexa_digit = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'A', 'B', 'C', 'D', 'E', 'F');
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $hexa_digit[intval(rand($min, $max))];
        }

        return $color;
        
    }

    public function generatevisibilitydata() {

        //Generate Visibility Evaluation data
        $test_data = array();
        for ($i = 400; $i <= 1200; $i++) {

            $test_data['Outletmerchandize']['id'] = $i;
            $test_data['Outletmerchandize']['visitid'] = rand(1, 843);
            $test_data['Outletmerchandize']['brandid'] = rand(1, 2);
            $test_data['Outletmerchandize']['visibilityelementid'] = rand(1, 4);
            $test_data['Outletmerchandize']['elementcount'] = rand(8, 10);
            $test_data['Outletmerchandize']['createdat'] = '2013-' . rand(11, 12) . '-' . rand(1, 30) . ' '
                    . rand(10, 18) . ':' . rand(0, 59) . ':' . rand(0, 59);

            $response[] = $test_data;
        }

        $this->Outletmerchandize->SaveAll($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', json_encode($response));
    }

}
