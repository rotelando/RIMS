<?php

/**
 * Created by PhpStorm.
 * User: zaga
 * Date: 9/29/14
 * Time: 6:28 PM
 */
class PagerHelperComponent extends Component
{
    private $_count;
    private $_pageSize;
    private $_currentPage;

    //takes number of the result set
    //and the number of items per page
    public function setParams($count, $pageSize, $currentPage)
    {
        $this->_count = $count;
        $this->_pageSize = $pageSize;
        $this->_currentPage = $currentPage;
    }

    //returns the first page of a set
    private function _getFirstPage()
    {
        return 0;
    }

    //returns the last page of a set
    private function _getLastPage()
    {
        return $this->_getPageCount() - 1;
    }

    //returns the total number of pages
    private function _getPageCount()
    {
        return intval(ceil($this->_count / $this->_pageSize));
    }

    //returns the next page from the current page
    public function _getNextPage()
    {
        return ($this->_currentPage == $this->_getLastPage()) ? $this->_getLastPage() : $this->_currentPage + 1;
    }

    //returns the previous page from the current page
    private function _getPrevPage()
    {
        return ($this->_currentPage == $this->_getFirstPage()) ? $this->_getFirstPage() : $this->_currentPage - 1;
    }

    //aggregates all the pages for pagination link
    public function getPagesForLinks($innerLabelCount = null)
    {
        $links_label = array();

        if ($innerLabelCount != NULL) {
            $links_label = $this->_getExtraLabels($innerLabelCount);
        }

        return array(
            "first" => $this->_getFirstPage(),
            "last" => $this->_getLastPage(),
            "previous" => $this->_getPrevPage(),
            "next" => $this->_getNextPage(),
            "currentPage" => $this->_currentPage,
            "links_label" => $links_label,
            "total_items" => $this->_count
        );
    }

    //gets the other links that can be dispalyed as part of the pagination text
    private function _getExtraLabels($innerLabelCount)
    {
        //return array value
        $retVal = [];

        //check if inner label is specified and is a valid numeric integer
        if (!is_null($innerLabelCount) && is_numeric($innerLabelCount)) {


            //Ensure the number of page links label to display is less than the available pagecount
            if ($innerLabelCount > $this->_getPageCount())
                $innerLabelCount = $this->_getPageCount();

            //remove the current page from the count returned
            $innerLabelCount -= 1;

            //get the padding left and right to be added to the currentPage
            $paddingLeft = $paddingRight = intval($innerLabelCount / 2);

            //check if it overflows to the left
            if (($ext = $this->_currentPage - $paddingLeft) < $this->_getFirstPage()) {
                $paddingRight += abs($ext);
                $paddingLeft -= abs($ext);
            }

            //check if it overflows to the right
            if (($this->_currentPage + $paddingRight) > $this->_getLastPage()) {
                $ext = ($this->_currentPage + $paddingRight) - $this->_getLastPage();
                $paddingLeft += abs($ext);
                $paddingRight -= abs($ext);
            }

            //pad the integers to the left
            for ($i = $paddingLeft; $i > 0; $i--) {
                $retVal[] = $this->_currentPage - $i;
            }

            //insert the current page in the center
            $retVal[] = $this->_currentPage;

            //pad the integers to the right
            for ($i = 1; $i <= $paddingRight; $i++) {
                $retVal[] = $this->_currentPage + $i;
            }
        }

        return $retVal;
    }
} 