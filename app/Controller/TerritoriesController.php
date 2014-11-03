<?php

class TerritoriesController extends AppController {

    var $name = 'Territories';
    var $uses = array('Territory', 'Territory');

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

            $this->request->data['Territory']['created_at'] = $this->_createNowTimeStamp();
            if ($this->Territory->save($this->request->data)) {
                $this->Session->setFlash("Territory {$this->request->data['Territory']['territoryname']} has been successfully created!", 'page_notification_info');
                $this->redirect(array('controller' => 'territories', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding LGTerritoryA. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }

        }
    }

    public function delete($id = null) {

        if (!$id) {

            $this->Session->setFlash('Invalid Territory selected', 'page_notification_error');
            $this->redirect(array('controller' => 'territories', 'action' => 'index'));
        }

        $this->Territory->id = $id;
        $territoryname = $this->Territory->lagname;

        if ($this->Territory->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash("LGA {$territoryname} has been deleted", 'page_notification_info');
            $this->redirect(array('controller' => 'territories', 'action' => 'index'));
        } else {
            $this->Session->setFlash("Unable to delete Territory {$territoryname}. Please, try again", 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Territory->id = $id;

        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Territory->read();
            $this->set('data', $this->request->data);
            $this->_setViewVariables();
        }

        $this->add($id);
    }



    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('territories');
        $this->_setTitleOfPage('Territory');

        $territories = $this->Territory->getTerritories();
        $statelist = $this->State->getStateAsList();

        $this->set(array(
            'territories' => $territories,
            'statelist' => $statelist
        ));
    }

}
