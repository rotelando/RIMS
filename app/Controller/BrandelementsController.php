<?php

class BrandelementsController extends AppController {

    var $name = 'merchandize';
    var $uses = array('Brandelement');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedUserModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
        $this->_getAllBrandelements();
    }
    
    public function index() {
        
    }
    
    public function add($id = null) {
        
        $this->render('index');
        
//        debug($this->request->data);
        if ($this->request->is('Post') || $this->request->is('Put')) {
                
            $this->request->data['Brandelement']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Brandelement->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Brandelement']['brandelementname'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'brandelements', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding brand element. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid Brand Element selected', 'page_notification_error');
            $this->redirect(array('controller' => 'brandelements', 'action' => 'index'));
        }

        $this->Brandelement->id = $id;

        if ($this->Brandelement->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Brand Element has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'brandelements', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete Brand Element. Please, try again', 'page_notification_error');
        }
    }
    
    public function edit($id = null) {
        
        $this->render('index');
        
        $this->Brandelement->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {
            
            $this->request->data = $this->Brandelement->read();
            $this->set('data', $this->request->data);
            $this->_getAllBrandelements();
            $this->_setViewVariables();
        }
        
        $this->add($id);
        
    }
    
    private function _getAllBrandelements(){
        $brandelements = $this->Brandelement->find('all'); 
        $this->set(array('brandelements'=>$brandelements));
    }
    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('brandelements');
        $this->_setTitleOfPage('Brand Elements');
    }

}
