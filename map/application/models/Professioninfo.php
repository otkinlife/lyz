<?php

class Professioninfo extends Zend_Db_Table
{

	protected $_name = 'professioninfo';
	protected $_primary = 'profession_id';
	
	
	
	//根据所传参数提取当前页所学的记录
	function profession_select_limit($offset,$rows)
	{
		$result = array();
		$db=$this->getAdapter();
		$sql = "select count(*) num from professioninfo";
		$row = $db->query($sql)->fetchAll();		
		$result["total"] = $row[0]['num'];
		/* print "<pre>";
		print_r($result);
		print "</pre>";
		exit(); */
		$sql1 = "select * from professioninfo limit $offset,$rows";	
		$row = $db->query($sql1)->fetchAll();
		$result["rows"] = $row;
		/* print "<pre>";
		 print_r($result);
		print "</pre>";
		exit(); */
		return $result;
	}
	
	//添加专业信息
	function profession_add($profession_id,$profession_name,$profession_type)
	{
		$row = array
		(
			'profession_id'		=>	 $profession_id,
			'profession_name' 	=>	 $profession_name,
			'profession_type' 	=> 	 $profession_type
		);
	
		try 
		{
			$affected_rows = $this->insert($row);
			return $affected_rows;
		}catch (Exception $e)
		{
			return 0;
		}
		
	}
	
	//修改专业信息
	function profession_update($profession_id,$profession_name,$profession_type)
	{
		$set = array
		(
				'profession_id'		=>	 $profession_id,
				'profession_name' 	=>	 $profession_name,
				'profession_type' 	=> 	 $profession_type
		);
		$db = $this->getAdapter();
		$where = $db->quoteInto('profession_id = ?', $profession_id);
		
		try
		{
			$affected_rows = $this->update($set, $where);
			return $affected_rows;
		}catch (Exception $e)
		{
			return 0;
		}
	
	}
	
	//删除专业信息
	function profession_delete($profession_id)
	{
		if (!$profession_id) {
			return 0;
		}
	
		$db = $this->getAdapter();
		$where = $db->quoteInto('profession_id = ?', $profession_id);
		try{
			$rows_affected = $this->delete($where);
			return $rows_affected;
		}catch (Exception $e)
		{
			return 0;
		}
	}
	
}
?> 