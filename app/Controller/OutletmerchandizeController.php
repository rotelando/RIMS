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
        
        $this->urloptions = $this->Filter->getUrlFilterOptions('Outletmerchandize');
        $this->postoptions = $this->Filter->getPostDataFilterOptions('Outletmerchandize');
        $this->_getFilterDisplayText($this->Filter->getFilterText($this->modelClass));
    }

    public function index() {

        $options = $this->postoptions;

        /*$outletmerchandize = $this->_getVisibilityEvaluations(10);
        $this->set('visibilities' , $outletmerchandize);*/
        
        $visibilitycount = $this->Outletmerchandize->find('count');
        $this->set('visibilitycount' , $visibilitycount);
        
        $merchandizecount = $this->Merchandize->find('count');
        $this->set('merchandizecount' , $merchandizecount);
        
        $brands = $this->Brand->getAllBrands();
        $this->set('brands', $brands);
        $merchandize = $this->Merchandize->getAllMerchandize();
        $this->set('merchandize', $merchandize);

        $topten = $this->Outletmerchandize->topTenOutletMerchandize($options, 10);
        $this->set('toptenmerchandize', $topten);

        $visibilitytable = $this->_getVisibilitySummary($options);
        $this->set('visibilitytable', $visibilitytable);
        $this->set(array('controller' => 'outletmerchandize', 'action' => 'index'));
    }

    public function shares() {

        $outletmerchandizecount = $this->Outletmerchandize->find('count');
        $this->set('visibilitycount' , $outletmerchandizecount);
        $this->set(array('controller' => 'outletmerchandize', 'action' => 'shares'));
    }

    public function merchandizeshare() {

        $options = $this->postoptions;


        $pieData = $this->Outletmerchandize->getShareByMerchandize($options);

        $pieItem = array();
        $resp = array();
        $ids = array();

        foreach ($pieData as $key => $value) {

            $elementname = $value['Merchandize']['name'];
            $beid = intval($value['Merchandize']['id']);
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
        $merchandize = $this->Merchandize->find('all');

        foreach ($merchandize as $key => $value) {
            $brandelementid = $value['Merchandize']['id'];
            if(isset($pieItem[$brandelementid])) {
                $respArray[] = $pieItem[$brandelementid];
            }
        }

        $response = json_encode($respArray);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('outletmerchandize');
        $this->_setTitleOfPage('Outlet Merchandize');
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
                  $this->params['url']['bid'],
                  $this->params['url']['mid'],
                  $this->params['url']['amt'])) {

            $outletmerchandize["Outletmerchandize"]['outlet_id'] = $this->params['url']['oid'];
            $outletmerchandize["Outletmerchandize"]['brand_id'] = $this->params['url']['bid'];
            $outletmerchandize["Outletmerchandize"]['merchandize_id'] = $this->params['url']['mid'];
            $outletmerchandize["Outletmerchandize"]['elementcount'] = $this->params['url']['amt'];
            $outletmerchandize["Outletmerchandize"]['appropriatelydeployed'] = $this->params['url']['adep'];

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

    public function brandshares() {

        $options = $this->urloptions;
        $rs = $this->Outletmerchandize->OutletMerchandizeBrandShares($options);

        //Calculate the total element value share
        $total = 0;
        foreach ($rs as $value) {
            $total += intval($value['0']['elementvalue']);
        }

        $resp = array();

        if (isset($rs[0][0]['elementvalue'])) {
            $i = 0;
            
            foreach ($rs as $value) {
                $data['name'] = $value['Brand']['brandname'];
                $data['y'] = intval($value[0]["elementvalue"]);
                $data['color'] = $value['Brand']['brandcolor'];
                $resp[] = $data;
                $i++;
            }
        }

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    private function _setTopTenMerchandizeBrand($limit) {

        $options = $this->urloptions;
        $resp = $this->Outletmerchandize->topTenOutletMerchandize($options, $limit);

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    public function elementperformance() {

        $options = $this->urloptions;
//        from visibilityevaluations group by brandid, visibilityelementid'

        $rs = $this->Outletmerchandize->merchandizePerformance($options);

        $resp = array();
        $categories = array();
        $series = array();

        foreach ($rs as $value) {

            $merchandize = $value['Merchandize']['name'];
            $categories[] = $merchandize;

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

    private function _getVisibilityEvaluations($number = null) {
        
        $options = $this->postoptions;
        
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Brand.brandname',
            'Merchandize.name',
            'Outletmerchandize.elementcount',
            'Outletmerchandize.outlet_id',
            'Outletmerchandize.id',
            '(Outletmerchandize.elementcount * Merchandize.weight) as grandvalue'
        );
        $options['order'] = array('Outletmerchandize.createdat DESC');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Outletmerchandize.outlet_id'
                )
            ),
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brand_id = Brand.id'
                )
            ),
            array(
                'table' => 'merchandize',
                'alias' => 'Merchandize',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.merchandize_id = Merchandize.id'
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
    
    public function mapdata() {

        $options = $this->urloptions;

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
        $visibility_by_location = $this->Outletmerchandize->getMerchandizeCountByLocation($options);
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

    //get map item info when clicked
    public function mapitemdata($id) {

        $visibilitybylocation = $this->Outletmerchandize->getMapInfo($id);
        foreach ($visibilitybylocation as $branditem) {
            $item['merchandize'] = $branditem['Merchandize']['name'];
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
    
    private function _getVisibilitySummary($options) {
    
        $allbrands = $this->Brand->getAllBrands();
        $allbrandelements = $this->Merchandize->getAllMerchandize();
        $merchandizecount = $this->Outletmerchandize->getMerchandizeCountByBrand($options);
        
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
                
                for ($k = 0; $k < count($merchandizecount); $k++) {
                    if($merchandizecount[$k]['Brand']['id'] == $allbrands[$j]['Brand']['id'] &&
                            $merchandizecount[$k]['Merchandize']['id'] == $allbrandelements[$i]['Merchandize']['id']) {
                        
                        $tableMatrix[$i][$j] = $merchandizecount[$k];
                        $total += intval($merchandizecount[$k][0]['totalquantity']);
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
