<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'\models\Schoolinfo.php';


class IndexController extends BaseController
{	
	//跳转到登录控制器
    public function indexAction()
    {


		//跳转到登录控制器
		$this->forward('loginview','login');
	}

	//登录成功，显示主页
	public function mainAction()
	{	
		//提取参数
	    session_start();
    	$loginuser=$_SESSION['loginuser'];
    	//$school = new Schoolinfo();
    	//传值
    	$this->view->loginuser=$loginuser;	
		
    	//跳转
    	$this->render('main');
	}
	
	public function mainviewAction()
	{
		//传参
		session_start();
		$loginuser=$_SESSION['loginuser'];
		 
		//表调用
		$school = new Schoolinfo();
		$schoolinfo = $school->school_select_all();
		$num = count($schoolinfo);//返回取出条数
		
		//传值并跳转
		$this->view->loginuser=$loginuser;
		$this->view->num = $num;
		$this->view->schoolinfo = $schoolinfo;
	
		//跳转
		$this->render('mainview');
	}
	

	//总检索
	public function jiansuoAction()
	{
		//传参
		session_start();
		$loginuser=$_SESSION['loginuser'];
		$low = $this->getRequest()->getParam('low');
		$high = $this->getRequest()->getParam('high');
		$enroll = $this->getRequest()->getParam('enroll');
		$school_type = $this->getRequest()->getParam('school_type');
		$school_address = $this->getRequest()->getParam('area');
		$is_special = $this->getRequest()->getParam('is_special');
		$category = $this->getRequest()->getParam('category');
	
		//表调用
		$school = new Schoolinfo();
		$schoolinfo = $school->school_select_jiansuo($low, $high, $enroll, $school_type, $school_address, $is_special, $category);
		$num = count($schoolinfo);//返回取出条数
	
		//传值并跳转
		$this->view->loginuser=$loginuser;
		$this->view->num = $num;
		$this->view->schoolinfo = $schoolinfo;
		$this->view->low = $low;
		$this->view->high = $high;
		$this->view->enroll = $enroll;
		$this->view->school_type = $school_type;
		$this->view->school_address = $school_address;
		$this->view->is_special = $is_special;
		$this->view->category = $category;
		//跳转
		$this->render('mainview');
	}
}

