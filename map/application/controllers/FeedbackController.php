<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'\models\Advice.php';
class FeedbackController extends  BaseController
{
	public function adviceviewAction()
	{
		//提取昵称
		session_start();
		$nickname = $_SESSION['loginuser']['nickname'];
		$this->view->nickname = $nickname;
	}
	public function adviceAction() 
	{
		$advicer = $this->getRequest()->getParam('advicer');
		$time = $this->getRequest()->getParam('time');
		$content = $this->getRequest()->getParam('content');
		$advice = new Advice();
		$result = $advice->advice_add($advicer, $time, $content);
		
		if($result==0)
		{
			$this->view->info='发表意见失败，请再试一次';
			$this->view->gourl='/feedback/adviceview';
			$this->forward('info','global');//跳转失败页
		}else{
			$this->view->info='发表意见成功,请到留言墙查看';
			$this->view->gourl='/feedback/adviceview';
			$this->forward('info','global');//跳转成功页
		}
	}
	//留言墙显示
	public function advicelistAction()
	{
		$advice = new Advice();
		$result = $advice->advice_select_limit6();
		$this->view->result=$result;
	}
	
	public function advicelistserveAction()
	{
		
	}
}

?>