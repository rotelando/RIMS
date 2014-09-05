<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP Outletchannels
 * @author RotelandO
 */
class OutletchannelsController extends AppController {


    var $name = 'Outletchannels';
    var $uses = array('Outletchannel', 'Outlettype');

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedSetupModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
        $this->_fetchAndSetAllOutletTypes();
        $this->_fetchAllOutletChannels();
    }
    
    public function index() {
        
    }

    public function add($id = null) {
        
        $this->render('index');
        
        if ($this->request->is('Post') || $this->request->is('Put')) {
                
            $this->request->data['Outletchannel']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Outletchannel->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Outletchannel']['outletchannelname'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'outletchannels', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding outlet channel. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid outlet channel selected', 'page_notification_error');
            $this->redirect(array('controller' => 'outletchannels', 'action' => 'index'));
        }

        $this->Outletchannel->id = $id;

        if ($this->Outletchannel->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Outlet channel has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'outletchannels', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete type. Please, try again', 'page_notification_error');
        }
    }
    
    public function edit($id = null) {
        
        $this->render('index');
        
        $this->Outletchannel->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {
            
            $this->request->data = $this->Outletchannel->read();
            $this->set('data', $this->request->data);
            $this->_fetchAllOutletChannels();
            $this->_setViewVariables();
        }
        
        $this->add($id);
        
    }
    
    private function _fetchAndSetAllOutletTypes() {
        $outlettypes = $this->Outlettype->find('all'); 
        $this->set(array('outlettypes'=>$outlettypes));
    }

    private function _fetchAllOutletChannels() {
        $outletchannels = $this->Outletchannel->find('all'); 
        $this->set(array('outletchannels'=>$outletchannels));   
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('types');
        $this->_setTitleOfPage('Outlet Channels');
    }
    
    public function exists($name = null) {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        
        $result = $this->Outletchannel->find('all', array('conditions'=>array('outletchannelname'=>$name))); 

        if(!empty($result))  {
            $response = '{ "meta" : { "status" : true, "message" : "'. $name . ' already exist" } }';
        } else
            $response = '{ "meta" : { "status" : false, "message" : "'. $name . ' is available" } }';
        
        $this->set('response' , $response);
    }
}
