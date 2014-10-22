
<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    var $uses = array('Setting', 'Outlet', 'Location', 'User', 'Rolemodule', 'Country', 'State', 'Region');
    var $helper = array('RoleAccess');
    var $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Filter',
        'UserAccessRight',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'dashboard', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'logout'),
            'loginAction' => array('controller' => 'login'),
            'authError' => "You can't access that page",
            'authorize' => array('Controller')
        )
    );

    public function isAuthorized($user) {
        return true;    //what login users has access to
    }

    public function beforeFilter() {

        parent::beforeFilter();
        Security::setHash('sha512');
        
        $this->Auth->allow('download'); //what non-logged in user has access to
        $this->set('logged_in', $this->Auth->loggedIn());
        $current_user = $this->Auth->user();

        $this->set('current_user', $current_user);
        
        $outletcount = $this->_getOutletCount();
        $this->set('outlet_count', $outletcount);
        
        $visitcount = $this->_getVisitCount();
        $this->set('visit_count', $visitcount);
        
        $this->_fieldrepLists();
        
        $this->_locationLists();
        
        $this->_datePickerList();

        $this->setDomainName();
        
    }

    protected function _getUserAccessRights($id) {
        
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
    
    protected function _getCurrentUser() {
        return $this->Auth->user();
    }

    protected function _getCurrentUserId() {
        return $this->Auth->user('id');
    }

    protected function _createNowTimeStamp() {
        return date('Y-m-d H:i:s');
    }

    public function _setTitleOfPage($title) {
        $this->set(array(
            'title_of_page' => $title
        ));
    }

    public function _getOutletCount($options = null) {
        
        /*$options = $this->Filter->getPostDataFilterOptions('Outlet');
        // debug($options);
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );

        $outletcount = $this->Outlet->find('count', $options);
        return $outletcount;*/
    }

    public function _getVisitCount($options = null) {

        /*$options = $this->Filter->getPostDataFilterOptions('Outlet');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
        );
        
        $visitcount = $this->Visit->find('count', $options);
        return $visitcount;*/
    }

    public function _setSidebarActiveItem($topMenu) {
        $this->set(array('active_item' => $topMenu));
    }

    public function _setSidebarActiveSubItem($topSubMenu) {
        $this->set(array('active_sub_item' => $topSubMenu));
    }

    function pa($arr) {
        echo '<pre>';
        print_r($arr);
        echo '< /pre>';
    }

    public function setCurrentUserSettings() {

        /*$uid = 'USER_' . $this->Auth->user('id');
        $settings = $this->Setting->findByKey($uid);
        
        if (isset($settings['Setting']['value'])) {
            $newsettings = json_decode($settings['Setting']['value'], true);
            $newsettings['Setting']['key'] = $settings['Setting']['key'];
            $newsettings['Setting']['id'] = $settings['Setting']['id'];
            $newsettings['Setting']['createdat'] = $settings['Setting']['createdat'];
            if(!isset($newsettings['Setting']['VisitException'])) {
                $newsettings['Setting']['VisitException'] = 200;
            }
            $this->set('setting', $newsettings);
        } else {
            //Use default settings
            $newsettings['Setting']['id'] = $this->Auth->user('id');
            $newsettings['Setting']['key'] = $uid;
//            $newsettings['Setting']['createdat'] = $settings['Setting']['createdat'];
            $newsettings['Setting']['fieldrepid'] = 3;
            $newsettings['Setting']['VisitException'] = 200;
            $newsettings['Setting']['TargetVisit'] = 5000;
            $newsettings['Setting']['TargetOrder'] = 50000000;
            $this->set('setting', $newsettings);
        }
        
        return $newsettings;*/
    }

    public function setDomainName() {
        $this->set('access_control_domain', 'http://fieldmaxadmin.alexanderharing.com/');
    }

    public function _outletList($setValue = true) {
        /*$options['conditions'] = array('Locationgroup.id' => $this->_getCurrentUserLocationGroupId());
        $options['recursive'] = -1;
        $locationids = $this->Locationgroup->find('first', $options);
        
        if(!isset($locationids['Locationgroup']['locationids']) || is_null($locationids['Locationgroup']['locationids'])) {
            $outletlist = $this->Outlet->find('list');
            
        } else {
            
            $arr_loc_ids = explode(',',$locationids['Locationgroup']['locationids']);
            $options['conditions'] = array('Outlet.location_id' => $arr_loc_ids);
            $options['recursive'] = -1;
            $outletlist = $this->Outlet->find('list', $options);
        }
        
        if($setValue) {
            $this->set('outlets', $outletlist);
        } else {
            return $outletlist;
        }*/
        
    }
    
    public function _fieldrepLists($setValue = true, $count = false) {
        /*$currentUserSettings = $this->setCurrentUserSettings();
        if (!isset($currentUserSettings['Setting']['fieldrepid'])) {
            $fieldrepid = 3;
        } else {
            $fieldrepid = $currentUserSettings['Setting']['fieldrepid'];
        }
        
        $options = array();
        //check if locationgroupid is null. If null, load all fieldreps
        if(!is_null($this->_getCurrentUserLocationGroupId())) {
            $options['conditions']['User.locationgroupid'] = $this->_getCurrentUserLocationGroupId();
        }
        
        $options['conditions']['User.userroleid'] = $fieldrepid;
        
        if($setValue) {
            if($count) {
                $fieldreps = $this->User->find('count', $options);
            } else {
                $fieldreps = $this->User->find('list', $options);
            }
            $this->set(array('fieldreplist' => $fieldreps));
        } else {
            if($count) {
                $fieldreps = $this->User->find('count', $options);
            } else {
                $fieldreps = $this->User->find('list', $options);
            }
            return $fieldreps;
        }*/
    }

    public function _locationLists($setValue = true) {
        
        //Nationals

        /*$nationals = $this->Country->find('list');
        if(isset($nationals)) {
            foreach ($nationals as $key => $value) {
                $key = 'nat_' . $key;
                $new_nationals[$key] = $value; 
            }
            $outputlocation['Nationals'] = $new_nationals;
        }

        $regions = $this->Region->find('list');
        if(isset($regions)) {
            foreach ($regions as $key => $value) {
                $key = 'reg_' . $key;
                $new_regions[$key] = $value; 
            }
            $outputlocation['Regions'] = $new_regions;
        }

        $state = $this->State->find('list');
        if(isset($state)) {
            foreach ($state as $key => $value) {
                $key = 'sta_' . $key;
                $new_state[$key] = $value; 
            }
            $outputlocation['States'] = $new_state;
        }

        $new_location = array();
        $location = $this->Location->find('list');
        if(isset($location)) {
            foreach ($location as $key => $value) {
                $key = 'loc_' . $key;
                $new_location[$key] = $value; 
            }
            $outputlocation['Locations'] = $new_location;
        }

        //debug($outputlocation);

        if($setValue) {
            $this->set(array('locations' => $outputlocation));
        } else {
            return $outputlocation;
        }*/
    }

    public function _datePickerList() {
        $dateOptionList = array(
            '' => '&nbsp;',
            'yes' => 'Yesterday',
            'lw' => 'Last week',
            'l2w' => 'Last 2 weeks',
            'lm' => 'Last Month',
            'l2m' => 'Last 2 Months',
            'l3m' => 'Last 3 Months',
            'l6m' => 'Last 6 Months',
            'cust' => 'Custom Range'
        );
        $this->set('datelist', $dateOptionList);
    }

    public function _getFilterDisplayText($option) {

        /*$filtertext = '';
        if(isset($option['Location'])) {
            $filtertext .= "Location: <strong>{$option['Location']}</strong>";
        }
        if(isset($option['User'])) {
            if($filtertext != '') { $filtertext .= ', '; } 
            $filtertext .= "Fieldstaff: <strong>{$option['User']['username']}</strong>";
        }
        if(isset($option['date'])) {
            if($filtertext != '') { $filtertext .= ', '; } 
            $filtertext .= "Date: <strong>{$option['date']}</strong>";
        }
        $this->set('filtertext', $filtertext);
    }
    
    public function _setBreadCrumb($breadcrumb) {
        
        $this->set(array('breadcrumb' => $breadcrumb));*/
    }
    
}
