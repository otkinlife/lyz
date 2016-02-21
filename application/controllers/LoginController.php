<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once APPLICATION_PATH.'\models\User.php';
require_once APPLICATION_PATH.'\controllers\BackstageController.php';
require_once APPLICATION_PATH.'\controllers\OpentableController.php';

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 15:31
 */
class LoginController extends Zend_Controller_Action
{
    //登录界面显示
    public function loginviewAction(){
        $this->render('login');
    }
    //登录控制,登录成功后显示主页，失败后返回登录页面
    public function loginAction()
    {

        //接受参数
        $user_name = $this->getRequest()->getParam('user_name', '');
        $password = $this->getRequest()->getParam('password', '');

        //	echo $user_id."   ".$password;
            //exit();

       //提取要登录的用户的信息
           $user = new User();
           $loginuser = $user->user_login($user_name, $password);
        //var_dump($loginuser[0]['manager']);
        if($loginuser){
            if($loginuser[0]['manager']=="1")//是否为管理员
            {
                $this->forward('backstage','backstage');
                echo "欢迎管理员登录";
            }else{
                $this->forward('opentable','opentable');
                echo "欢迎".$loginuser[0]['job_number']."号用户登录";
            }
        }


    }




}