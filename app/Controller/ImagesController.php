<?php

class ImagesController extends AppController {

//    http://papyrusapi.alexanderharing.com/files/images/52519F4C-70FC-425F-B4053753DC4E27E9.jpg
    
    var $name = 'Images';
    var $uses = array('Image', 'Visit', 'Outlet', 'User', 'Location');
    var $helpers = array('Time');
    public $components = array('Paginator', 'Filter');
    
    public $urloptions = array();
    public $postoptions = array();
    
    public function index() {
        
        $recentImages = $this->_getResentImages(100);
//        debug($recentImages);
        $this->set('images', $recentImages);
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedImagesModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
     
        //get current user settings :)
        $this->setCurrentUserSettings();
        
        $this->urloptions = $this->Filter->getUrlFilterOptions($this->modelClass);
        $this->postoptions = $this->Filter->getPostDataFilterOptions($this->modelClass);
    }
    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('images');
        $this->_setTitleOfPage('Images');
    }
    
    private function _getResentImages($number) {
        
        $options = $this->Filter->getPostDataFilterOptions($this->modelClass);
        
        $options['fields'] = array(
            'Image.id',
            'Image.description',
            'Image.filename',
            "DATE_FORMAT(Image.createdat,'%Y-%m-%d') as dateline",
            'Image.createdat',
            'Outlet.id',
            'CONCAT(User.firstname," ",User.lastname) as fullname',
            'Outlet.outletname',
            'Location.locationname'
        );
        $options['order'] = array('Image.createdat' => 'desc');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Image.visitid'
                )
            ),
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
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            )
        );

        $this->Paginator->settings = $options;
        $images = $this->Paginator->Paginate('Image');
//        debug($images);
        return $images;
    }
    
     public function generateimagedata() {

        //Generate Actual Visits - for Visit Model
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
