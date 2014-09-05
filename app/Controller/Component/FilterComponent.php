<?php


class FilterComponent extends Component {

    private $location;
    private $user;
    private $state;
    private $region;
    private $country;
    public $uses = array('Outlet', 'State', 'Region', 'Country', 'Location', 'User');
    public $components = array('Session');
    private $controller = null;
    
    public function initialize(Controller $controller) {
        $this->controller =& $controller; 
        $this->country = ClassRegistry::init('Country');
        $this->region = ClassRegistry::init('Region');
        $this->state = ClassRegistry::init('State');
        $this->location = ClassRegistry::init('Location');        
        $this->user = ClassRegistry::init('User');
    }

    public function getUrlFilterOptions($model) {
        
        $options = array();

        if (isset($this->controller->params['url']['floc'])) {

            $locParam = $this->controller->params['url']['floc'];
            
            $options = $this->getOptionValueFromString($locParam);
            
        }
        //condition for fieldrep filter
        if (isset($this->controller->params['url']['fuser'])) {
            $options['conditions']['Outlet.userid'] = $this->controller->params['url']['fuser'];
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
            
            $options['conditions']["DATE_FORMAT( {$model}.createdat,  '%Y-%m-%d' ) <="] = $toDate;
            $options['conditions']["DATE_FORMAT( {$model}.createdat,  '%Y-%m-%d' ) >="] = $fromDate;
        }
        
        return $options;
    }
    
    public function getPostDataFilterOptions($model) {

        $options = array();
        if (isset($this->controller->request->data[$model]['locFilter']) && $this->controller->request->data[$model]['locFilter'] != '') {
            
            //$options['conditions']['Outlet.locationid'] = $this->controller->request->data[$model]['locFilter'];
            $locParam = $this->controller->request->data[$model]['locFilter'];

            $options = $this->getOptionValueFromString($locParam);
        }
        
        //condition for fieldrep filter
        if (isset($this->controller->request->data[$model]['userFilter']) && $this->controller->request->data[$model]['userFilter'] != '') {
            $options['conditions']['Outlet.userid'] = $this->controller->request->data[$model]['userFilter'];
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
                    $fromDate = $this->controller->request->data[$model]['sdate'];
                    $toDate = $this->controller->request->data[$model]['edate'];
                    break;

                default:
                    $toDate = date('Y-m-d');
                    $fromDateFull = strtotime("-2 weeks");
                    $fromDate = date('Y-m-d', $fromDateFull);
                    break;
            }
            
            $options['conditions']["DATE_FORMAT( {$model}.createdat,  '%Y-%m-%d' ) <="] = $toDate;
            $options['conditions']["DATE_FORMAT( {$model}.createdat,  '%Y-%m-%d' ) >="] = $fromDate;
        }
        
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
            $options['conditions']['State.countryid'] = $locArr[1];
        } else if($locArr[0] == 'reg') {
            $options['conditions']['State.regionid'] = $locArr[1];
        } else if($locArr[0] == 'sta') {
            $options['conditions']['State.id'] = $locArr[1];
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
        } else if($locArr[0] == 'sta') {
            $state = $this->state->findById($locArr[1]);
            return $state['State']['statename'];
        } else if($locArr[0] == 'loc') {
            $location = $this->location->findById($locArr[1]);
            return $location['Location']['locationname'];
        }

        return '';
    }
}