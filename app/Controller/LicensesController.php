<?php

class LicensesController extends AppController {

    var $name = 'Licenses';
    var $uses = array('License', 'User', 'Setting');

    public function beforeFilter() {
        parent::beforeFilter();
       
        $this->_setViewVariables();
        $this->_setLicenseTable();
        $this->_getAndSetCompanyId();
    }
    
    public function index() {
        
    }
    
    private function _getAndSetCompanyId() {
        $settings = $this->Setting->find('first', array('conditions' => array('key' => 'companyid')));
        if(isset($settings['Setting']['key'])) {
            $companyid = $settings['Setting']['value'];
            $this->request->data['License']['companyid'] = $companyid;
            $this->set($this->request->data);
        } else {
            $this->Session->setFlash('It seems you haven\'t setup your company ID. <a class="btn btn-small btn-primary" href="setup/general">Setup</a>', 'page_notification_warning');
        }
    }

    public function add() {
        
        $this->render('index');
        
        
        if ($this->request->is('Post') || $this->request->is('Put')) {
            
            $settings = $this->Setting->find('first', array('conditions' => array('key' => 'companyid')));
            
            if(isset($settings)) {
                
                //Get the Company ID from settings
                $companyid = $this->request->data['License']['companyid'];
                $licensekeys = $this->request->data['License']['licensekey'];
                
                if(strpos($licensekeys, ",") != -1) {
                   $temkeys = str_replace(" ", "", $licensekeys);
                   $arrlicensekeys = explode(',', $temkeys);
                   $key = $this->License->find('count', array('conditions' => array('License.licensekey' => $arrlicensekeys)));
                } else {
                   $key = $this->License->find('count', array('conditions' => array('License.licensekey' => $licensekeys)));
                }
                
                //is the keys an array
                if(isset($arrlicensekeys)) {
                    //implode with comma
                    $keys = implode(",", $arrlicensekeys);
                } else {
                    $keys = $licensekeys;
                }
                    
                if($key != 0) {
                    
                    $this->Session->setFlash("One or more of the License key(s) \"{$keys}\" has already been used.", 'page_notification_error');
                  
                } else {
                
                    $url = "http://api.licensing.fieldmaxpro.com/keys/validate/{$companyid}?keys={$keys}";

                    $license = file_get_contents($url);
                    debug($license);
                    $arrLicense = json_decode($license);
                    $allLicenses = array();
                    $isKeysValid = false;
                    
                    if($arrLicense->meta->status == 1) {
                        
                        $keyvalues = $arrLicense->data->keys;
                        
                        foreach ($keyvalues as $key) {
    
                            $arrlicensedetails = $key;
                            
                            if(strtolower($arrlicensedetails->status) == "invalid") {
                                
                                $invalidKey = $arrlicensedetails->key;
                                $isKeysValid = false;
                                break;
                            }
                            
                            $newLicense['License']['licensepack'] = $arrlicensedetails->licensepack;
                            $newLicense['License']['licensekey'] = $arrlicensedetails->key;
                            $newLicense['License']['numberofusers'] = $arrlicensedetails->userallowance;
                            $newLicense['License']['status'] = (lcfirst($arrlicensedetails->status) == 'active') ? 1 : 0;
                            $newLicense['License']['createdat'] = $this->_createNowTimeStamp();
                            $allLicenses[] = $newLicense;
                            $isKeysValid = true;
                        }
                        
                        //is all the keys valid?
                        if($isKeysValid) {
                            //save all keys in the database
                            if($this->License->saveAll($allLicenses, false)) {
                                $this->Session->setFlash('License(s) is/are valid and has been applied', 'page_notification_info');
                            } else {
                                $this->Session->setFlash('problem applying license. Please, try again', 'page_notification_error');
                            }
                        } else {
                            $this->Session->setFlash("Invalid license key(s) \"{$invalidKey}\". Please contact the license provider.", 'page_notification_error');
                            debug($url);
                        }
                    } else {
                        $this->Session->setFlash('There is a problem applying the licence. Please contact the license provider.', 'page_notification_error');
                    }
                }
            } else {
                $this->Session->setFlash('Please set you company id and try again!', 'page_notification_error');
            }
            
            $this->_setViewVariables();
            $this->redirect(array('controller' => 'licenses', 'action' => 'index'));
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid license selected', 'page_notification_error');
            $this->redirect(array('controller' => 'licenses', 'action' => 'index'));
        }

        $this->License->id = $id;

        if ($this->License->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('License has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'licenses', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete license. Please, try again', 'page_notification_error');
        }
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('users');
        $this->_setSidebarActiveSubItem('licenses');
        $this->_setTitleOfPage('User Licences');
    }
    
    private function _setLicenseTable() {
        $licenses = $this->License->find('all');
        $this->set('licenses', $licenses);
    }

    private function trim_values(&$arr) 
    { 
        for($i = 0; $i < count($arr); $i++) {
            $arr[$i] = trim($arr[$i]);
        }
    }
}
