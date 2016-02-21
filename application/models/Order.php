<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/22
 * Time: 21:29
 */
class Order  extends Zend_Db_Table
{
    protected $_name = 'order';
    protected $_primary = 'order_id';
    //Ä£ºýËÑË÷
    function selectOrder($table_id,$order_number,$order_waiter,$order_date)
    {
        if (!$table_id&&!$order_number&&!$order_waiter&&!$order_date)
        {
            return 0;
        }

        $db = $this->getAdapter();

        $sql = "select * from `order` where ";
        if($table_id) {
            $sql = $sql."table_id = $table_id";
        }
        if($order_number) {
            if(!$table_id){
                $sql = $sql."order_number = $order_number";
            } else {
                $sql = $sql."and order_number = $order_number";
            }
        }
        if($order_waiter) {
            if (!$table_id && !$order_number) {
                $sql = $sql . "order_waiter like '%$order_waiter%'";
            } else {
                $sql = $sql . "and order_waiter like '%$order_waiter%'";
            }
        }
        if($order_date) {
            if(!$table_id&&!$order_number&&!$order_waiter){
                $sql = $sql."order_date = $order_date";
            } else {
                $sql = $sql."and order_date = $order_date";
            }
        }
        //$sql = "select * from `order`";
        $result = $db -> query($sql) -> fetchAll();
        //echo $sql;
        //var_dump( $result);
        return $result;
    }

}