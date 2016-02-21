
<?php

require_once APPLICATION_PATH.'\models\User.php';
require_once APPLICATION_PATH.'\models\Dishes.php';
require_once APPLICATION_PATH.'\models\Order.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 18:36
 */
class BackstageController extends Zend_Controller_Action
{
    public function backstageAction()
{

}
/*-----------------------------------------�û�����----------------------------------------------------------*/

    public function usermanageAction()//��ʾ�û���Ϣ
    {

        $pageNow = isset($_GET['user_pageNow']) ? intval($_GET['user_pageNow']) : 1;//��ȡpageNow

        $user = new User();
        $pageCount = $user->getPageCount();
        $this->view->pC = $pageCount;//������$pageCount���͸�ҳ�棬����ΪpC
        $message = $user->getMessage($pageNow);
        $this->view->message = $message;
        $pageSize = $user->getPages($pageNow);
        $this->view->pageSize = $pageSize;

        $this->render('usermanage');
    }

    public function changeuserAction()//�޸��û�
    {
        $job_number = $this->getRequest()->getParam('id', '');
        $user_name = $this->getRequest()->getParam('user_name', '');
        $user_password = $this->getRequest()->getParam('user_password', '');
        $manager = $this->getRequest()->getParam('manager', '');

        $user = new User();
        $res = $user -> changeuser($job_number,$user_name,$user_password,$manager);
        echo json_encode($res);
        die;
        //$this->usermanageAction();


    }

    public function adduserAction()//����û�
    {
        $user_name = $this->getRequest()->getParam('user_name', '');
        $user_password = $this->getRequest()->getParam('user_password', '');
        $manager = $this->getRequest()->getParam('manager', '');

        $user = new User();
        $user -> adduser($user_name,$user_password,$manager);

        $this->usermanageAction();

    }

    public function deleteuserAction()//ɾ���û�
    {
        $job_number = $this->getRequest()->getParam('id', '');
        $user = new User();
        $res = $user -> deleteuser($job_number);
        echo json_encode($res);
        die;
        //$this->usermanageAction();

    }

/*-----------------------------------------��Ʒ����----------------------------------------------------------*/

    public function dishesmanageAction()//��ʾ��Ʒ��Ϣ
    {
        $pageNow = isset($_GET['dishes_pageNow']) ? intval($_GET['dishes_pageNow']) : 1;//��ȡpageNow

        $dishes = new Dishes();
        $pageCount = $dishes->getPageCount();
        $this->view->pC = $pageCount;//������$pageCount���͸�ҳ�棬����ΪpC
        $message = $dishes->getMessage($pageNow);
        $this->view->message = $message;
        $pageSize = $dishes->getPages($pageNow);
        $this->view->pageSize = $pageSize;

        $this->render('dishesmanage');

    }

    public function adddishAction()//��Ӳ�Ʒ
    {
        $dish_name = $this->getRequest()->getParam('dish_name', '');
        $dish_price = $this->getRequest()->getParam('dish_price', '');
        $dish_remarks = $this->getRequest()->getParam('dish_remarks', '');

        $dishes = new Dishes();
        $dishes -> adddish($dish_name,$dish_price,$dish_remarks);

        $this->dishesmanageAction();

    }

    /*-----------------------------------------ģ������----------------------------------------------------------*/

    public function selectorderAction()//ģ������ δ���
    {
        //  $pageNow = isset($_GET['user_pageNow']) ? intval($_GET['user_pageNow']) : 1;//��ȡpageNow

           //���ܲ���
           $table_id = $this->getRequest()->getParam('table_id', '');
           $order_number = $this->getRequest()->getParam('order_number', '');
           $order_waiter = $this->getRequest()->getParam('order_waiter', '');
           $order_date = $this->getRequest()->getParam('order_date', '');


           $order = new Order();
           $message = $order->selectOrder($table_id,$order_number,$order_waiter,$order_date);
           $this->view->message = $message;

         /*  $pageCount = $order->getPageCount();
           $this->view->pC = $pageCount;//������$pageCount���͸�ҳ�棬����ΪpC
           $message = $order->getMessage($pageNow);
           $this->view->message = $message;
           $pageSize = $order->getPages($pageNow);
           $this->view->pageSize = $pageSize;*/


           $this->render('selectorder');

       }




}