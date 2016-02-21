<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 15:32
 */
class Test extends Zend_Db_Table
{
    protected $_name = 'test';
    protected $_primary = 'test_id';
    //²âÊÔÎÄ¼þ
    function test()
    {

    }
    function add($test_name,$test_massage)
    {
        $this->getAdapter();

        $row = array (
            'test_name' => $test_name,
            'test_massage' => $test_massage
        );

        try{
            $affected_rows = $this->insert($row);
            return $affected_rows;
        }catch (Exception $e)
        {
            return 0;
        }
    }



}