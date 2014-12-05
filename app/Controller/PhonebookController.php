<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 12/1/14
 * Time: 11:16 AM
 */

class PhonebookController extends AppController {

    var $name = 'Phonebook';
    var $uses = array('Outlet', 'Outletclass', 'Outletchannel', 'Retailtype', 'Product', 'Brand', 'Outletimage',
        'State', 'Subregion', 'Region', 'Lga', 'Territory', 'Location', 'Outletimage', 'Outletproduct', 'Outletmerchandize', 'Productsource');
    var $helpers = array('GoogleMap', 'TextFormater', 'Time');
    public $components = array('Paginator', 'PagerHelper', 'Filter', 'SSP');

    public $urloptions = array();
    public $postoptions = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();
        $this->urloptions = $this->Filter->getUrlFilterOptions('Outlet');
        $this->postoptions = $this->Filter->getPostDataFilterOptions('Outlet');
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('phonebook');
        $this->_setTitleOfPage('Phone Book');
    }

    public function index() {}

    public function paginatedPhonebook() {

        $dataResponse = [];

        $options = $this->Filter->getUrlFilterOptions('Outlet');
        $options['order'] = array('Outlet.created_at' => 'DESC');

        $pagOptions = $this->getParamOptions($options);

        $paginatedOutlets = $this->Outlet->getPaginatedPhonenumbers($this->Paginator, $options);

        $this->PagerHelper->setParams($pagOptions['count'], $pagOptions['pgSize'], $pagOptions['page']);
        $pagers = $this->PagerHelper->getPagesForLinks(7);

        $dataResponse['outlets'] = $paginatedOutlets;
        $dataResponse['pagination'] = $pagers;
        $jsonresponse = json_encode($dataResponse);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    private function getParamOptions(&$options) {

        $request = $this->request;

        $page = isset($request['url']['page']) ? $request['url']['page'] : 0;
        $pgSize = isset($request['url']['pgSize']) ? $request['url']['pgSize'] : 25;
        if(isset($request['url']['srt'])) {
            $this->setSortOptions($options, $request['url']['srt']);
        }
        if(isset($request['url']['q'])) {
            $q = $request['url']['q'];

            $options['conditions']['OR'] = array(
                'Outlet.outletname LIKE' => "%{$q}%",
                'Location.locationname LIKE' => "%{$q}%"
            );
        }
        if(isset($request['url']['noType'])) {
            $noType = $request['url']['noType'];

            $options['conditions']['OR'] = array(
                'Outlet.contactphonenumber LIKE' => "{$noType}%",
                'Outlet.contactalternatenumber LIKE' => "{$noType}%"
            );
        }

        $count = $this->Outlet->getPaginatedPhonenumbers($this->Paginator, $options, true);

        return $this->setPaginateOptions($options, $page, $pgSize, $count);
    }

    private function setSortOptions(&$options, $sortString) {

        if(strpos($sortString, ':') != -1) {
            $arrSort = explode(':', $sortString);
            $srtColumn = $arrSort[0];
            $srtDirection = isset($arrSort[1]) ? $arrSort[1] : 'ASC';

            $options['order'] = array($srtColumn => $srtDirection);
        }
    }

    private function setPaginateOptions(&$options, $page, $pageSize, $count)
    {
        //if the page number requested for is more than the last page number
        //serve the last page
        $lastPage = intval(ceil($count / $pageSize)) - 1;

        if ($lastPage < $page) {
            $page = $lastPage;
        }

        //if the page number requested for is less than the first page number
        //serve the first page
        if ($page < 0) {
            $page = 0;
        }

        $offset = $page * $pageSize;
        $limit = $pageSize;

        $options['limit'] = $limit;
        $options['offset'] = $offset;

        return array('page' => $page, 'pgSize' => $pageSize, 'count' => $count);
    }
    //End pagination for outlet display all

    public function downloadCSV() {

        $csv_loc = 'files/contacts_' . date('Ymdhhmmss');

        $dataResponse = [];

        $options = $this->Filter->getUrlFilterOptions('Outlet');
        $options['order'] = array('Outlet.created_at' => 'DESC');

        $pagOptions = $this->getParamOptions($options);

        $paginatedcontacts = $this->Outlet->getPaginatedPhonenumbers($this->Paginator, $options);

        $handle = fopen($csv_loc, 'w');

        foreach ($paginatedcontacts as $contact) {

            fputcsv($handle, $contact);
        }


    }

    public function vtuShare() {

        $resp = [];
        $i = 0;
        $colors = ['#3266cc', '#dc3812', '#fe9900', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];

        $options = $this->urloptions;
        $rs = $this->Outlet->getVTUShare($options);

        foreach ($rs as $key => $value) {
            $data['name'] = $key;
            $data['y'] = $value;
            // if ($data['y'] > $max) {
            //     $max = $data['y'];
            //     $max_index = $i;
            // }
            $data['color'] = $colors[$i];
            $resp[] = $data;
            $i++;
        }

        // $resp[$max_index]['selected'] = true;
        // $resp[$max_index]['sliced'] = true;

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }

    public function productsourceShare() {

        $resp = [];
        $i = 0;
        $colors = ['#fe9900', '#dc3812', '#109619', '#990099', '#aaab11', '#e67300', '#dd4578', '#f2f2f2', '#8b0607'];

        $options = $this->urloptions;
        $rs = $this->Outlet->getProductSourceShare($options);

        foreach ($rs as $key => $value) {
            $data['name'] = $key;
            $data['y'] = $value;
            // if ($data['y'] > $max) {
            //     $max = $data['y'];
            //     $max_index = $i;
            // }
            $data['color'] = $colors[$i];
            $resp[] = $data;
            $i++;
        }

        // $resp[$max_index]['selected'] = true;
        // $resp[$max_index]['sliced'] = true;

        $response = json_encode($resp);
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $response);
    }
}