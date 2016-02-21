<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'\models\User.php';
//require_once 'passport.php';

//登录控制器（登录、退出登录、注册、忘记密码）
class LoginController extends BaseController
{
	//登录界面显示
	public function loginviewAction()
	{
		$this->render('login');
	}
	
	//登录控制,登录成功后显示主页，失败后返回登录页面
	public function loginAction()
	{
		//接受参数
		$Username = $this->getRequest()->getParam('username','');
		$Password = $this->getRequest()->getParam('password','');
		$code = strtolower($this->getRequest()->getParam('yzm'));
	/* 	echo $Username;
		exit(); */
		session_start();
		$re_code = strtolower($_SESSION["re_code"]);

		//验证验证码是否输入正确
		if($code != $re_code)
		{
			$this->view->erro="<font color='red'>验证码错误</font>";
			$this->forward('index','index');
			return ;
		}
		
		//提取要登录的用户的信息
		$user = new User();
		$loginuser = $user->user_login($Username, $Password);

		//验证用户的帐号密码是否输入正确
			if($loginuser)
		{
			//用户成功登录后，将用户的信息与登录的时间存入到session中。
			session_start();
			$_SESSION['loginuser'] = $loginuser[0];
			date_default_timezone_set('PRC');
			$nowtime = date("Y-m-d H:i:s" );
			$_SESSION['loginuser']['nowtime'] = $nowtime;

			//判断是否管理员
			if($_SESSION['loginuser']['is_manager']){

				//跳转到首页
				$this->view->gourl = '/manage/manage';
				$this->forward('goto','global');//登录成功跳转到管理员首页
					
				return ;
			}else{
				
				//跳转到首页
				$this->view->gourl = '/index/main';
				$this->forward('goto','global');//登录成功跳转到用户首页
					
				return ;
			}
		}
		//登录失败，跳转到登录页
		$this->view->erro='用户名或密码错误';
		$this->forward('index','index');
// 		$this->view->gourl = '/index/mainview';
// 		$this->forward('goto','global');//登录成功跳转到用户首页
// 		$this->view->gourl = '/manage/manage';
// 		$this->forward('goto','global');//登录成功跳转到管理员首页
	}
	
	
	//退出登录(跳转至登录)
	public function logoutAction()
	{
		$this->render('login');
	}
			
	//显示注册界面
	public function enrollviewAction()
	{
	
		$this->render('enroll');
	}

	//注册
	public function enrollAction()
	{
		//接受参数
		$username=$this->getRequest()->getParam('username');
		$nickname=$this->getRequest()->getParam('nickname');
		$password=$this->getRequest()->getParam('password1');
		$sex=$this->getRequest()->getParam('sex');
		$email=$this->getRequest()->getParam('email');
		$tel=$this->getRequest()->getParam('tel');
		$qq=$this->getRequest()->getParam('qq');
		$introduction=$this->getRequest()->getParam('introduction');
		
		//调用注册函数
		$user = new User();
		$sign = $user->user_sign($username, $nickname, $password, $sex, $email, $tel, $qq, $introduction);

		//注册用户
		if($sign==0)
		{
			$this->view->info='注册用户失败';
			$this->view->gourl='/index/index';
			$this->forward('info','global');//跳转失败页
		}else{
			$this->view->info='注册用户成功';
			$this->view->gourl='/index/index';
			$this->forward('info','global');//跳转成功页
		}
	}
	
	//获取ajax，为注册页提供服务。
	public function getajaxenrollviewAction(){
		
		//接收参数
		$nickname=$this->getRequest()->getParam('nickname');

		//函数调用
		$user = new User();
		$where = $user->getAdapter()->quoteInto('nickname = ?', $nickname);
		$info = $user->fetchAll($where)->toArray();
		
		//传值到getajax页面
		if($info){
			$this->view->info="抱歉，该昵称已被注册";
		}else{
			$this->view->info="恭喜！该昵称可以注册";
		}
	
		$this->render('getajax');
		
	}
	
	//忘记密码显示页
	/* public function  forgetpasswordviewAction()
	{
		$this->render('forgetpassword');
	} */
	
	//忘记密码控制（发送邮件）
	public function forgetpasswordAction()
	{
		//接受参数
		$email=$this->getRequest()->getParam('email');
		
		//对接收到的邮箱进行加密
		$md5email=passport_encrypt($email, 5371);
		
		//发送邮件
		$mail_server_config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','mail');
		$init_mail = new Zend_Mail_Transport_Smtp($mail_server_config->smtp->server,
				$mail_server_config->smtp->params->toArray());
		Zend_Mail::setDefaultTransport($init_mail);

		//以下是发送邮件的过程
		$mail = new Zend_Mail();
		$result = $mail->addTo($email)   //这个是收件人的电邮地址
		->setFrom($mail_server_config->smtp->params->username)  //这个是发件人的电邮地址，也就是你电邮账户
		->setSubject('忘记密码') //这个是邮件的主旨
		->setBodyText("点击本地址来修改密码： http://map.com:8080/login/alterpasswordview?aaa=$md5email"); //邮件主体
				
		try
		{
			$mail->send();
			$w = '邮件发送成功';
			$this->view->w=$w;
		}
		catch(Zend_Mail_Exception $e)
		{
			$w = $e->getMessage();
			$this->view->w=$w;
		}
		$this->render('login');
	}

	//修改密码显示页
	public function alterpasswordviewAction()
	{
		//接收参数
		$user_email = $this->_request->get('aaa');
		
		//参数解密
		$user_email = passport_decrypt($user_email, 5371);
		
		//跳转
		$this->view->email = $user_email;
		$this->render('alterpassword');
	}
	
	//修改密码修改页
	public function alterpasswordAction()
	{
		//接收参数
		$password=$this->getRequest()->getParam('password1');
		$email=$this->getRequest()->getParam('email');	
		
		
		//调用修改密码的函数
		$user = new User();
		$row = $user->user_alterpassword_email($email, $password);
		
		//判断并跳转
		if ($row) {
			$this->view->info='修改密码成功';
			$this->view->gourl='/index/index';
			$this->forward('info','global');
		}else{
			$this->view->info='修改密码失败';
			$this->view->gourl='/index/index';
			$this->forward('info','global');
		}
	}
}
?>