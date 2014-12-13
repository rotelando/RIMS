<?php

class LgasController extends AppController {

    var $name = 'Lgas';
    var $uses = array('Lga', 'Territory');

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

            $this->request->data['Lga']['created_at'] = $this->_createNowTimeStamp();
            if ($this->Lga->save($this->request->data)) {
                $this->Session->setFlash("Local Government Area {$this->request->data['Lga']['lganame']} has been successfully created!", 'page_notification_info');
                $this->redirect(array('controller' => 'lgas', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding LGA. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }

        }
    }

    public function delete($id = null) {

        if (!$id) {

            $this->Session->setFlash('Invalid LGA selected', 'page_notification_error');
            $this->redirect(array('controller' => 'lgas', 'action' => 'index'));
        }

        $this->Lga->id = $id;
        $lagname = $this->Lga->lagname;

        if ($this->Lga->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash("LGA {$lagname} has been deleted", 'page_notification_info');
            $this->redirect(array('controller' => 'lgas', 'action' => 'index'));
        } else {
            $this->Session->setFlash("Unable to delete LGA {$lagname}. Please, try again", 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Lga->id = $id;

        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Lga->read();
            $this->set('data', $this->request->data);
            $this->_setViewVariables();
        }

        $this->add($id);
    }



    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('lgas');
        $this->_setTitleOfPage('Lga');

        $lgas = $this->Lga->getLgas();
        $territorylist = $this->Territory->getTerritoryAsList();

        $this->set(array(
            'lgas' => $lgas,
            'territorylist' => $territorylist
        ));
    }

    public function territory($id) {

        $result = $this->Lga->lgasByTerritories($id);
        $response = json_encode($result);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);

    }

}
