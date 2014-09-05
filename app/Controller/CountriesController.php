<?php

class CountriesController extends AppController {
    
    var $name = 'Countries';
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();
    }
    
    public function index() {
        
    }
    
    private function _getAllCountries(){
        $countrylist = $this->Country->find('list'); 
        $this->set(array('countrylist'=>$countrylist));
    }
   
   
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setTitleOfPage('Setup');
        
        $this->_getAllCountries();
    }
}
