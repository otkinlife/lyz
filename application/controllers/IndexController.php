<?php



class IndexController extends Zend_Controller_Action
{
     //��ʼ������ֵ������
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //��ת����¼������
        $this->forward('loginview','login');
    }






}

