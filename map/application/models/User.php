<?php

class User extends Zend_Db_Table{
	
	protected $_name = 'user';
	protected $_primary = 'user_id';
	
	//根据所传参数提取当前页所学的记录
	function user_select_limit($offset,$rows)
	{
		$result = array();
		$db=$this->getAdapter();
		$sql = "select count(*) num from user";
		$row = $db->query($sql)->fetchAll();
		$result["total"] = $row[0]['num'];
		/* print "<pre>";
			print_r($result);
		print "</pre>";
		exit(); */
		$sql1 = "select * from user limit $offset,$rows";
		$row = $db->query($sql1)->fetchAll();
		$result["rows"] = $row;
		/* print "<pre>";
		 print_r($result);
		print "</pre>";
		exit(); */
		return $result;
	}
	
	//用户登录
	function user_login($nickname,$password)
	{
		//判断username是否为空
		if (!$nickname) {
			return 0;
		}
		//获取adapter适配器，防止mysql注入。
		$db = $this->getAdapter();
		$where = $db->quoteInto('nickname = ?', $nickname)
				.$db->quoteInto(' and password = ?', $password);
		
		$loginuser = $this->fetchAll($where)->toArray();

		
		return $loginuser;
	}
		
	//用户注册
	function user_sign($username, $nickname, $password, $sex, $email, $tel, $qq, $introduction)
	{	
		
		date_default_timezone_set('PRC');
		$registertime = date("Y-m-d H:i:s" );

		$row = array (
				//'user_id'    	=> $Uid,
				'username'    	=> $username,
				'nickname'    	=> $nickname,
				'password'    	=> $password,
				'sex'			=> $sex,
				'email'     	=> $email,
				'tel'    		=> $tel,
				'qq'     		=> $qq,
				'introduction' 	=> $introduction,
				'registertime'  => $registertime,
				'is_manager'	=> 0
		);
		try{
			$affected_rows = $this->insert($row);

			return $affected_rows;
		}catch (Exception $e)
		{
			return 0;
		}
		
	}
	
	//根据(md5转码后的邮箱)取出用户信息
	function user_alterpassword_email($email,$password)
	{
		
		$db = $this->getAdapter();
		$where = $db->quoteInto('email = ?', $email);
		$set = array(
				'password'    	=> $password,
		);

		$rows_affected = $this->update($set, $where);
		return $rows_affected;
	}
	
	//删除用户
	function user_delete($user_id)
	{
		
		if (!$user_id) {
				return 0;
			}
		
			$db = $this->getAdapter();
			$where = $db->quoteInto('user_id = ?', $user_id);
		try
		{
			$rows_affected = $this->delete($where);
			return $rows_affected;
		}catch (Exception $e)
		{
			return 0;
		}
	}
	
	//用户修改
	function user_update($user_id, $username, $nickname, $sex,  $email, $tel, $qq, $introduction, $is_manager)
	{
	
		$set = array (
				'username'    	=> $username,
				'nickname'    	=> $nickname,
				'sex'			=> $sex,
				'email'     	=> $email,
				'tel'    		=> $tel,
				'qq'     		=> $qq,
				'introduction' 	=> $introduction,
				'is_manager'	=> $is_manager
		);

		$db = $this->getAdapter();
		$where = $db->quoteInto('user_id = ?', $user_id);
		try{
			$rows_affected = $this->update($set, $where);
			return $rows_affected;
		}catch (Exception $e)
		{
			return 0;
		}
		
	}
	
	//根据id取出用户信息
	function user_select_id($user_id)
	{
		$db = $this->getAdapter();
		$where = $db->quoteInto('user_id = ?', $user_id);
		$row = $this->fetchAll($where)->toArray();
		return $row[0];
		
	}
	
	//分页
	function user_fenye($pageNow,$pageCount,$rowCount,$pageSize)
	{
		$where = "select * from user limit ".($pageNow-1)*$pageSize.",$pageSize";
		$rowset = $this->getAdapter()->query($where)->fetchAll(); 
		return $rowset;	  
	}
}
