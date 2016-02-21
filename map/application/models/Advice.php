<?php
class Advice extends Zend_Db_Table
{

	protected $_name = 'advice';
	protected $_primary = 'advice_id';
	
	//
	function advice_select_limit6()
	{
		$db=$this->getAdapter();
		$sql = "select * from advice order by time DESC,advice_id DESC limit 0,8";
		$result = $db->query($sql)->fetchAll();
		/* print "<pre>";
		 print_r($result);
		print "</pre>";
		exit(); */
		return $result;
	}
	//function user_login($nickname,$password){}
	//根据限制取意见
	function advice_select_limit($offset,$rows)
	{
		$result = array();
		$db=$this->getAdapter();
		$sql = "select count(*) advice from user";
		$row = $db->query($sql)->fetchAll();
		$result["total"] = $row[0]['num'];
		/* print "<pre>";
		 print_r($result);
		print "</pre>";
		exit(); */
		$sql1 = "select * from advice limit $offset,$rows";
		$row = $db->query($sql1)->fetchAll();
		$result["rows"] = $row;
		/* print "<pre>";
		 print_r($result);
		print "</pre>";
		exit(); */
		return $result;
	}
	
	//根据id删除
	function advice_delete($advice_id)
	{
	
		if (!$advice_id) {
			return 0;
		}
	
		$db = $this->getAdapter();
		$where = $db->quoteInto('advice_id = ?', $advice_id);
		try
		{
			$rows_affected = $this->delete($where);
			return $rows_affected;
		}catch (Exception $e)
		{
			return 0;
		}
	}
	
	//增加意见
	function advice_add($advicer,$time,$content)
	{
		$row = array (
				'advicer'    	=> $advicer,
				'time'    		=> $time,
				'content'    	=> $content
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
?> 