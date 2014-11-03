<?php

class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('User', 'Userrole', 'Outlet');
    //public $components = array('SSP');

    public function beforeFilter() {

        parent::beforeFilter();
        
//        $this->UserAccessRight->checkAuthorization('isAllowedUserModule', $this->_getCurrentUserId(), 'view');
        
        $this->_setSidebarActiveItem('users');
        
    }

    public function index() {

        $this->_getAllUsers();
        //$this->_sendUserrole();
        $this->_setTitleOfPage('User Management');
        //$this->_getAndSetCompanyId();
    }

    public function login() {
        
        $this->_setTitleOfPage('User Login');
        
        if($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
        }
            
        $this->layout = 'auth_layout';

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->set(array('is_error' => true));
                $this->Session->setFlash('Your Username/Password in incorrect! Please try again', 'page_notification_error', array('is_error' => true));
            }

            $this->request->data['User']['password'] = '';
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    private function _getAndSetCompanyId() {
        $settings = $this->Setting->find('first', array('conditions' => array('key' => 'companyid')));
        if(isset($settings['Setting']['key'])) {
            $companyid = $settings['Setting']['value'];
            $this->request->data['License']['companyid'] = $companyid;
            $this->set($this->request->data);
        } else {
            $this->Session->setFlash('It seems you haven\'t setup your company ID. <a class="btn btn-small btn-primary" href="settings">Setup</a>', 'page_notification_warning');
        }
    }
    
    private function _getCompanyID() {
        $settings = $this->Setting->find('first', array('conditions' => array('key' => 'companyid')));
        if(isset($settings['Setting']['key'])) {
            $companyid = $settings['Setting']['value'];
            return $companyid;
        } else {
            return null;
        }
    }

    public function add() {

        //$this->_getAndSetCompanyId();
        $this->_setTitleOfPage('New User');
        $this->_sendUserrole();


        if ($this->request->is('Post') || $this->request->is('Put')) {
            
            //check if user has license to had users
            //get all license keys
            //if($this->isEnoughLicense()) {
                if(isset($this->request->data['User']['active']))
                    $this->request->data['User']['active'] = 1;

                $this->request->data['User']['created_at'] = $this->_createNowTimeStamp();    //create now timestamp if not set
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash($this->request->data['User']['username'] . ' has been saved', 'page_notification_info');
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                } else {
                    $this->Session->setFlash($this->request->data['User']['username'] . ' cannot be saved. Please, try again', 'page_notification_error');
                }
            //} else {
            //    $this->Session->setFlash('License has been exhaused. Please contact support to buy a new license.', 'page_notification_error');
            //}
        }
    }

    private function isEnoughLicense() {
        $companyid = $this->_getCompanyID();
        $licenses = $this->License->find('all', array('fields' => array('licensekey')));
        $keys = array();
        if(count($licenses) != 0) {
            foreach ($licenses as $license) {
                $keys[] = $license['License']['licensekey'];
            }
            $keys = implode(',', $keys);
            $url = "http://api.licensing.fieldmaxpro.com/keys/validate/{$companyid}?keys={$keys}";
            $license = file_get_contents($url);
            $arrLicense = json_decode($license);
            
            if($arrLicense->meta->status == 1) {
                //get total user from db
                $usercount = $this->User->find('count');
                if($usercount < $arrLicense->data->totalUserAllowance) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
            
        } else {
            return false;
        }
    }
    
    public function edit($id = null) {
        
        $this->_setTitleOfPage('Edit User');
        
        $this->_sendUserrole();
        $this->User->id = $id;
        
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read();
            $this->set(array('active' => $this->request->data['User']['active'], 'rolename' => $this->data['Userrole']['userrolename']));
        } else {
            if (($this->request->is('post') || $this->request->is('put')) && $this->User->exists()) {
                $this->request->data['User']['updated_at'] = $this->_createNowTimeStamp();
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('User has been updated', 'page_notification_info');
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                } else {
                    $this->Session->setFlash($this->request->data['User']['username'] . ' cannot be saved. Please, try again', 'page_notification_error');
                }
            }
        }
    }

    public function view($id = null) {
        
        $this->_setTitleOfPage('User View');
        $this->_setBreadCrumb(array('Home', 'Users', 'View'));
        
        $this->User->id = $id;

        if (!$this->User->exists() || !$id) {
            $this->Session->setFlash('Invalid User selected', 'page_notification_error');
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }


        $userScheduleVisitCount = $this->_getUserPlannedVisitCount($id);
        $userActualVisitCount = $this->_getUserActualVisitCount($id);
        $userOutletCount = $this->_getUserOutletCount($id);
        $userSalesCount = $this->_getUserSalesCount($id);

        $this->set(
            array(
                'user' => $this->User->read(),
                'plannedVisitCount' => $userScheduleVisitCount,
                'actualVisitCount' => $userActualVisitCount,
                'outletCount' => $userOutletCount,
                'salesCount' => $userSalesCount
            )
        );
        $this->_setTitleOfPage('Profile View');
        
    }

    private function _getUserPlannedVisitCount($id) {
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            )
        );
        $options['conditions']['Outlet.userid'] = $id;
        return $this->Schedule->find('count', $options);
    }

    private function _getUserActualVisitCount($id) {
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            )
        );
        $options['conditions']['Outlet.userid'] = $id;
        return $this->Visit->find('count', $options);
    }

    private function _getUserOutletCount($id) {
        $options['recursive'] = -1;
        $options['conditions']['Outlet.userid'] = $id;
        return $this->Outlet->find('count', $options);
    }

    private function _getUserSalesCount($id) {
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
            )
        );
        $options['conditions']['Outlet.userid'] = $id;
        return $this->Order->find('count', $options);
    }

    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid User selected', 'page_notification_error');
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }

        $this->User->id = $id;
        
        if ($this->User->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('User has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        } else {
            $this->Session->setFlash('User cannot be deleted. Please, try again', 'page_notification_error');
        }
    }

    public function deactivate($id = null) {

        $this->view = 'index';
        
//        $this->User->id = $id;
//        $this->User->read();

        if (($this->request->is('get') && $this->User->exists($id))) {
            $user = array();
            $user['User']['id'] = intval($id);        
            $user['User']['active'] = 0;        
            $user['User']['updatedat'] = $this->_createNowTimeStamp();
            if ($this->User->save($user, false)) {
                $this->Session->setFlash('User has been deactivated', 'page_notification_info');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            } else {
                $this->Session->setFlash('User cannot be deactivated. Please, try again', 'page_notification_error');
            }
        } else {
            $this->Session->setFlash('User cannot be found. Please, try again', 'page_notification_error');
        }
    }
    
    public function activate($id = null) {

        $this->view = 'index';

        if (($this->request->is('get') && $this->User->exists($id))) {
            $user = array();
            $user['User']['id'] = intval($id);        
            $user['User']['active'] = 1;        
            $user['User']['updatedat'] = $this->_createNowTimeStamp();
            if ($this->User->save($user, false)) {
                $this->Session->setFlash('User has been deactivated', 'page_notification_info');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            } else {
                $this->Session->setFlash('User cannot be deactivated. Please, try again', 'page_notification_error');
            }
        } else {
            $this->Session->setFlash('User cannot be found. Please, try again', 'page_notification_error');
        }
    }

    public function changepassword($id = null) {

        $this->_setTitleOfPage('Change Password');
        
        $this->User->id = $id;
        $user = $this->User->read();
        $this->set('fullname', ucwords($user['User']['firstname'] . ' ' . $user['User']['lastname']));
        
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read();
        } else {
            
            if (($this->request->is('post') || $this->request->is('put')) && $this->User->exists()) {
            
                $old_password = $this->request->data['User']['old_password'];
                $db_old_password = $this->User->findById($id);
                if(hash('sha512', $old_password) == $db_old_password) {
                    $password = $this->request->data['User']['password'];
                    $confirm_password = $this->request->data['User']['confirm_password'];
                    if($password == $confirm_password) {
                        $user['User']['id'] = $id;
                        $user['User']['password'] = $password;
                        $user['User']['updatedat'] = $this->_createNowTimeStamp();

                        if ($this->User->save($user, false, array('password', 'updatedat'))) {
                            $this->Session->setFlash('User\'s password reset successful!', 'page_notification_info');
                            $this->redirect(array('controller' => 'users', 'action' => 'index'));
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
        
        $this->set('fullname', ucwords($user['User']['firstname'] . ' ' . $user['User']['lastname']));

    }

    public function passwordreset($id = null) {

        $this->_setTitleOfPage('User Password Reset');
        $this->User->id = $id;
        $user = $this->User->read();
        $this->set('fullname', ucwords($user['User']['firstname'] . ' ' . $user['User']['lastname']));
        
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read();
        } else {
            
            if (($this->request->is('post') || $this->request->is('put')) && $this->User->exists()) {
            
                $password = $this->request->data['User']['password'];
                $confirm_password = $this->request->data['User']['confirm_password'];
                if($password == $confirm_password) {
                    $user['User']['id'] = $id;
                    $user['User']['password'] = $password;
                    $user['User']['updatedat'] = $this->_createNowTimeStamp();
                    
                    if ($this->User->save($user, false, array('password', 'updatedat'))) {
                        $this->Session->setFlash('User\'s password reset successful!', 'page_notification_info');
                        $this->redirect(array('controller' => 'users', 'action' => 'index'));
                    } else {
                        $this->Session->setFlash('Password reset not successful!. Please, try again', 'page_notification_error');
                    }
                } else {
                    $this->Session->setFlash('Password do not match!. Please, try again', 'page_notification_error');
                }
            }
        }
        
        $this->set('fullname', ucwords($user['User']['firstname'] . ' ' . $user['User']['lastname']));
    }

    private function _sendUserrole() {
        $user_roles = $this->Userrole->find('list');
        $this->set(array('user_roles' => $user_roles));
    }

    public function _setTitleOfPage($title) {
        $this->set(array(
            'title_of_page' => $title
        ));
    }

    public function _getAllUsers() {
        
        $users = $this->User->getAllUsers();
        $this->set('users', $users);
    }
    
    public function _setSidebarActiveItem($topMenu) {
        $this->set(array('active_item' => $topMenu));
    }


    //===================================== Helper methods
    public function loadusers() {

        //Use the al for column names returned after the database is queried in data_output function in SSPComponent
        $columns = array(
            array(
                'db' => 'users.firstname',
                'qry' => 'users.firstname as firstname',
                'al' => 'firstname',
                'dt' => '0'),
            array(
                'db' => 'users.username',
                'qry' => 'users.username as username',
                'al' => 'username',
                'dt' => '1'),
            array(
                'db' => 'userroles.userrolename',
                'qry' => 'userroles.userrolename as userrolename',
                'al' => 'userrolename',
                'dt' => '2'),
            array(
                'db' => 'users.active',
                'qry' => 'users.active as active',
                'al' => 'active',
                'dt' => '4'),
            array(
                'db' => 'users.id',
                'qry' => 'users.id as id',
                'al' => 'id',
                'dt' => '5'),
            array(
                'db' => 'users.userroleid',
                'qry' => 'users.userroleid as userroleid',
                'al' => 'userroleid',
                'dt' => 'role_id'),
            array(
                'db' => 'users.lastname',
                'qry' => 'users.lastname as lastname',
                'al' => 'lastname',
                'dt' => 'lastname')
        );

        $table_name = "users";
        $joins = " LEFT JOIN userroles ON userroles.id = users.userroleid ";

        $primaryKey = "users.id";

        // SQL server connection information
        $dbconfig = get_class_vars('DATABASE_CONFIG');

        $sql_details = array(
            'user' => $dbconfig['default']['login'],
            'pass' => $dbconfig['default']['password'],
            'db'   => $dbconfig['default']['database'],
            'host' => $dbconfig['default']['host'],
        );

        $response = $this->SSP->simple( $_POST , $sql_details, $table_name, $joins, $primaryKey, $columns );
        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);

    }
}