<?php
require_once APPLICATION_PATH.'\models\Test.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 21:26
 */
class TestController extends Zend_Controller_Action
{
    //登录界面显示
    public function testAction()
    {
        $number = 0;
        //接受参数
        while ($number<4){
            $checkbox = $this->getRequest()->getParam('checkbox'.$number, '');
            echo"$checkbox";
        $number++;
        }
        /*
        $checkbox1 = $this->getRequest()->getParam('checkbox1', '');
        echo"$checkbox1";
        $checkbox2 = $this->getRequest()->getParam('checkbox2', '');
        echo"$checkbox2";
        $checkbox3 = $this->getRequest()->getParam('checkbox3', '');
        echo"$checkbox3";
        $checkbox0 = $this->getRequest()->getParam('checkbox0', '');
        echo"$checkbox0";*/


    }
    public function addAction()
    {
        $test_name = $this->getRequest()->getParam('test_name', '');
       $test_massage = $this->getRequest()->getParam('test_massage', '');

       $test = new Test();
        $test->add($test_name,$test_massage);

        $this->render('test');
    }
    public function selectAction()
    {
        $job_number = $this->getRequest()->getParam('test', '');

        echo"$job_number";
        $this->render('select');

    }
    public function deleteAction()
    {

    }
    public function changeAction()
    {

    }


}