<?php


class FilterComponent extends Component {

    private $location;
    private $lga;
    private $territory;
    private $state;
    private $subregion;
    private $region;
    private $country;
    private $user;
    private $retailtype;
    public $uses = array('Outlet', 'State', 'Region', 'Subregion', 'Territory', 'Lga', 'Country', 'Location', 'User', 'Retailtype');
    public $components = array('Session');
    private $controller = null;
    
    public function initialize(Controller $controller) {
        $this->controller =& $controller; 
        $this->country = ClassRegistry::init('Country');
        $this->region = ClassRegistry::init('Region');
        $this->subregion = ClassRegistry::init('Subegion');
        $this->state = ClassRegistry::init('State');
        $this->territory = ClassRegistry::init('Territory');
        $this->lga = ClassRegistry::init('Lga');
        $this->location = ClassRegistry::init('Location');
        $this->user = ClassRegistry::init('User');
        $this->retailtype = ClassRegistry::init('Retailtype');
    }

    public function getUrlFilterOptions($model) {
        
        $options = array();

        //condition for retailtype filter
        //This came first so as not to override the former ones
        if (isset($this->controller->params['url']['fret'])) {
            $retailtypeids = explode(',', $this->controller->params['url']['fret']);
            $options['conditions'] = array('Outlet.retailtype_id' => $retailtypeids);
        }

        if (isset($this->controller->params['url']['floc'])) {

            $locParam = $this->controller->params['url']['floc'];
            
            $options = $this->getOptionValueFromString($locParam);
            
        }
        //condition for fieldrep filter
        if (isset($this->controller->params['url']['fuser'])) {
            $options['conditions']['Outlet.user_id'] = $this->controller->params['url']['fuser'];
        }

        if (isset($this->controller->params['url']['fdate'])) {

            $fdate = $this->controller->params['url']['fdate'];
            switch ($fdate) {
                case "yes":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-1 day");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "lw":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-1 week");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l2w":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-2 weeks");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "lm":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-1 month");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l2m":    
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-2 months");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l3m":    
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-3 months");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l6m":    
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-6 months");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "cust":    
                    $fromDate = $this->controller->params['url']['sdate'];
                    $toDate = $this->controller->params['url']['edate'];
                    break;

                default:
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-2 weeks");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
            }
            
            $options['conditions']["DATE_FORMAT( {$model}.created_at,  '%Y-%m-%d' ) <="] = $toDate . ' 23:59:59';
            $options['conditions']["DATE_FORMAT( {$model}.created_at,  '%Y-%m-%d' ) >="] = $fromDate . ' 00:00:00';
        }

        $options['joins'] = array(

            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'lgas',
                'alias' => 'Lga',
                'type' => 'LEFT',
                'conditions' => array(
                    'Lga.id = Location.lga_id'
                )
            ),
            array(
                'table' => 'territories',
                'alias' => 'Territory',
                'type' => 'LEFT',
                'conditions' => array(
                    'Territory.id = Lga.territory_id'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Territory.state_id'
                )
            ),
            array(
                'table' => 'subregions',
                'alias' => 'Subregion',
                'type' => 'LEFT',
                'conditions' => array(
                    'Subregion.id = State.subregion_id'
                )
            ),
            array(
                'table' => 'regions',
                'alias' => 'Region',
                'type' => 'LEFT',
                'conditions' => array(
                    'Region.id = Subregion.region_id'
                )
            )
        );
        return $options;
    }
    
    public function getPostDataFilterOptions($model) {

        $options = array();

        //condition for retailtype filter
        //This comes first so as not to override the rest
        if (isset($this->controller->request->data[$model]['retailtypelist']) && $this->controller->request->data[$model]['retailtypelist'] != '') {
            $retailtypeids = $this->controller->request->data[$model]['retailtypelist'];
            $options['conditions'] = array('Outlet.retailtype_id' => $retailtypeids);
        }

        if (isset($this->controller->request->data[$model]['locFilter']) && $this->controller->request->data[$model]['locFilter'] != '') {

            $locParam = $this->controller->request->data[$model]['locFilter'];
            $options = $this->getOptionValueFromString($locParam);
        }
        
        //condition for fieldrep filter
        if (isset($this->controller->request->data[$model]['userFilter']) && $this->controller->request->data[$model]['userFilter'] != '') {
            $options['conditions']['Outlet.user_id'] = $this->controller->request->data[$model]['userFilter'];
        }
        
        if (isset($this->controller->request->data[$model]['dateFilter']) && $this->controller->request->data[$model]['dateFilter'] != '') {

            $fdate = $this->controller->request->data[$model]['dateFilter'];
            switch ($fdate) {
                case "yes":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-1 day");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "lw":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-1 week");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l2w":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-2 weeks");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "lm":
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-1 month");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l2m":    
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-2 months");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l3m":    
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-3 months");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "l6m":    
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-6 months");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
                
                case "cust":
                    $date = $this->controller->request->data['custdate'];
                    $arrDateRange = $this->getDateRanges($date);
                    $fromDate = $arrDateRange['sdate'];
                    $toDate = $arrDateRange['edate'];
                    break;

                default:
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-2 weeks");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
            }
            
            $options['conditions']["DATE_FORMAT( {$model}.created_at,  '%Y-%m-%d' ) <="] = $toDate;
            $options['conditions']["DATE_FORMAT( {$model}.created_at,  '%Y-%m-%d' ) >="] = $fromDate;
        }

        $options['joins'] = array(

            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'lgas',
                'alias' => 'Lga',
                'type' => 'LEFT',
                'conditions' => array(
                    'Lga.id = Location.lga_id'
                )
            ),
            array(
                'table' => 'territories',
                'alias' => 'Territory',
                'type' => 'LEFT',
                'conditions' => array(
                    'Territory.id = Lga.territory_id'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Territory.state_id'
                )
            ),
            array(
                'table' => 'subregions',
                'alias' => 'Subregion',
                'type' => 'LEFT',
                'conditions' => array(
                    'Subregion.id = State.subregion_id'
                )
            ),
            array(
                'table' => 'regions',
                'alias' => 'Region',
                'type' => 'LEFT',
                'conditions' => array(
                    'Region.id = Subregion.region_id'
                )
            )
        );
        return $options;
    }
    
    public function getFilterText($model) {

        $options = array();
        
        if (isset($this->controller->request->data[$model]['locFilter']) && $this->controller->request->data[$model]['locFilter'] != '') {
            
            $locParam = $this->controller->request->data[$model]['locFilter'];

            $options['Location'] = $this->getLocationLabelFromParam($locParam);
        }
        
        //condition for fieldrep filter
        if (isset($this->controller->request->data[$model]['userFilter']) && $this->controller->request->data[$model]['userFilter'] != '') {
            $filteruser = $this->user->find('first', 
                    array(
                        'conditions' => array(
                            'User.id' => $this->controller->request->data[$model]['userFilter']),
                        'recursive' => -1));
            $options['User'] = $filteruser['User'];
        }
        
        if (isset($this->controller->request->data[$model]['dateFilter']) && $this->controller->request->data[$model]['dateFilter'] != '') {

            $fdate = $this->controller->request->data[$model]['dateFilter'];
            switch ($fdate) {
                case "yes":
                    $options['date'] = 'Yesterday';
                    break;
                
                case "lw":
                    $options['date'] = 'Last week';
                    break;
                
                case "l2w":
                    $options['date'] = 'Last 2 weeks';
                    break;
                
                case "lm":
                    $options['date'] = 'Last month';
                    break;
                
                case "l2m":    
                    $options['date'] = 'Last 2 months';
                    break;
                
                case "l3m":    
                    $options['date'] = 'Last 3 months';
                    break;
                
                case "l6m":    
                    $options['date'] = 'Last 6 months';
                    break;
                
                case "cust":    
                    $options['date'] = "Betweeen {$this->controller->request->data[$model]['sdate']} and {$this->controller->request->data[$model]['edate']}";
                    break;

                default:
                    $options['date'] = 'Last 2 weeks';
                    break;
            }
        }
        
        return $options;
    }
    
    private function getOptionValueFromString($locParamString) {

        $locArr = explode('_', $locParamString);
        
        if($locArr[0] == 'nat') {
            $options['conditions']['Country.id'] = $locArr[1];
        } else if($locArr[0] == 'reg') {
            $options['conditions']['Region.id'] = $locArr[1];
        } else if($locArr[0] == 'sub') {
            $options['conditions']['Subregion.id'] = $locArr[1];
        } else if($locArr[0] == 'sta') {
            $options['conditions']['State.id'] = $locArr[1];
        } else if($locArr[0] == 'ter') {
            $options['conditions']['Territory.id'] = $locArr[1];
        } else if($locArr[0] == 'lga') {
            $options['conditions']['Lga.id'] = $locArr[1];
        } else if($locArr[0] == 'loc') {
            $options['conditions']['Location.id'] = $locArr[1];
        }

        return $options;
    }

    private function getLocationLabelFromParam($locParamString) {

        $locArr = explode('_', $locParamString);
        
        if($locArr[0] == 'nat') {
            $country = $this->country->findById($locArr[1]);
            return $country['Country']['countryname'];
        } else if($locArr[0] == 'reg') {
            $region = $this->region->findById($locArr[1]);
            return $region['Region']['regionname'];
        } else if($locArr[0] == 'sub') {
            $subregion = $this->Subregion->findById($locArr[1]);
            return $subregion['Subregion']['subregionname'];
        } else if($locArr[0] == 'sta') {
            $state = $this->state->findById($locArr[1]);
            return $state['State']['statename'];
        } else if($locArr[0] == 'ter') {
            $territory = $this->territory->findById($locArr[1]);
            return $territory['Territory']['territoryname'];
        } else if($locArr[0] == 'lga') {
            $lga = $this->lga->findById($locArr[1]);
            return $lga['Lga']['lganame'];
        } else if($locArr[0] == 'loc') {
            $location = $this->location->findById($locArr[1]);
            return $location['Location']['locationname'];
        }

        return '';
    }

    private function getDateRanges($date)
    {
        $hyphenPosition = strpos($date, '-');
        $length = strlen($date);
        $dateRange['sdate'] = trim(substr($date, 0, $hyphenPosition));
        $dateRange['edate'] = trim(substr($date, $hyphenPosition + 1, $length - $hyphenPosition));
        $dateRange['sdate'] = str_replace('/', '-', $dateRange['sdate']);
        $dateRange['edate'] = str_replace('/', '-', $dateRange['edate']);
        return $dateRange;
    }
}