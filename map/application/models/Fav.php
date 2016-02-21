<?php
class Fav extends Zend_Db_Table
{

	protected $_name = 'fav';
	protected $_primary = 'fav_id';

/******************************************* 录入收藏信息 ********************************************************/
	function fav_sign($user_id,$school_id)
	{
		$row = array (
				'user_id'    	=> $user_id,
				'school_id'  => $school_id,
		);
	
		$affected_rows = $this->insert($row);
		return $affected_rows;
	}
/******************************************* 查询收藏信息 ********************************************************/
	function fav_select_userid($user_id){

		$db = $this->getAdapter();
		$sql = "
			select schoolinfo.school_id, school_name, found_date, school_web, post_code,
					school_address, office_phone, longitude, latitude, school_type, sex_ratio,
					rank, environment, introduction
			from schoolinfo,fav
			where fav.school_id = schoolinfo.school_id and
					user_id = $user_id;
				";
		$row = $db->query($sql)->fetchAll();//->toArray();
		return $row;
	}
	

/******************************************* 删除收藏信息 ********************************************************/

}
?> 