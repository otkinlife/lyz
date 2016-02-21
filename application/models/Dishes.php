<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/23
 * Time: 15:01
 */
class Dishes extends Zend_Db_Table
{
    protected $_name = 'dishes';
    protected $_primary = 'dish_id';


    function getPageCount()
    {
        $db = $this->getAdapter();

        $sql = "select * from `dishes`";
        $rowCount = $db->query($sql)->rowCount();
        $pageSize = 4;
        $pageCount = ceil($rowCount / $pageSize);

        return $pageCount;
    }

    function getMessage($pageNow)
    {

        $db = $this->getAdapter();

        $pageSize = 4;
        $sql = "select * from `dishes` limit " . ($pageNow - 1) * $pageSize . ",$pageSize";
        $message = $db->query($sql)->fetchAll();

        return $message;

    }

    function getPages($pageNow)
    {
        $db = $this->getAdapter();

        $sql = "select * from `dishes`";
        $rowCount = $db->query($sql)->rowCount();
        $pageSize = 4;
        $pageCount = ceil($rowCount / $pageSize);
        if ($pageNow == $pageCount) {
            if ($rowCount % $pageSize != 0) {
                $pageSize = $rowCount - (floor($rowCount / $pageSize) * $pageSize);
            }
        }

        return $pageSize;
    }

    function getRowCount()
    {
        $db = $this->getAdapter();

        $sql = "select * from `dishes`";
        $rowCount = $db->query($sql)->rowCount();

        return $rowCount;
    }

    function getOrderMessage($r)//未完成
    {
        $db = $this->getAdapter();

        $rowCount = $this->getRowCount();
        /*
                $sql = "select * from `dishes`";
                $rowCount = $db->query($sql)->rowCount();

                return $rowCount;*/
    }

    function adddish($dish_name,$dish_price,$dish_remarks)
    {
        if (!$dish_name) {
            return 0;
        }
        $row = array (
            'dish_name'    		=> $dish_name,
            'dish_price'    	=> $dish_price,
            'dish_remarks'     => $dish_remarks,
        );
        try{
            $affected_rows = $this->insert($row);
            return $affected_rows;
        }catch (Exception $e)
        {
            //return 0;
            echo $e->getMessage();
        }
    }

}
