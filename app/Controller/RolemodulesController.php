<?php

class RolemodulesController extends AppController {

    var $name = 'Rolemodules';
    var $uses = array('Rolemodule', 'Adminmodule', 'Userrole', 'User');
    public $components = array('Acl');

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedUserModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
    }

    public function index() {

        $userroles = $this->_getUserroles();
        $this->set(array('userroles' => $userroles));
        
        $aro = $this->Acl->Aro;

        // Here's all of our group info in an array we can iterate through
        $groups = array(
            0 => array(
                'alias' => 'warriors'
            ),
            1 => array(
                'alias' => 'wizards'
            ),
            2 => array(
                'alias' => 'hobbits'
            ),
            3 => array(
                'alias' => 'visitors'
            ),
        );

        // Iterate and create ARO groups
        foreach ($groups as $data) {
            // Remember to call create() when saving in loops...
            $aro->create();

            // Save data
            $aro->save($data);
        }

        // Other action logic goes here...
    }

    public function add() {
        $rolemodules = $this->_getRolemodules();
        $this->set(array('rolemodules' => $rolemodules));
        
        $rights = array('add', 'view', 'delete', 'print');
        
        if ($this->request->is('Post') || $this->request->is('Put')) {
            
            //Insert into Userrole table and get the last inserted id
            $userroledata['Userrole']['userrolename'] = $this->request->data['Rolemodule']['userrolename'];
            $userroledata['Userrole']['description'] = $this->request->data['Rolemodule']['description'];
            $userroledata['Userrole']['createdat'] = $this->_createNowTimeStamp();
            
            if ($this->Userrole->save($userroledata)) {
                foreach ($rolemodules as $rolemodule) {
                    $dataitem['Rolemodule']['userroleid'] = $this->Userrole->getLastInsertID();
                    $dataitem['Rolemodule']['adminmoduleid'] = $rolemodule['Adminmodule']['id'];
                    foreach ($rights as $right) {
                        $name = $right . '_' . $rolemodule['Adminmodule']['adminmodulename'];
                        $dataitem['Rolemodule'][$right] = $this->request->data['Rolemodule'][$name];
                    }
                    $dataitem['Rolemodule']['createdat'] = $this->_createNowTimeStamp();
                    $rolemoduledata[] = $dataitem;
                }
                
                if ($this->Rolemodule->saveMany($rolemoduledata)) {
                    $this->Session->setFlash($this->request->data['Rolemodule']['userrolename'] . ' has been saved', 'page_notification_info');
                } else {
                    $this->Session->setFlash($this->request->data['Rolemodule']['userrolename'] . ' cannot be saved. Please, try again', 'page_notification_error');
                }
            }
            
            $this->redirect(array('controller' => 'rolemodules', 'action' => 'index'));
        }
    }

    public function edit($id = null) {
        
        $rolemodules = $this->_getRolemodules($id);
        $userrole = $this->_getUserrole($id);
        $this->set(array('rolemodules' => $rolemodules, 'userrole' => isset($userrole[0]) ? $userrole[0] : []));
        
        if (empty($this->request->data)) {
            $this->request->data = $rolemodules;
            $allrolemodules = $this->_getRolemodules();
//            debug($allrolemodules);
//            debug($rolemodules);
        }
        
        if ($this->request->is('Post') || $this->request->is('Put')) {
            
            $rights = array('add', 'view', 'delete', 'print');
            //Insert into Userrole table and get the last inserted id
            $userroleid = $this->request->data['Rolemodule']['id'];
            $userroledata['Userrole']['id'] = $userroleid;
            $userroledata['Userrole']['userrolename'] = $this->request->data['Rolemodule']['userrolename'];
            $userroledata['Userrole']['description'] = $this->request->data['Rolemodule']['description'];
            $userroledata['Userrole']['createdat'] = $this->_createNowTimeStamp();
            
            if ($this->Userrole->save($userroledata)) {
                
                //Delete all existing access right for the userrole
                $this->Rolemodule->deleteAll(array('userroleid' => $userroleid));
                
                foreach ($rolemodules as $rolemodule) {
                    $dataitem['Rolemodule']['userroleid'] = $userroleid;
                    $dataitem['Rolemodule']['adminmoduleid'] = $rolemodule['Adminmodule']['id'];
                    foreach ($rights as $right) {
                        $name = $right . '_' . $rolemodule['Adminmodule']['adminmodulename'];
                        $dataitem['Rolemodule'][$right] = $this->request->data['Rolemodule'][$name];
                    }
                    $dataitem['Rolemodule']['createdat'] = $this->_createNowTimeStamp();
                    $rolemoduledata[] = $dataitem;
                }
                
                if ($this->Rolemodule->saveMany($rolemoduledata)) {
                    $this->Session->setFlash($this->request->data['Rolemodule']['userrolename'] . ' has been saved', 'page_notification_info');
                } else {
                    $this->Session->setFlash($this->request->data['Rolemodule']['userrolename'] . ' cannot be saved. Please, try again', 'page_notification_error');
                }
            }
            
            $this->redirect(array('controller' => 'rolemodules', 'action' => 'index'));
        }
    }
    
    public function view($id) {
        $rolemodules = $this->_getRolemodules($id);
        $userrole = $this->_getUserrole($id);
        $this->set(array('rolemodules' => $rolemodules, 'userrole' => isset($userrole[0]) ? $userrole[0] : []));
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('users');
        $this->_setTitleOfPage('Role Modules');
    }

    private function _getUserrole($id) {
        $options['fields'] = array(
            'Userrole.id',
            'Userrole.userrolename',
            'Userrole.description'
        );
         $options['recursive'] = -1;
         $options['conditions'] = array('Userrole.id' => $id);
         
         $userrole = $this->Userrole->find('all', $options);
         return $userrole;
    }
    
    private function _getUserroles() {

        $options['fields'] = array(
            'Userrole.id',
            'Userrole.userrolename',
            'COUNT(User.userroleid) as userrolecount'
        );
        $options['group'] = array(1);   //Force it to display zero
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.userroleid = Userrole.id'
                )
            )
        );

        $userroles = $this->Userrole->find('all', $options);
        return $userroles;
    }

    private function _getRolemodules($id = null) {
        if($id != null) {
            $options['fields'] = array(
                'Userrole.id',
                'Userrole.userrolename',
                'Adminmodule.id',
                'Adminmodule.adminmodulename',
                'Rolemodule.id',
                'Rolemodule.add',
                'Rolemodule.delete',
                'Rolemodule.view',
                'Rolemodule.print'
            );
            $options['conditions'] = array('Rolemodule.userroleid' => $id);
            $options['recursive'] = -1;
            $options['joins'] = array(
                array(
                    'table' => 'userroles',
                    'alias' => 'Userrole',
                    'type' => 'inner',
                    'conditions' => array(
                        'Rolemodule.userroleid = Userrole.id'
                    )
                ),
                array(
                    'table' => 'adminmodules',
                    'alias' => 'Adminmodule',
                    'type' => 'inner',
                    'conditions' => array(
                        'Rolemodule.adminmoduleid = Adminmodule.id'
                    )
                )
            );

            $rolemodules = $this->Rolemodule->find('all', $options);
            
        } else {
            $rolemodules = $this->Adminmodule->find('all');
        }

        return $rolemodules;
    }
    
    public function buildaro() {
        
        $aro = new Aro();

        // Here are our user records, ready to be linked to new ARO records.
        // This data could come from a model and be modified, but we're using static
        // arrays here for demonstration purposes.

        $users = array(
            0 => array(
                'alias' => 'Aragorn',
                'parent_id' => 1,
                'model' => 'User',
                'foreign_key' => 2356,
            ),
            1 => array(
                'alias' => 'Legolas',
                'parent_id' => 1,
                'model' => 'User',
                'foreign_key' => 6342,
            ),
            2 => array(
                'alias' => 'Gimli',
                'parent_id' => 1,
                'model' => 'User',
                'foreign_key' => 1564,
            ),
            3 => array(
                'alias' => 'Gandalf',
                'parent_id' => 2,
                'model' => 'User',
                'foreign_key' => 7419,
            ),
            4 => array(
                'alias' => 'Frodo',
                'parent_id' => 3,
                'model' => 'User',
                'foreign_key' => 7451,
            ),
            5 => array(
                'alias' => 'Bilbo',
                'parent_id' => 3,
                'model' => 'User',
                'foreign_key' => 5126,
            ),
            6 => array(
                'alias' => 'Merry',
                'parent_id' => 3,
                'model' => 'User',
                'foreign_key' => 5144,
            ),
            7 => array(
                'alias' => 'Pippin',
                'parent_id' => 3,
                'model' => 'User',
                'foreign_key' => 1211,
            ),
            8 => array(
                'alias' => 'Gollum',
                'parent_id' => 4,
                'model' => 'User',
                'foreign_key' => 1337,
            ),
        );

        // Iterate and create AROs (as children)
        foreach ($users as $data) {
            // Remember to call create() when saving in loops...
            $aro->create();

            //Save data
            $aro->save($data);
        }

        $this->redirect(array('controller' => 'rolemodules'));
        // Other action logic goes here...
    }
}
