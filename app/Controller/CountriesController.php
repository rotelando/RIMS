<?php

class CountriesController extends AppController {
    
    var $name = 'Countries';
    var $uses = array('Country', 'Region', 'Subregion', 'State', 'Territory', 'Lga', 'Location', 'Prestate');
    var $components = array('Session');

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

    public function bulkupload() {

        $this->view = 'bulkupload';

        if($this->request->is('POST')) {

            $row = 0;
            $headers = array();
            $location_data = array();
            $hasHeader = isset($this->request->data['Country']['hasheader']) ? $this->request->data['Country']['hasheader'] : 'off';
            $filePath = isset($this->request->data['Country']['file']) ? $this->request->data['Country']['file'] : null;
            $removeAll = isset($this->request->data['Country']['removeall']) ? $this->request->data['Country']['removeall'] : 'off';
            //$filePath = $this->request->data['Country'][''];

            if($filePath != null) {

                if ($filePath['type'] == 'text/csv') {

                    $file = WWW_ROOT . 'upload' . DS . 'briefs' . DS . $filePath['name'];
                    $success = move_uploaded_file($filePath['tmp_name'], $file);

                    if ($success) {
                        if (($handle = fopen($file, "r")) !== FALSE) {
                            while (($data = fgetcsv($handle)) !== FALSE) {

                                if ($hasHeader == 'on' && $row == 0) {
                                    $headers = $data;
                                    $row++;
                                    continue;
                                }

                                $location_data[] = $data;
                                $row++;
                            }

                            fclose($handle);
                        }
                    }

                    $this->set(
                        array(
                            'locationdata' => $location_data
                        )
                    );
                    $this->Session->write('bulkfilename', $filePath['name']);
                    $this->Session->write('hasheader', $hasHeader);
                    $this->Session->write('removeall', $removeAll);

                } else {

                    $this->Session->setFlash('This is not a CSV file. Please, try again', 'page_notification_error');
                }
            }
        }

    }

    public function upload() {

        $this->view = 'bulkupload';

        $row = 0;
        $headers = array();
        $file = $this->Session->read('bulkfilename');
        $hasHeader = $this->Session->read('hasheader');
        $removeAll = $this->Session->read('removeall');

        if($removeAll == 'on') {

            $this->Region->query("TRUNCATE regions;");
            $this->Subregion->query("TRUNCATE subregions;");
            $this->State->query("TRUNCATE states;");
            $this->Territory->query("TRUNCATE territories;");
            $this->Lga->query("TRUNCATE lgas;");
            $this->Location->query("TRUNCATE locations;");
        }

        if(isset($file)) {

            $file = WWW_ROOT . 'upload' . DS . 'briefs' . DS . $file;

            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle)) !== FALSE) {

                    if ($hasHeader == 'on' && $row == 0) {
                        $headers = $data;
                        $row++;
                        continue;
                    }

                    $location_data[] = $data;
                    //$this->saveRow($data);
                    $row++;
                }

                fclose($handle);
            }

            $this->saveData($location_data);
        }

        $this->Session->setFlash('Data has been uploaded!', 'page_notification_info');
        $this->redirect(array('controller' => 'regions', 'action' => 'index'));

        /*$this->Session->delete('bulkfilename');
        $this->Session->delete('hasheader');
        $this->Session->delete('removeall');*/

    }
   
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setTitleOfPage('Setup');
        
        $this->_getAllCountries();
        $regionCount = $this->Region->getCount();
        $subregionCount = $this->Subregion->getCount();
        $stateCount = $this->State->getCount();
        $territoryCount = $this->Territory->getCount();
        $lgaCount = $this->Lga->getCount();
        $popCount = $this->Location->getCount();

        $this->set(array(
           'regionCount' => $regionCount,
           'subregionCount' => $subregionCount,
           'stateCount' => $stateCount,
           'territoryCount' => $territoryCount,
           'lgaCount' => $lgaCount,
           'popCount' => $popCount
        ));
    }

    private function saveData($location_data) {

        $ds_region = $this->Region->getDataSource();
        $ds_subregion = $this->Subregion->getDataSource();
        $ds_state = $this->State->getDataSource();
        $ds_territory = $this->Territory->getDataSource();
        $ds_lga = $this->Lga->getDataSource();
        $ds_location = $this->Location->getDataSource();

        $regions = array();
        $subregions = array();
        $states = array();
        $territories = array();
        $lgas = array();
        $locations = array();

        $country = $this->Country->findByCountryname('Nigeria');
        $country_id = $country['Country']['id'];

        foreach ($location_data as $data) {

            $region = ucwords(trim($data[0]));
            $subregion = ucwords(trim($data[1]));
            $state = ucwords(trim($data[2]));
            $territory = ucwords(trim($data[3]));
            $lga = ucwords(trim($data[4]));
            $location = ucwords(trim($data[5]));

            $regions[$region] = array('Region' => array(
                'regionname' => $region,
                'country_id' => $country_id
            ));

            $subregions[$subregion] = array('Subregion' => array(
                'subregionname' => $subregion,
                'region' => $region
            ));

            $states[$state] = array('State' => array(
                'statename' =>$state,
                'subregion' => $subregion
            ));

            $territories[$territory] = array('Territory' => array(
                'territoryname' => $territory,
                'state' => $state
            ));

            $lgas[$lga] = array('Lga' => array(
                'lganame' => $lga,
                'territory' => $territory
            ));

            $locations[$location] = array('Location' => array(
                'locationname' => $location,
                'lga' => $lga
            ));
        }

        $regionlist = $this->Region->createRegions($regions);
        $subregionlist = $this->Subregion->createSubregions($subregions, $regionlist);
        $statelist = $this->State->createStates($states, $subregionlist);
        $territorylist = $this->Territory->createTerritories($territories, $statelist);
        $lgalist = $this->Lga->createLgas($lgas, $territorylist);
        $locationlist = $this->Location->createLocations($locations, $lgalist);

        $ds_region->commit();
        $ds_subregion->commit();
        $ds_state->commit();
        $ds_territory->commit();
        $ds_lga->commit();
        $ds_location->commit();
    }
}
