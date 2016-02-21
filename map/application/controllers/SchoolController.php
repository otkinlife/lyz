<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'\models\Fav.php';
require_once APPLICATION_PATH.'\models\Schoolinfo.php';

//高校控制器（高校查询、高校对比、高校收藏）
class SchoolController extends BaseController
{
	
	//高校查询界面显示
	public function browseschoolviewAction()
	{
		
	}
	
	//高校查询结果显示
	public function schoolviewAction()
	{
	
	}
	
	//高校对比界面查询与显示
	public function contrastschoolviewAction()
	{
		$Iscont=array();
		$Iscont=$this->getRequest()->getParams("Iscont[]");
		$Iscont= $Iscont['Iscont'];
		/* $this->test($Iscont); */
		$school = new Schoolinfo();
		$result = $school->school_select_con($Iscont);
		$this->view->result = $result;
		/* print "<pre>";
		 print_r($result);
		print "</pre>";
		exit(); */
	}
	
//高校收藏界面显示
	public function favschoolviewAction()
	{
		//传参
		session_start();
		
		$loginuser=$_SESSION['loginuser'];
		$user_id = $loginuser['user_id'];
		//表调用
		$fav = new Fav();
		//$school = new Schoolinfo();
		$schoolinfo = $fav->fav_select_userid($user_id);

		//$schoolinfo = $school->school_select_schoolid_array($user_id_array);
		$num = count($schoolinfo);//返回取出条数
		
		//传值并跳转
		$this->view->loginuser=$loginuser;
		$this->view->num = $num;
		$this->view->schoolinfo = $schoolinfo;
		$this->render('favschoolview');
	}
	
	//高校收藏
	public function favschoolAction()
	{
		session_start();
		$user_id = $_SESSION['loginuser']['user_id'];
		$school_id = $this->getRequest()->getParam('schoolid');

		$fav = new Fav();
		$affect_rowset = $fav->fav_sign($user_id, $school_id);
		
		if($affect_rowset==0)
		{
			$this->view->info='收藏高校失败';
			$this->view->gourl='/index/mainview';
			$this->forward('info','global');//跳转失败页
		}else{
			$this->view->info='收藏高校成功';
			$this->view->gourl='/index/mainview';
			$this->forward('info','global');//跳转成功页
		}
	}
	
}
?>