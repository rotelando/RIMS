<?php

/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 9/30/14
 * Time: 11:43 AM
 */
class PaginatorModelHelper extends Component
{

    //Default get parameter labels
    const PARAM_PAGE = 'pg';

    const PARAM_PAGE_SIZE = 'pgSize';

    const PARAM_SEARCH_KEYWORD = 'q';

    const PARAM_FILTERS = 'flt';

    const PARAM_SORT_COLUMNS = 'srt';


    //List of Default values for this helper
    private $_page = 0;

    private $_pageSize = 25;

    private $_searchKeyword = "";

    private $_filterColumns = array();

    private $_sortingColumns = array();

    private $_searchColumns = array();

    private $_options;

    private $_controller;

    private $_model;


    /*
     * The constructor of this helper expects the 1st param to be an object of the KCriteriaBuilder
     * The 2nd param should be the possible columns you want the result to be searchable by
    */
    public function getPaginatedOptions($controller, $modelName, $existingOptions = null) {

        $this->_controller = $controller;

        $this->_model = ClassRegistry::init($modelName);

        $this->_options = $existingOptions;

        $this->getUrlParams();
    }

    private function getUrlParams()
    {
        //check if page is set or use default setting
        $page = $this->controller->params['url'][self::PARAM_PAGE];
        if (isset($page) && is_numeric($page)) {
            $this->_page = urldecode($page);
        }

        //check if page size is set or use default setting
        $pageSize = $this->controller->params['url'][self::PARAM_PAGE_SIZE];
        if (isset($pageSize) && is_numeric($pageSize)) {
            $this->_pageSize = urldecode($pageSize);
        }

        //check if search keyword is set or use default setting
        $searchKeyword = $this->controller->params['url'][self::PARAM_SEARCH_KEYWORD];
        if (isset($searchKeyword) && $searchKeyword !== '') {
            $this->_searchKeyword = urldecode($searchKeyword);
        }

        //check if filter columns is set or use default setting
        $filterColumns = $this->controller->params['url'][self::PARAM_FILTERS];
        if (isset($filterColumns)) {
            $this->validateFilterTerm(urldecode($filterColumns));
        }

        //check if sort columns is set or use default setting
        $sortColumns = $this->controller->params['url'][self::PARAM_SORT_COLUMNS];
        if (isset($sortColumns)) {
            $this->validateSortTerm(urldecode($sortColumns));
        }

    }

    public function paginate()
    {
        //if the page number requested for is more than the last page number
        //serve the last page
        $lastPage = intval(ceil($this->_count / $this->_pageSize)) - 1;

        if ($lastPage < $this->_page) {
            $this->_page = $lastPage;
        }

        //if the page number requested for is less than the first page number
        //serve the first page
        if ($this->_page < 0) {
            $this->_page = 0;
        }

        $offset = $this->_page * $this->_pageSize;
        $limit = $this->_pageSize;

        $this->_options['limit'] = $limit;
        $this->_options['offset'] = $offset;
    }

    public function getPages($number_of_pages = NULL)
    {
        return (new PaginationHelper($this->_count, $this->_pageSize, $this->_page))->getPagesForLinks($number_of_pages);
    }

    //get the count of this result set
    //to enable display of pages on the front
    public function getResultSetCount()
    {

        try {
            $result = $this->_model->find('count', $this->_options);

            if ($result) {
                return $result;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return -1;
        }

    }

    public function buildCriteria()
    {
        $this->_addCoulmnFilters();
        $this->_addSearchCriteria();
        $this->_addSortCoulmns();
    }

    //responsible for building the search query associated with a result set
    private function _addSearchCriteria()
    {
        //set the initial search query to be empty to enable us append and
        //also to know if the search query is supposed to be empty
        //going to put the search query as a single entity to ensure it evaluated as one
        //operand e.g. (col LIKE %q% OR col LIKE %q% OR col LIKE %q%) etc
        $searchQuery = "";
        foreach ($this->_searchColumns as $search) {
            if (strlen($searchQuery) == 0) {
                //if the search query is still empty
                //put the initial bracket and append the 1st search condition
                $searchQuery .= " (" . $this->_getSearchQuery($search, $this->_searchKeyword) . " ";
            } else {
                //subsequently, append the remaining search conditions using an OR
                $searchQuery .= " OR " . $this->_getSearchQuery($search, $this->_searchKeyword) . " ";
            }
        }

        //check if the searchQuery has sufficient value to make us want to update
        //the condition of our query and also close the bracket if we did open it
        if (strlen($searchQuery) > 0) {
            $searchQuery .= ")";

            $this->_query->updateCondition($searchQuery);
        }
    }

    private function _addCoulmnFilters()
    {
        foreach ($this->_filterColumns as $filter) {

            //fix for date range issues
            if($this->_isDate($filter["value"]) && $filter["operator"] == '<=')
                $filter["value"] = $filter["value"] . ' 23:59:59';
            else if($this->_isDate($filter["value"]) && $filter["operator"] == '>=')
                $filter["value"] = $filter["value"] . ' 00:00:00';

            $flt = $filter["column"] . " " . $filter["operator"] . " '" . $filter["value"] . "' ";

            if (strtolower(trim($filter["operator"])) == "like") {
                $flt = $this->_getSearchQuery($filter["column"], $filter["value"]);
            }

            $this->_query->updateCondition($flt);
        }
    }

    private function _isDate($dateString) {

        return (DateTime::createFromFormat('Y-m-d', $dateString) == TRUE);
    }

    private function _addSortCoulmns()
    {
        foreach ($this->_sortingColumns as $sort) {
            $srt = $sort["column"] . " " . $sort["direction"];

            $this->_query->updateOrder($srt);
        }
    }

    private function _getSearchQuery($column, $value)
    {
        return $column . " LIKE " . "'%".self::escapeMySQLString($value)."%' ";
    }

    //ensures the parameters received is as exoected
    //(c:v)
    private function validateSortTerm($term)
    {

        $arrTerms = explode(',', $term);

        foreach ($arrTerms as $item) {
            $arrItems = explode(':', $item);

            if (count($arrItems) != 2)
                continue;

            $this->_sortingColumns[$arrItems[0]] = array("column" => $arrItems[0], "direction" => $arrItems[1]);

        }
    }

    public static function escapeMySQLString($string)
    {
        $data = "";
        $escape = '\\';
        for ($i = 0; $i < strlen($string); $i++) {
            $substr = substr($string, $i, 1);
            $append = $substr == "'" ? $escape . $substr : $substr;
            $data .= $append;
        }
        return $data;
    }

    //ensures the parameters received is as exoected
    //(c:o:v)
    private function validateFilterTerm($term)
    {

        $arrTerms = explode(',', $term);

        foreach ($arrTerms as $item) {
            $arrItems = explode(':', $item);

            if (count($arrItems) != 3)
                continue;

            $this->_filterColumns[] = array("column" => $arrItems[0], "operator" => $arrItems[1], "value" => $arrItems[2]);

        }
    }
} 