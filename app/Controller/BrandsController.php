<?php

class BrandsController extends AppController {
    
    var $uses = array('Brand');
    
    public function beforeFilter() {
        
        parent::beforeFilter();
        
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('brands');
        $this->_setTitleOfPage('Brands');
    }
    
    public function index() {
        $this->_getAllBrands();
        $this->_setViewVariables();
    }
    
    public function add($id = null) {
        
        if ($this->request->is('Post') || $this->request->is('Put')) {
            if(intval($this->request->data['Brand']['current']) == 1) {
                $this->_unsetAllBrandCurrent();
                $this->Brand->id = null;
            }
            
            if(!isset($this->request->data['Brand']['brandcolor']) || ($this->request->data['Brand']['brandcolor'] == ''))
                $this->request->data['Brand']['brandcolor'] = $this->_generateRandomHexadecimalColorCode();
                
            $this->request->data['Brand']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            
            if ($this->Brand->save($this->request->data)) {
                
                $this->Session->setFlash($this->request->data['Brand']['brandname'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'brands', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem creating brand. Please, try again', 'page_notification_error');
                $this->beforeFilter();
            }
            
            $this->render('index');
        }
    }
    
    public function edit($id) {
        
        
        
        $this->Brand->id = $id;
        
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {
            
            $this->request->data = $this->Brand->read();
            $this->request->data['Brand']['brandcolor'] = str_replace('#', '', $this->request->data['Brand']['brandcolor']);
//            debug($this->request->data);
            $this->set('data', $this->request->data);
            $this->_getAllBrands();
            $this->_setViewVariables();
            $this->render('index');
            
        } else {   
            
            $this->add($id);
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid Brand selected', 'page_notification_error');
            $this->redirect(array('controller' => 'brands', 'action' => 'index'));
        }

        $this->Brand->id = $id;

        if ($this->Brand->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Brand has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'brands', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete Brand. Please, try again', 'page_notification_error');
        }
    }
    
    
    
    private function _unsetAllBrandCurrent() {
        $brands = $this->Brand->find('all');
        for($i = 0; $i < count($brands); $i++) {
            $brands[$i]['Brand']['current'] = 0;
        }
        $this->Brand->saveMany($brands);
    }
    
    public function _generateRandomHexadecimalColorCode() {
        $min = 0; $max = 15;
        $hexa_digit = array('1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F');
        $color = '#';
        for($i = 0; $i < 6; $i++) {
            $color .= $hexa_digit[intval(rand($min, $max))];
        }
//        debug('generated color: ' + $color);
        return $color;
    }
    
    private function _getAllBrands(){
        $brands = $this->Brand->find('all'); 
        $this->set(array('brands'=>$brands));
    }
    
    private function _setViewVariables() {
        $this->set(array(
            'title_of_page_header' => 'Brands',
            'sub_menu_active' => 'brands',
            'pri_nav_active' => 'setup'
        ));
    }
    
}