<?php

class Schoolprofession extends Zend_Db_Table
{

	protected $_name = 'schoolprofession';
	protected $_primary = 'sp_id';

/********************************************** 增加高校专业 ***********************************************/
	//增加高校对应专业信息
	function sp_sign($school_id, $profession_id, $enroll, $grade, $special,$category){
	
		if (!$school_id) { return 0;}
		if (!$profession_id){ return 0;}
	
		$row = array (
				'school_id'    		=> $school_id,
				'profession_id'    	=> $profession_id,
				'enroll'    		=> $enroll,
				'grade' 		   	=> $grade,
				'is_special'			=> $special,
				'category'		    => $category,
		);
		try{
			$affected_rows = $this->insert($row);
			return $affected_rows;
		}catch (Exception $e)
		{
			return 0;
		}
		
	}
/********************************************** 高校专业查询 ***********************************************/
	//查询学校总数
	function sp_select_num(){
	
		$db=$this->getAdapter();
		$sql="select count(*) num from schoolprofession";
		$rowset = $db->query($sql)->fetchAll();
		return $rowset[0]['num'];
	}
	
	//根据分页函数取值
	public function sp_select_bylimit10($offset,$rows){
		$result = array();
		$db=$this->getAdapter();
		$sql = "select count(*) num from schoolprofession";
		$row = $db->query($sql)->fetchAll();
		$result["total"] = $row[0]['num'];
		
		$sql1 = "select  schoolinfo.school_name, professioninfo.profession_name, schoolprofession.sp_id,
						schoolprofession.school_id, schoolprofession.profession_id, schoolprofession.enroll,
						schoolprofession.grade, schoolprofession.is_special, schoolprofession.category
				from	schoolinfo,professioninfo,schoolprofession
				where	schoolinfo.school_id = schoolprofession.school_id and 
						professioninfo.profession_id = schoolprofession.profession_id
				order by schoolprofession.school_id asc, schoolprofession.profession_id asc  limit $offset,$rows";
		$row = $db->query($sql1)->fetchAll();
	
		$result["rows"] = $row;
		
// 		print "<pre>";
// 		 print_r($result);
// 		print "</pre>";
// 		exit();
		return $result;
	}
	
	//根据学校专业代码查询
	function sp_select_spid($sp_id){
	
		if (!$sp_id) {
			return 0;
		}
	
		$db = $this->getAdapter();
		$where = $db->quoteInto('sp_id = ?', $sp_id);
	
		$row = $this->fetchAll($where)->toArray();
		return $row[0];
	}
	
/********************************************** 删除高校专业 ***********************************************/
	//根据id删除用户信息
	function sp_delete_id($sp_id){
		if(!$sp_id){return 0;}
	
		$db=$this->getAdapter();
		$where = $db->quoteInto('sp_id = ?', $sp_id);
		try
		{
			$rows_affected = $this->delete($where);
			return $rows_affected;
		}catch (Exception $e)
		{
			return 0;
		}
		$rows_affected = $this->delete($where);
		return $rows_affected;
	}
	
	//根据id数组删除用户信息
	function sp_delete_id_array($sp_id)
	{
		if (!$sp_id) {
			return 0;
		}
		$i = 0;
		while ($sp_id['IsDel'][$i])
		{
			$rows_affected = $this->sp_delete_id($sp_id['IsDel'][$i]);
			if (!$rows_affected) {
				return 0;
			}
			$i++;
		}
	
		return $rows_affected;
	}

/********************************************** 修改高校专业 ***********************************************/	
	//学校专业修改
	function sp_update($sp_id,$school_id, $profession_id, $enroll, $grade, $special,$category){
		$set = array (
				'school_id'    		=> $school_id,
				'profession_id'    	=> $profession_id,
				'enroll'    		=> $enroll,
				'grade' 		   	=> $grade,
				'is_special'		=> $special,
				'category'		    => $category,
		);
		$db = $this->getAdapter();
	
		$where = $db->quoteInto('sp_id = ?', $sp_id);
		try{
			$rows_affected = $this->update($set, $where);
			return $rows_affected;
		}catch (Exception $e)
		{
			return 0;
		}
		
	}

}

?> 