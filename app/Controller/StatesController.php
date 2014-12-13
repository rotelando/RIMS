<?php

class StatesController extends AppController {
    
    var $name = 'States';
    var $uses = array('State', 'Prestate', 'Region');
    
    public function index() {
        
    }
    
    public function select($id = null) {
               
        
        if(!$this->State->exists($id)) {
            $prestate = $this->Prestate->find('first', array('conditions' => array('id' => $id)));
            $state['State']['id'] = $prestate['Prestate']['id'];
//            $state['State']['regionid'] = $prestate['Prestate']['regionid'];
            $state['State']['countryid'] = 1;       //Nigeria for now
            $state['State']['statename'] = $prestate['Prestate']['statename'];
            $state['State']['shortname'] = $prestate['Prestate']['shortname'];
            $state['State']['internalid'] = $prestate['Prestate']['internalid'];
            $state['State']['createdat'] = $this->_createNowTimeStamp();
            $this->State->save($state);
        }
        
        $states = $this->State->find('all', array('recursive' => -1));
        $response = json_encode($states);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    
    public function delete($id = null) {
        
        $this->State->id = $id;
        if ($this->State->delete()) {
            $response = '{ "status" : true, "message" : "successfully deleted!" }';
        } else {
            $response = '{ "status" : false, "message" : "not successfully deleted!" }';
        }
        
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
    
    
    private function _getAllStates(){
        $states = $this->State->find('all'); 
        $this->set('states', $states);
    }
    
    public function beforeRender() {
        parent::beforeRender();
        $this->_getAllStates();
        $this->_setViewVariables();
        return true;
    }

    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setTitleOfPage('Setup');
    }
    
    public function mapdata() {
        $mapdata["map"]["fillcolor"] = "ffffff";
        $mapdata["map"]["basefontsize"] = "10";
        $mapdata["map"]["showBevel"] = "0";
        $mapdata["map"]["borderColor"] = "105687";
        $mapdata["map"]["useHoverColor"] = "1";
        $mapdata["map"]["hoverColor"] = "105687";
        $mapdata["map"]["canvasBorderColor"] = "ffffff";
        $mapdata["map"]["toolTipBgColor"] = "ffffff";
        $mapdata["map"]["toolTipBorderColor"] = "000000";
        $mapdata["map"]["showToolTipShadow"] = "1";

//        $mapdata = <<< EOF
//        {
//              "map": {
//              "fillcolor": "ffffff",
//              "basefontsize": "10",
//              "showBevel": "0",
//              "borderColor": "ff5e63",
//              "useHoverColor": "1",
//              "hoverColor": "ff790f",  
//              "canvasBorderColor": "ffffff"
//                
//            },
//            "data": [
//              {"id": "NG.LA", "value": "30", "toolText": "Lagos {br}Actual Visit:245 {br}Planned Visit: 420", "color":"ff0000"},
//              {"id": "NG.ON", "value": "40"},
//              {"id": "NG.OS", "value": "100"},
//              {"id": "NG.OY", "value": "727", "link": "JavaScript:myFunction('USA', 235);"},
//              {"id": "NG.FC", "value": "885"}
//            ]
//        }
//EOF;
        //outlet count by locations
        $states = $this->Prestate->find('all');
//        debug($states);
        foreach ($states as $state) {
            $intid = $state['Prestate']['internalid'];
            $id = $state['Prestate']['id'];
            $tooltext = $state['Prestate']['statename'];
            $value = $state['Prestate']['shortname'];
            $mapdata['data'][$intid] = array(
                'id' => $intid,
                'value' => $value,
                'toolText' => $tooltext,
                'link' => 'JavaScript:mapStateFunction("' . $id . '")'
            );
        }

        $mapdata['data'] = array_values($mapdata['data']);
        $response = json_encode($mapdata);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    public function subregion($subregion_id) {

        $result = $this->State->stateBySubregion($subregion_id);
        $response = json_encode($result);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
}
