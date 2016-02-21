<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 15:32
 */
class User extends Zend_Db_Table
{
    protected $_name = 'user';
    protected $_primary = 'job_number';

    //�û���¼
    function user_login($user_name,$password)
    {
        //�ж�user_name�Ƿ�Ϊ��
        if (!$user_name) {
            return 0;
        }
        //��ȡadapter����������ֹmysqlע�롣
        $db = $this->getAdapter();
        $where = $db->quoteInto('user_name = ?', $user_name)
            .$db->quoteInto(' and user_password = ?', $password);
        $loginuser = $this->fetchAll($where)->toArray();
        //echo $loginuser;
        return $loginuser;

        //return $password;
    }

    function getPageCount()
    {
        $db = $this->getAdapter();

        $sql = "select * from `user`";
        $rowCount = $db->query($sql)->rowCount();
        $pageSize = 4;
        $pageCount = ceil($rowCount / $pageSize);

        return $pageCount;
    }

    function getMessage($pageNow)
    {

        $db = $this->getAdapter();

        $pageSize = 4;
        $sql1 = "select * from `user` limit " . ($pageNow - 1) * $pageSize . ",$pageSize";
        $message = $db->query($sql1)->fetchAll();

        return $message;

    }

    function getPages($pageNow)
    {
        $db = $this->getAdapter();

        $sql = "select * from `user`";
        $rowCount = $db->query($sql)->rowCount();
        $pageSize = 4;
        $pageCount = ceil($rowCount / $pageSize);
        if($pageNow==$pageCount){
            if($rowCount% $pageSize!=0)
            {
                $pageSize = $rowCount-(floor($rowCount / $pageSize)*$pageSize);
            }
        }

        return $pageSize;
    }

    function getRowCount()
    {
        $db = $this->getAdapter();

        $sql = "select * from `user`";
        $rowCount = $db->query($sql)->rowCount();

        return $rowCount;
    }

     function changeuser($job_number,$user_name,$user_password,$manager)
     {
        $row = array (
            'user_name'    		=> $user_name,
            'user_password'    	=> $user_password,
            'manager'        	=> $manager,
        );
        $db = $this->getAdapter();
        $where = $db->quoteInto('job_number = ?', $job_number);
        try{
            $rows_affected = $this->update($row, $where);
            return $rows_affected;
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    function adduser($user_name,$user_password,$manager)
    {
        if (!$user_name) {
            return 0;
        }
        $row = array (
            'user_name'    		=> $user_name,
            'user_password'    	=> $user_password,
            'manager'        	=> $manager,
        );
        try{
            $affected_rows = $this->insert($row);
            return $affected_rows;
        }catch (Exception $e)
        {
            return 0;
        }

    }

    function deleteuser($job_number)
    {
        if (!$job_number) {
            return 0;
        }

        $db = $this->getAdapter();
        $where = $db->quoteInto('job_number = ?', $job_number);
        try
        {
            $rows_affected = $this->delete($where);
            return $rows_affected;
        }catch (Exception $e)
        {
            return 0;
        }
    }

}
