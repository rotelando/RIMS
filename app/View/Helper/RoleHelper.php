<?php


class RoleHelper extends AppHelper {
    
//    var $uses = array('Adminmodule', 'Userrole', 'User', 'Rolemodule');
    
    public $rolemodule = null;
    
    public function isAllowedSetupModule($userid, $access) {
        
        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if(isset($rolemodule['Rolemodule'][$access]) && isset($rolemodule['Rolemodule'][$access])) {
                return true;
            }
        }
        
        return false;
    }
    
    public function isAllowedUserModule($userid, $access) {
        
        $accessrights = $this->_getUserAccessRights($userid);
        foreach ($accessrights as $rolemodule => $access) {
            if(isset($rolemodule['Rolemodule'][$access]) && isset($rolemodule['Rolemodule'][$access])) {
                return true;
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
}
