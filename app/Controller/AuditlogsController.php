<?php

class AuditlogsController extends AppController {
    
    public $name = 'Auditlogs';
    var $uses = array('User', 'Userrole', 'Locationgroup');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();

        //get current user settings :)
        $this->setCurrentUserSettings();
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('fieldstaffs');
        $this->_setTitleOfPage('Activities');
    }
    
    public function index($id = null) {
        
        $this->User->id = $id;

        if (!$this->User->exists() || !$id) {
            $this->Session->setFlash('Invalid User selected', 'page_notification_error');
            $this->redirect(array('controller' => 'auditlogs', 'action' => 'index'));
        }

        $this->set(array('user' => $this->User->read()));
        $this->_setTitleOfPage('Activity Logs');
	}
    
    public function visits($id = null) {
        
    }
    
    public function outlets($id = null) {
        
    }
    
    public function orders($id = null) {
        
    }
    
    public function schedules($id = null) {
        
    }
}
