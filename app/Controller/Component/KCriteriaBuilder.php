<?php

/**
 * Created by PhpStorm.
 * User: zaga
 * Date: 9/30/14
 * Time: 7:10 PM
 */
class CriteriaBuilder extends Component
{
    private $_select = "";
    private $_condition = "";
    private $_afterCondition = "";
    private $_order = "";
    private $_limit = "";

    /*
     *
    this method takes the different parts of the original
    query and holds it in this object.

    1st param is the select portion (including the from clause and possible joins)
    2nd param is the condition portion (it can be extended and modified for pagination and filters)
    3rd param is for group by and having clauses that can be part of the query
    4th param is the order by section (it can also be modified to sort result sets)

    2nd param must not take the "WHERE" clause (it is automatically generated the builder)
    4th param must not take the "ORDER BY" clause (it is automatically generated the builder)
    */
    public function init($select, $condition, $afterCond, $order)
    {
        $this->_select = $select;
        $this->_condition = $condition;
        $this->_afterCondition = $afterCond;
        $this->_order = $order;
    }

    //this method updates the WHERE clause as is appropriate
    public function updateCondition($param)
    {
        if (strlen($this->_condition) > 0)
            $this->_condition .= " AND " . $param;
        else
            $this->_condition = $param;

    }

    //this method updates the ORDER BY clause as is appropriate
    public function updateOrder($param)
    {
        if (strlen($this->_order) > 0)
            $this->_order .= ", " . $param;
        else
            $this->_order = $param;
    }

    //this method is responsible for setting the limit on the result set
    public function setLimit($limit, $offset = 0)
    {
        $this->_limit = "LIMIT $offset, $limit";
    }

    //this is the method that aggregates all the different part of the query and
    //produces the raw SQL that can be executed
    public function buildQuery()
    {
        $sql = $this->_select . " ";

        if (strlen($this->_condition) > 0)
            $sql .= " WHERE " . $this->_condition . " ";

        if (strlen($this->_afterCondition) > 0)
            $sql .= $this->_afterCondition . " ";

        if (strlen($this->_order) > 0) {
            $sql .= " ORDER BY " . $this->_order . " ";
        }

        if (strlen($this->_limit) > 0)
            $sql .= $this->_limit;

        return $sql;
    }
} 