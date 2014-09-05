<?php

class SettingsController extends AppController {

    var $name = 'Settings';
    var $uses = array('Setting','Userrole');
    

    public function index() {
        
    }

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedSettingsModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
        $this->_sendUserrole();
        $uid = 'USER_' . $this->Auth->user('id');
        $id = $this->Setting->findByKey($uid);
        
        if(count($id) != 0) {
            $this->set('id', $id['Setting']['id']);
        }
    }

    private function _sendUserrole() {
        $user_roles = $this->Userrole->find('list');
        $this->set(array('fieldrepid' => $user_roles));
    }
    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('settings');
        $this->_setTitleOfPage('Application and User Settings');
    }

    public function savesettings() {

        if ($this->request->is('Post') || $this->request->is('Put')) {

            $settings = array();   
//            $options['conditions']['Setting.key !='] = 'USER_2';
//            $this->Setting->deleteAll($options);
            
            foreach ($this->request->data['Setting'] as $key => $value) {
                $temp['Setting']['key'] = $key;
                $temp['Setting']['value'] = $value;
                $temp['Setting']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
                $settings[] = $temp;
            }
            
            if ($this->Setting->save($settings)) {
                $this->Session->setFlash('Settings has been saved', 'page_notification_info');
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash('Cannot save current settings. Please, try again', 'page_notification_error');
            }
        }
    }

    public function currentuser() {
        
        $uid = 'USER_' . $this->Auth->user('id');
        $settings = $this->Setting->findByKey($uid);

        if ($settings) {
            $this->request->data = json_decode($settings['Setting']['value'], true);
            $this->request->data['Setting']['key'] = $settings['Setting']['key'];
            $this->request->data['Setting']['id'] = $settings['Setting']['id'];
            $this->request->data['Setting']['createdat'] = $settings['Setting']['createdat'];
            
            $this->set('response', json_encode($this->request->data));
            
            $this->layout = 'ajax';
            $this->view = 'ajax_response';
        }
    }

    public function changepassword() {

        $this->_setTitleOfPage('Change Password');
        
        $id = $this->_getCurrentUserId();
        $this->User->id = $id;
        $user = $this->User->read();
        $fullname = ucwords($user['User']['firstname'] . ' ' . $user['User']['lastname']);
        $this->set('fullname', $fullname);
        
//        debug($this->request->data);
        
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read();
        } else {
            
            if (($this->request->is('post') || $this->request->is('put')) && $this->User->exists()) {
            
                $old_password = $this->request->data['Setting']['old_password'];
                $db_old_password = $this->User->findById($id);
//                debug($old_password);
//                debug($db_old_password);
                if(hash('sha512', $old_password) == $db_old_password['User']['password']) {
                    $password = $this->request->data['Setting']['password'];
                    $confirm_password = $this->request->data['Setting']['confirm_password'];
                    if($password == $confirm_password) {
                        $user['User']['id'] = $id;
                        $user['User']['password'] = $password;
                        $user['User']['updatedat'] = $this->_createNowTimeStamp();

                        if ($this->User->save($user, false, array('password', 'updatedat'))) {
                            $this->Session->setFlash("Password successfully changed for {$fullname}", 'page_notification_info');
//                            $this->redirect(array('controller' => 'settings', 'action' => 'index'));
                        } else {
                            $this->Session->setFlash('Password reset not successful!. Please, try again', 'page_notification_error');
                        }
                    } else {
                        $this->Session->setFlash('Password do not match!. Please, try again', 'page_notification_error');
                    }
                } else {
                    $this->Session->setFlash('Password do not match old password!. Please, try again', 'page_notification_error');
                }
            }
        }
        
        $this->set('fullname', $fullname);

    }
    
}