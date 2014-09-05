<?php

class UserrolesController extends AppController {
    
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->set(array(
            'title_of_page_header' => 'Users',
            'pri_nav_active' => 'users'
        ));
    }
    
    public function index() {
        
      
    }
}
