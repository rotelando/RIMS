<?php

class ReportsController extends AppController {

    var $name = 'Reports';
    var $uses = array('Visit', 'Schedule', 'Outlet');
    var $helpers = array('Time');

    public function index() {
        
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedReportsModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
     
        //get current user settings :)
        $this->setCurrentUserSettings();
    }
    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('reports');
        $this->_setTitleOfPage('Reports');
    }
}
