<?php

class OrderstatusesController extends AppController {

    var $name = 'Orderstatuses';
    var $uses = array('Orderstatus');

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedSetupModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
        
    }
    
    public function index() {
        $this->_fetchAndSetAllOrderStatuses();
    }

    public function add($id = null) {
        
        $this->render('index');
        
//        debug($this->request->data);
        if ($this->request->is('Post') || $this->request->is('Put')) {
                
            $this->request->data['Orderstatus']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Orderstatus->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Orderstatus']['orderstatusname'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'orderstatuses', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding order status. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid outlet type selected', 'page_notification_error');
            $this->redirect(array('controller' => 'orderstatuses', 'action' => 'index'));
        }

        $this->Orderstatus->id = $id;

        if ($this->Orderstatus->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Order status has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'orderstatuses', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete status. Please, try again', 'page_notification_error');
        }
    }
    
    public function edit($id = null) {
        
        $this->render('index');
        
        $this->Orderstatus->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {
            
            $this->request->data = $this->Orderstatus->read();
            $this->set('data', $this->request->data);
            $this->_fetchAndSetAllOrderStatuses();
            $this->_setViewVariables();
        }
        
        $this->add($id);
        
    }
    
    private function _fetchAndSetAllOrderStatuses() {
        $orderstatuses = $this->Orderstatus->find('all'); 
        $this->set(array('orderstatuses'=>$orderstatuses));
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('statuses');
        $this->_setTitleOfPage('Order Status');
    }
    
    public function exists($name = null) {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        
        $result = $this->Orderstatus->find('all', array('conditions'=>array('orderstatusname'=>$name))); 

        if(!empty($result))  {
            $response = '{ "meta" : { "status" : true, "message" : "'. $name . ' already exist" } }';
        } else {
            $response = '{ "meta" : { "status" : false, "message" : "'. $name . ' is available" } }';
        }
        
        $this->set('response' , $response);
    }
}
