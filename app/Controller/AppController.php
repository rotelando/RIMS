
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

    var $uses = array('Setting', 'Outlet', 'User', 'Rolemodule', 'Country', 'State', 'Region', 'Subregion', 'Territory', 'Lga', 'Location', 'Retailtype');
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
        
        $outletcount = $this->Outlet->countOutlet();
        $this->set('outlet_count', $outletcount);

        $usercount = $this->User->countUser();
        $this->set('user_count', $usercount);
        
        $fieldreplist = $this->User->fieldRepLists();
        $this->set(array('fieldreplist' => $fieldreplist));

        $retailtypelist = $this->Retailtype->getRetailtypeAsList();
        $this->set(array('retailtypelist' => $retailtypelist));
        
        $this->_locationLists();
        
        $this->_datePickerList();

        $this->_phonePrefixList();

        $this->setDomainName();

        //This holds and reset the param values to be used in making ajax calls for filters
        if(isset($this->request->data['Outlet']['getparam'])) {
            $this->set(array('getparam' => $this->request->data['Outlet']['getparam']));
        }
        
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

    public function _locationLists($setValue = true) {
        
        //Nationals

        $nationals = $this->Country->find('list');
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

        $subregions = $this->Subregion->find('list');
        if(isset($subregions)) {
            foreach ($regions as $key => $value) {
                $key = 'sub_' . $key;
                $new_subregions[$key] = $value;
            }
            $outputlocation['Subregions'] = $new_subregions;
        }

        $state = $this->State->find('list');
        if(isset($state)) {
            foreach ($state as $key => $value) {
                $key = 'sta_' . $key;
                $new_state[$key] = $value; 
            }
            $outputlocation['States'] = $new_state;
        }

        $new_territory = array();
        $territory = $this->Territory->find('list');
        if(isset($territory)) {
            foreach ($territory as $key => $value) {
                $key = 'ter_' . $key;
                $new_territory[$key] = $value;
            }
            $outputlocation['Territories'] = $new_territory;
        }

        $new_lga = array();
        $lga = $this->Location->find('list');
        if(isset($lga)) {
            foreach ($lga as $key => $value) {
                $key = 'lga_' . $key;
                $new_lga[$key] = $value;
            }
            $outputlocation['Lgas'] = $new_lga;
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
        }
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

    public function _phonePrefixList() {

        $list = array();

        //MTN Number Series and Prefixes
        $list['MTN']['0803'] = '0803';
        $list['MTN']['0806'] = '0806';
        $list['MTN']['0703'] = '0703';
        $list['MTN']['0706'] = '0706';
        $list['MTN']['0813'] = '0813';
        $list['MTN']['0816'] = '0816';
        $list['MTN']['0810'] = '0810';
        $list['MTN']['0814'] = '0814';
        $list['MTN']['0903'] = '0903';

        //GLO Number Series and Prefixes
        $list['GLO']['0705'] = '0705';
        $list['GLO']['0815'] = '0815';
        $list['GLO']['0805'] = '0805';
        $list['GLO']['0807'] = '0807';
        $list['GLO']['0811'] = '0811';

        //Airtel Number Series and Prefixes
        $list['Airtel']['0708'] = '0708';
        $list['Airtel']['0802'] = '0802';
        $list['Airtel']['0808'] = '0808';
        $list['Airtel']['0812'] = '0812';
        $list['Airtel']['0701'] = '0701';

        //Etisalat Number Series and Prefixes
        $list['Etisalat']['0809'] = '0809';
        $list['Etisalat']['0817'] = '0817';
        $list['Etisalat']['0818'] = '0818';
        $list['Etisalat']['0909'] = '0909';

        $this->set('phoneprefixlist', $list);
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
