<?php
class Schoolinfo extends  Zend_Db_Table
{

	protected $_name = 'Schoolinfo';
	protected $_primary = 'school_id';

/************************************** 录入学校信息 *************************************************/
	//学校注册函数
	function school_sign($school_id, $school_name, $found_date, $school_web, $post_code,
				 		 $school_address, $office_phone, $longitude, $latitude, $school_type,
				 		 $sex_ratio, $rank, $environment, $introduction)
	{
		if (!$school_id) {
			return 0;
		}

		$row = array (
				'school_id'    		=> $school_id,
				'school_name'    	=> $school_name,
				'found_date'    	=> $found_date,
				'school_web'    	=> $school_web,
				'post_code'			=> $post_code,
				'school_address'    => $school_address,
				'office_phone'    	=> $office_phone,
				'longitude'     	=> $longitude,
				'latitude' 			=> $latitude,
				'school_type'  		=> $school_type,
				'sex_ratio'			=> $sex_ratio,
				'rank'     			=> $rank,
				'environment'    	=> $environment,
				'introduction'     	=> $introduction,
		);
		try{
			$affected_rows = $this->insert($row);
			return $affected_rows;
		}catch (Exception $e)
		{
			return 0;
		}
		
	}

/*************************************** 学校信息查询函数 *************************************************/
	//查询学校总数
	function school_select_num(){
	
		$db=$this->getAdapter();
		$sql="select count(*) num from schoolinfo";
		$rowset = $db->query($sql)->fetchAll();
		return $rowset[0]['num'];
	}

	//根据学校代码查询
	function school_select_all(){
	
		$row = $this->fetchAll()->toArray();
		return $row;
	}
	
	//总检索
	function school_select_jiansuo($low, $high, $enroll, $school_type, $school_address, $is_special, $category){
		if(!($low || $high || $enroll || $school_type || $school_address || $is_special || $category)){
			$rowset = $this->school_select_all();
			return $rowset;
		}
	
		$a="";
		if($low){ $a = $a. " and grade < $low ";}
		if($high){ $a = $a. " and grade < $high ";}
		if($enroll){ $a = $a. " and enroll = $enroll ";}
		if($category){ $a = $a. " and category = $category ";}
		if($school_type){ $a = $a. " and school_type = '$school_type' ";}
		if($is_special){ $a = $a. " and is_special = $is_special";}
		if($school_address){
			$school_address = "'%".$school_address."%'";
			$a = $a. " and school_address like $school_address";
		}
	
		$db = $this->getAdapter();
		$sql_first="select distinct
					schoolinfo.school_name, schoolinfo.school_web, schoolinfo.school_address,
					schoolinfo.longitude, schoolinfo.latitude, schoolinfo.office_phone,
					professioninfo.profession_name, schoolprofession.sp_id,
					schoolprofession.school_id, schoolprofession.profession_id, schoolprofession.enroll,
					schoolprofession.grade, schoolprofession.is_special, schoolprofession.category
			from
					schoolinfo, professioninfo, schoolprofession
			where
					schoolinfo.school_id = schoolprofession.school_id and
					professioninfo.profession_id = schoolprofession.profession_id ";
		$sql_last = "group by
						schoolinfo.school_name
			  		order by
					schoolprofession.school_id asc, schoolprofession.profession_id asc;";
		$sql = $sql_first.$a.$sql_last;
	
		$rowset = $db->query($sql)->fetchAll();
	
		return $rowset;
	}
	
	//根据四个id去学校数据
	function school_select_con($Iscont)
	{
		$result = array();
		if (!$Iscont) {
			return 0;
		}
		$length = count($Iscont);
		$db=$this->getAdapter();
		for($i=0;$i<$length;$i++)
		{
			$school_id = $Iscont[$i];
			/* echo $school_id; */
			$where = $db->quoteInto('school_id = ?', $school_id);
			$row = $this->fetchAll($where)->toArray();
			$result[$i]=$row["0"];
		}
		return $result; 
		
		
	}
	
	//根据学校代码查询
	function school_select_schoolid($school_id){
	
		if (!$school_id) {
			return 0;
		}
	
		$db = $this->getAdapter();
		$where = $db->quoteInto('school_id = ?', $school_id);
	
		$row = $this->fetchAll($where)->toArray();
		return $row[0];
	}
	
	//根据学校姓名模糊查询
	function school_select_schoolname($school_name){
	
		if (!$school_name) {
			return 0;
		}
		$school_name = '%'.$school_name.'%';
		$db = $this->getAdapter();
	
		$where = $db->quoteInto('school_name like ?', $school_name);
	
		$row = $this->fetchAll($where)->toArray();
		return $row[0];
	}
	
	//分页查询，每页十条
	function school_select_limit($offset,$rows)
	{
		$result = array();
		$db=$this->getAdapter();
		$sql = "select count(*) num from schoolinfo";
		$row = $db->query($sql)->fetchAll();
		$result["total"] = $row[0]['num'];
		/* print "<pre>";
			print_r($result);
		print "</pre>";
		exit(); */
		$sql1 = "select * from schoolinfo limit $offset,$rows";
		$row = $db->query($sql1)->fetchAll();
		$result["rows"] = $row;
		/* print "<pre>";
		 print_r($result);
		print "</pre>";
		exit(); */
		return $result;
	}

/***************************************学校信息删除函数*************************************************/

	//根据id删除学校信息
	function school_delete_id($school_id){
		if (!$school_id) {
				return 0;
			}
			$db = $this->getAdapter();
				$where = $db->quoteInto('school_id = ?', $school_id);
			try{
				$rows_affected = $this->delete($where);
				return $rows_affected;
			}catch (Exception $e)
			{
				return 0;
			}
	}
	
	//根据id数组删除学校信息
	function school_delete_id_array($school_id)
	{
		if (!$school_id) {
			return 0;
		}
		$db = $this->getAdapter();
			$where = $db->quoteInto('school_id = ?', $school_id);
		try{
			$rows_affected = $this->delete($where);
			return $rows_affected;
		}catch (Exception $e)
		{
			return 0;
		}
	}

/*************************************** 学校信息修改函数 *************************************************/
	//修改学校信息
	function school_update( $school_id, $school_name, $found_date, $school_web, $post_code,
			 		 $school_address, $office_phone, $longitude, $latitude, $school_type,
			 		 $sex_ratio, $rank, $environment, $introduction)
	{
		$set = array (
				'school_id'    		=> $school_id,
				'school_name'    	=> $school_name,
				'found_date'    	=> $found_date,
				'school_web'    	=> $school_web,
				'post_code'			=> $post_code,
				'school_address'    => $school_address,
				'office_phone'    	=> $office_phone,
				'longitude'     	=> $longitude,
				'latitude' 			=> $latitude,
				'school_type'  		=> $school_type,
				'sex_ratio'			=> $sex_ratio,
				'rank'     			=> $rank,
				'environment'    	=> $environment,
				'introduction'     	=> $introduction,
		);
		$db = $this->getAdapter();

		$where = $db->quoteInto('school_id = ?', $school_id);
		$rows_affected = $this->update($set, $where);
		
		return $rows_affected;
	}
	
}
?>