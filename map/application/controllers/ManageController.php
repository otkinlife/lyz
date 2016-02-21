<?php
require_once 'BaseController.php';
require_once 'FenyeController.php';
require_once APPLICATION_PATH.'\models\Schoolinfo.php';
require_once APPLICATION_PATH.'\models\User.php';
require_once APPLICATION_PATH.'\models\Advice.php';
require_once APPLICATION_PATH.'\models\Professioninfo.php';
require_once APPLICATION_PATH.'\models\Schoolprofession.php';

class ManageController extends BaseController
{
	
//管理员首页界面显示
	public function manageAction()
	{

		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}

		//传值并跳转
		$this->view->loginuser=$loginuser;
		$this->render('manage');
	}
	
	//管理员个人信息界面显示
	public function managepriinfoviewAction()
	{

	}
	
	//更改管理员个人信息
	public function managepriinfoalterAction()
	{

	}
	
	//更改管理员个人信息界面显示
	public function managepriinfoalterviewAction()
	{

	}
/* 	****************************************用户管理**************************************************** */
	
	//用户列表显示
	public function userlistviewAction()
	{
		
	}
	//用户列表显示控制
	public function userlistserveAction()
	{
		
		$result = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		
		$user = new User();
		$result = $user->user_select_limit($offset, $rows);
	
		//将返回值用json编码
		echo json_encode($result);
		exit();
	}
	
	//增加用户
	public function adduserAction()
	{
		
		$username = $this->getRequest()->getParam('username');
		$nickname = $this->getRequest()->getParam('nickname');
		$password = $this->getRequest()->getParam('password1');
		$sex = $this->getRequest()->getParam('sex');
		$email = $this->getRequest()->getParam('email');
		$tel = $this->getRequest()->getParam('tel');
		$qq = $this->getRequest()->getParam('qq');
		$introduction = $this->getRequest()->getParam('info');
	
		$User = new User();
		$result = $User->user_sign($username, $nickname, $password, $sex, $email, $tel, $qq, $introduction);
		
		$result = @$result;
		
		if ($result){
			echo json_encode(array('success'=>true));

		} else {
			echo json_encode(array('msg'=>'添加失败.'));
			
		}		
		exit();
	}
	
	//删除用户
	public function deluserAction()
	{	
		$user_id = intval($_REQUEST['user_id']);
		/* $user_id =	2; */
		$user = new User();
		$result = $user->user_delete($user_id);
		$result = @$result;
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'操作失败.'));
		}
		exit();
		
	}
	
	//更改用户界面显示
	public function updateuserviewAction()
	{
		$user_id = $this->getRequest()->getParam('user_id');
		$User = new User();
		$row = $User->user_select_id($user_id);
		$this->view->row=$row;
	}
	
	//更改用户
	public function updateuserAction()
	{
		$user_id = $this->getRequest()->getParam('user_id');
		$nickname = $this->getRequest()->getParam('nickname');
		$username = $this->getRequest()->getParam('username');	
		$sex = $this->getRequest()->getParam('sex');
		$email = $this->getRequest()->getParam('email');
		$tel = $this->getRequest()->getParam('tel');
		$qq = $this->getRequest()->getParam('qq');
		$introduction = $this->getRequest()->getParam('info');
		$is_manager = $this->getRequest()->getParam('is_manager');

		$User = new User();
		$result = $User->user_update($user_id, $username, $nickname, $sex, $email, $tel, $qq, $introduction, $is_manager);
		
		if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'操作失败.'));
			}
		exit();
	}
	

/* ******************************************学校管理******************************************************* */
	
//高校显示
	public function schoolAction()
	{
		
	}	
//高校管理主界面
	public function schoolserveAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
		$result = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		
		$school = new Schoolinfo();
		$result = $school->school_select_limit($offset, $rows);
		
		//将返回值用json编码
		echo json_encode($result);
		exit();
	}
	
	//查询高校
	public function selectschoolAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
			
		//接收参数
		$info = $this->getRequest()->getParam('schoolinfo');

		//判断参数类型
		if(is_numeric($info)){
			//整型
			$schoolinfo = new Schoolinfo();
			$info = $schoolinfo->school_select_schoolid($info);

			$this->view->info = $info;
			$this->forward('school','manage');
		}else{
			//字符型
			$schoolinfo = new Schoolinfo();
			$info = $schoolinfo->school_select_schoolname($info);
			
			$this->view->info = $info;
			$this->forward('school','manage');
		}
	}
	
	
	//增加高校
	public function addschoolAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
		
		//接收参数
		$school_id = $this->getRequest()->getParam('school_id');
		$school_name = $this->getRequest()->getParam('school_name');
		$found_date = $this->getRequest()->getParam('found_date');
		$school_web = $this->getRequest()->getParam('school_web');
		$post_code = $this->getRequest()->getParam('post_code');
		$school_address = $this->getRequest()->getParam('school_address');
		$office_phone = $this->getRequest()->getParam('office_phone');
		$longitude = $this->getRequest()->getParam('longitude');
		$latitude = $this->getRequest()->getParam('latitude');
		$school_type = $this->getRequest()->getParam('school_type');
		$sex_ratio = $this->getRequest()->getParam('sex_ratio');
		$rank = $this->getRequest()->getParam('rank');
		$environment = $this->getRequest()->getParam('environment');
		$introduction = $this->getRequest()->getParam('introduction');
		
		//调用
		$school = new Schoolinfo();
		$result=$school->school_sign($school_id, $school_name, $found_date, $school_web, $post_code,
				 				$school_address, $office_phone, $longitude, $latitude, $school_type,
				 				$sex_ratio, $rank, $environment, $introduction);

		//传值并跳转
		if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'操作失败.'));
			}
		exit();
	}
	
	//删除高校
	public function delschoolAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
		
		$school_id = intval($_REQUEST['school_id']);
		$school = new Schoolinfo();
		$result = $school->school_delete_id($school_id);
		$result = @$result;
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'操作失败.'));
		}
		exit();
		
	}
	
	
	//更改高校
	public function updateschoolAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
		
		//接收参数
		/* $school_id_old = $this->getRequest()->getParam('school_id_old'); */
		$school_id = $this->getRequest()->getParam('school_id');
		$school_name = $this->getRequest()->getParam('school_name');
		$found_date = $this->getRequest()->getParam('found_date');
		$school_web = $this->getRequest()->getParam('school_web');
		$post_code = $this->getRequest()->getParam('post_code');
		$school_address = $this->getRequest()->getParam('school_address');
		$office_phone = $this->getRequest()->getParam('office_phone');
		$longitude = $this->getRequest()->getParam('longitude');
		$latitude = $this->getRequest()->getParam('latitude');
		$school_type = $this->getRequest()->getParam('school_type');
		$sex_ratio = $this->getRequest()->getParam('sex_ratio');
		$rank = $this->getRequest()->getParam('rank');
		$environment = $this->getRequest()->getParam('environment');
		$introduction = $this->getRequest()->getParam('introduction');
		
		//表调用
		$School = new Schoolinfo();
		$result = $School->school_update($school_id, $school_name, $found_date, $school_web, 
										$post_code, $school_address, $office_phone, $longitude, $latitude,
				 						$school_type, $sex_ratio, $rank, $environment, $introduction);
		//传值并跳转
		if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'操作失败.'));
			}
		exit();
	}
	
	/****************************************学校专业管理**************************************************/
	
	//学校专业显示
	public function spviewAction()
	{
		
	}
	//高校专业管理主界面
	public function spserveAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
		$result = array();
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			
			$schoolprofession = new Schoolprofession();
		
			$result = $schoolprofession->sp_select_bylimit10($offset, $rows);
		//将返回值用json编码
		echo json_encode($result);
		exit();
	}
	
	//查询高校专业
	public function selectspAction()
	{
		//接收参数
		$info = $this->getRequest()->getParam('schoolinfo');
	
		//判断参数类型
		if(is_numeric($info)){
			//整型
			$schoolinfo = new Schoolinfo();
			$info = $schoolinfo->school_select_schoolid($info);
	
			$this->view->info = $info;
			$this->forward('school','manage');
		}else{
			//字符型
			$schoolinfo = new Schoolinfo();
			$info = $schoolinfo->school_select_schoolname($info);
	
			$this->view->info = $info;
			$this->forward('school','manage');
		}
	}
	
	//增加高校专业信息
	public function addspAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
	
		//接收参数
		$school_id = $this->getRequest()->getParam('school_id');
		$profession_id = $this->getRequest()->getParam('profession_id');
		$enroll = $this->getRequest()->getParam('enroll');
		$grade = $this->getRequest()->getParam('grade');
		$special = $this->getRequest()->getParam('special');
		$category = $this->getRequest()->getParam('category');
	
		//调用
		$SP = new Schoolprofession();
		$result=$SP->sp_sign($school_id, $profession_id, $enroll, $grade, $special,$category);
	
		//传值
		if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'操作失败.'));
			}
		exit();
	}
	
	//删除高校专业信息
	public function delspAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
	
		//接收要删除的ID
		$sp_id = intval($_REQUEST['sp_id']);
		//表调用
		$SP = new Schoolprofession();
		$result = $SP->sp_delete_id($sp_id);
	
		//传值并跳转
		if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'操作失败.'));
			}
		exit();
	
	}
	
	//更改高校
	public function updatespAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
	
		//接收参数
		$sp_id = $this->getRequest()->getParam('sp_id');
		$school_id = $this->getRequest()->getParam('school_id');
		$profession_id = $this->getRequest()->getParam('profession_id');
		$enroll = $this->getRequest()->getParam('enroll');
		$grade = $this->getRequest()->getParam('grade');
		$special = $this->getRequest()->getParam('special');
		$category = $this->getRequest()->getParam('category');
	
		//调用
		$SP = new Schoolprofession();
		$result=$SP->sp_update($sp_id,$school_id, $profession_id, $enroll, $grade, $special,$category);
	
		//传值并跳转
		if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'操作失败.'));
			}
		exit();
	}
	
	/****************************************反馈建议管理**************************************************/
	//显示用户的反馈建议
	public function feedbackviewAction()
	{
		
	}
	//显示建议控制
	public function feedbackserveAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
		$result = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		
		$advice = new Advice();
		$result = $advice->advice_select_limit($offset, $rows);
		
		//将返回值用json编码
		echo json_encode($result);
		exit();
		
	}
	
	//删除用户的反馈建议
	public function delfeedbackAction()
	{
		//判断是否管理员
		$loginuser = $this->IsManager();
		if(!$loginuser){
			return ;
		}
	
		//接收要删除的ID
		$advice_id = intval($_REQUEST['advice_id']);
	
		//表调用
		$Advice = new Advice();
		$result=$Advice->advice_delete($advice_id);
	
		//传值并跳转
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'操作失败.'));
		}
		exit();
	}
	
	/* ********************************************专业管理************************************************* */
	
	//专业列表显示
	public function proviewAction()
	{
	
	}
	
	//专业显示控制
	public function proviewserveAction()
	{
		$result = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		
		$professioninfo = new Professioninfo();
		$result = $professioninfo->profession_select_limit($offset, $rows);
	
		//将返回值用json编码
		echo json_encode($result);
		exit();
	}
	public function addprofessionviewAction()
	{
		
	}
	
	//添加专业
	public function addprofessionAction()
	{
		$profession_id = $this->getRequest()->getParam('profession_id');
		$profession_name = $this->getRequest()->getParam('profession_name');
		$profession_type = $this->getRequest()->getParam('profession_type');
		
		/* $profession_id = 1111;
		$profession_name = 1111;
		$profession_type = 1111; */
		$profession = new Professioninfo();
		
		$result = $profession->profession_add($profession_id, $profession_name, $profession_type);
		$result = @$result;
		
		if ($result){
			echo json_encode(array('success'=>true));

		} else {
			echo json_encode(array('msg'=>'添加失败.'));
			
		}		
		exit();
	}
	
	//修改专业
	public function updateprofessionAction()
	{
		/* $up_id = $this->getRequest()->getParam('up_id'); */
		$profession_id = $this->getRequest()->getParam('profession_id');
		$profession_name = $this->getRequest()->getParam('profession_name');
		$profession_type = $this->getRequest()->getParam('profession_type');
		$profession = new Professioninfo();
		$result = $profession->profession_update($profession_id, $profession_name, $profession_type);
		$result = @result;
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'操作失败.'));
		}
		exit();
	}
	
	//删除专业
	public function delprofessionAction()
	{
		$profession_id = intval($_REQUEST['profession_id']);
		$profession = new Professioninfo();
		$result = $profession->profession_delete($profession_id);
		$result = @$result;
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'操作失败.'));
		}
		exit();
	}
	
}
?>