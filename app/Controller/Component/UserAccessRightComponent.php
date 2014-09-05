<?php

App::uses('Component', 'Controller');

class UserAccessRightComponent extends Component {

    public $components = array('Session');
    public $rolemodule = null;
    private $controller = null;
    
    public function initialize(Controller $controller) {
        $this->controller =& $controller; 
    }

    public function isAllowedSetupModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'SETUP') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isAllowedUserModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $value) {
            if (isset($value['Adminmodule']['adminmodulename']) && $value['Adminmodule']['adminmodulename'] == 'USERS') {
                if ($value['Rolemodule'][$access] == 1) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedCalendarModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'CALENDAR') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedOutletModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'OUTLETS') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedVisitModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'VISITS') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedMerchandisingModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'MERCHANDISING') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedSalesModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'SALES') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedProdAvailModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'PRODUCT_AVAILABILITY') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedBriefsModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'BRIEFS') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedFieldStaffsModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'FIELDSTAFFS') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedImagesModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'IMAGES') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedMapsModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'MAPS') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedReportsModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'REPORTS') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isAllowedSettingsModule($userid, $access) {

        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if (isset($rolemodule['Adminmodule']['adminmodulename']) && $rolemodule['Adminmodule']['adminmodule'] == 'SETTINGS') {
                if ($rolemodule['Rolemodule'][$access]) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function _getUserAccessRights($id) {

        $this->Rolemodule = ClassRegistry::init('Rolemodule');
        $this->Adminmodule = ClassRegistry::init('Adminmodule');

        $options['fields'] = array(
            'Adminmodule.adminmodulename',
            'Rolemodule.add',
            'Rolemodule.view',
            'Rolemodule.delete',
            'Rolemodule.print',
        );
        $options['conditions'] = array('Rolemodule.userroleid' => $id);
        $accessright = $this->Rolemodule->find('all', $options);
        return $accessright;
    }

    public function checkAuthorization($function_name, $userid, $access) {
        
//        if(method_exists($this, $function_name)) {
//            print_r('function exist');
//            $allowed = call_user_func(array($this, $function_name), $userid, $access);
//            $this->Session->setFlash($allowed, 'page_notification_error');
//            if (!$allowed) {
//                debug('disallowed');
//                $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//                $this->controller->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//            } else {
//                debug('allowed');
//                $this->Session->setFlash('You are authorized to view that page!', 'page_notification_info');
//            }
//        }
    }

}
