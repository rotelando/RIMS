<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/23/14
 * Time: 6:20 AM
 */

class MerchandizeController extends AppController {

    var $name = 'Merchandize';
    var $uses = array('Merchandize');

    public function beforeFilter() {
        parent::beforeFilter();

//        $allowed = $this->UserAccessRight->isAllowedUserModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }

        $this->_setViewVariables();
        $this->_getAllMerchandize();
    }

    public function index() {

    }

    public function add($id = null) {

        $this->render('index');

//        debug($this->request->data);
        if ($this->request->is('Post') || $this->request->is('Put')) {

            $this->request->data['Merchandize']['created_at'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Merchandize->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Merchandize']['merchandizename'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'merchandize', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding brand element. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }

    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid merchandize selected', 'page_notification_error');
            $this->redirect(array('controller' => 'merchandize', 'action' => 'index'));
        }

        $this->Merchandize->id = $id;

        if ($this->Merchandize->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Brand Element has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'merchandize', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete Brand Element. Please, try again', 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Merchandize->id = $id;

        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Merchandize->read();
            $this->set('data', $this->request->data);
            $this->_getAllMerchandize();
            $this->_setViewVariables();
        }

        $this->add($id);

    }

    private function _getAllMerchandize(){
        $merchandize = $this->Merchandize->find('all');
        $this->set(array('merchandize'=>$merchandize));
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('merchandize');
        $this->_setTitleOfPage('Merchandize Items');
    }

}
 