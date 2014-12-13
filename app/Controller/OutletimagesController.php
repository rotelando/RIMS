<?php

class OutletimagesController extends AppController {

//    http://papyrusapi.alexanderharing.com/files/images/52519F4C-70FC-425F-B4053753DC4E27E9.jpg

    var $name = 'outletimages';
    var $uses = array('Outletimage', 'Outlet', 'User', 'Location');
    var $helpers = array('Time');
    public $components = array('Paginator', 'Filter');
    
    public $urloptions = array();
    public $postoptions = array();
    
    public function index() {

        $options = $this->Filter->getPostDataFilterOptions($this->modelClass);
        $paginatedImages = $this->Outletimage->getPaginatedImages($this->Paginator, $options, 100);
        $last_image_taken = $this->Outletimage->recentImages(1, $options);

        $this->set(array('images' => $paginatedImages, 'last_image_taken' => array_values($last_image_taken)));
        $this->set(array('controller' => 'outletimages', 'action' => 'index'));
    }
    
    public function beforeFilter() {
        parent::beforeFilter();

        $this->_setViewVariables();
        $this->setCurrentUserSettings();
    }
    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('images');
        $this->_setTitleOfPage('Outlet Images');
    }
    
    public function generateimagedata() {

        $test_data = array();
        for ($i = 1; $i <= 50; $i++) {   //1532
            $test_data['Image']['id'] = $i;
            $test_data['Image']['filename'] = "outlet_" . $i . ".jpg";
            $test_data['Image']['visitid'] = rand(200, 900);
            $test_data['Image']['description'] = "outlet_" . $i . ".jpg";
            $test_data['Image']['thumbfilename'] = "thumb" . $test_data['Image']['filename'];
            $test_data['Image']['createdat'] = date('Y-m-d H:i:s', rand(1385856000, 1396310400));

            $response[] = $test_data;
        }

        $this->Image->SaveAll($response);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', json_encode($response));
    }
}
