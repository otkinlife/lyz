<?php



class IndexController extends Zend_Controller_Action
{
     //初始化（初值）函数
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //跳转到登录控制器
        $this->forward('loginview','login');
    }






}

