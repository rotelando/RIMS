<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/27/14
 * Time: 10:58 PM
 */

class SubregionsController extends AppController {

    var $name = 'Subregions';
    var $uses = array('Subregion', 'Country');

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

            $this->request->data['Subregion']['created_at'] = $this->_createNowTimeStamp();
            if ($this->Subregion->save($this->request->data)) {
                $this->Session->setFlash("Subregion {$this->request->data['Subregion']['subregionname']} has been successfully created!", 'page_notification_info');
                $this->redirect(array('controller' => 'subregions', 'action' => 'index'));
            } else {
                $this->Session->setFlash('There seem to be a problem creating the subregion. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }

    public function delete($id = null) {

        if (!$id) {

            $this->Session->setFlash('Invalid subregion selected', 'page_notification_error');
            $this->redirect(array('controller' => 'subregions', 'action' => 'index'));
        }

        $this->Subregion->id = $id;

        if ($this->Subregion->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Subregion has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'subregions', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete subregion. Please, try again', 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Subregion->id = $id;

        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Subregion->findById($id);
            $this->_setViewVariables();
        }

        $this->add($id);
    }

    private function _getAllStates($setValue = true) {
        /*$options['fields'] = array(
            'State.id',
            'State.statename'
        );
        $options['recursive'] = -1;
        $options['order'] = array('State.statename');

        $states = $this->State->find('all', $options);
//        debug($locations);
        if($setValue) {
            $this->set(array('states' => $states));
        } else {
            return $states;
        }*/
    }

    public function _getAllStateGroup($setValue = true) {

        /*$regions = $this->Subregion->find('all');

        if(count($regions) != 0) {
            $allgroups = array();
            foreach ($regions as $group) {
                $stateids = $group['Subregion']['stateids'];
                $arr_state_ids = explode(',',$stateids);
                $states = $this->State->find('all', array('conditions' => array('State.id' => $arr_state_ids)));
                $arr_states = [];
                foreach ($states as $state) {
                    $arr_states[] = $state['State']['statename'];
                }
                $str_states = implode(', ', $arr_states);
                $group['Subregion']['states'] = $str_states;
                $allgroups[] = $group;
            }
            if($setValue) {
                $this->set('regions', $allgroups);
            } else {
                return $allgroups;
            }
        } else {
            if($setValue) {
                $this->set('regions', array());
            } else {
                return null;
            }
        }*/
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setTitleOfPage('Setup');

        $regionlist = $this->Region->getRegionList();
        $subregions = $this->Subregion->getSubregions();

        $this->set(
            array(
                "regionlist" => $regionlist,
                "subregions" => $subregions
            )
        );
    }
}
