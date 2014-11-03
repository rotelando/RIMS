<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/23/14
 * Time: 5:39 AM
 */

class RetailtypesController extends AppController {

    var $name = 'Retailtypes';
    var $uses = array('Retailtype', 'Outletclass', 'Outletchannel');

    public function beforeFilter() {
        parent::beforeFilter();

        $this->_setViewVariables();
    }

    public function index() {

    }

    public function add($id = null) {

        $this->render('index');

//        debug($this->request->data);
        if ($this->request->is('Post') || $this->request->is('Put')) {

            $this->request->data['Retailtype']['created_at'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Retailtype->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Retailtype']['retailtypename'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'retailtypes', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding Retail type. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }

    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid Retail type selected', 'page_notification_error');
            $this->redirect(array('controller' => 'retailtypes', 'action' => 'index'));
        }

        $this->Outletclass->id = $id;

        if ($this->Retailtype->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Retail type has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'retailtypes', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete type. Please, try again', 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Outletclass->id = $id;

        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Outletclass->read();
            $this->set('data', $this->request->data);
            $this->_setViewVariables();
        }

        $this->add($id);

    }

    private function _fetchAndSetAllRetailtypes() {
        $retailtypes = $this->Retailtype->find('all');
        $this->set(array('retailtypes' => $retailtypes));
    }

    private function _fetchAllOutletChannels() {
        $outletchannels = $this->Outletchannel->find('all');
        $this->set(array('outletchannels'=>$outletchannels));
    }

    private function _fetchAllOutletclasses() {
        $outletclasses = $this->Outletclass->find('all');
        $this->set(array('outletclasses'=>$outletclasses));
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('types');
        $this->_setTitleOfPage('Retail Type');

        $this->_fetchAndSetAllRetailtypes();
        $this->_fetchAllOutletChannels();
        $this->_fetchAllOutletclasses();
    }

    public function exists($name = null) {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';

        $result = $this->Retailtype->find('all', array('conditions'=>array('retailtypename'=>$name)));

        if(!empty($result))  {
            $response = '{ "meta" : { "status" : true, "message" : "'. $name . ' already exist" } }';
        } else
            $response = '{ "meta" : { "status" : false, "message" : "'. $name . ' is available" } }';

        $this->set('response' , $response);
    }
} 