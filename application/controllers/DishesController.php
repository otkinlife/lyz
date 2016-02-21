<?php
require_once APPLICATION_PATH.'\models\Dishes.php';
require_once APPLICATION_PATH.'\models\Order_dishes.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/23
 * Time: 14:43
 */
class DishesController extends  Zend_Controller_Action
{

    public function dishesAction()//显示菜品信息
    {
        $pageNow = isset($_GET['order_pageNow']) ? intval($_GET['order_pageNow']) : 1;//获取pageNow

        $dishes = new Dishes();
        $pageCount = $dishes->getPageCount();
        $this->view->pC = $pageCount;//将变量$pageCount发送给页面，名字为pC
        $message = $dishes->getMessage($pageNow);
        $this->view->message = $message;
        $pageSize = $dishes->getPages($pageNow);
        $this->view->pageSize = $pageSize;
    }
    public function orderdishesAction()//点菜部分，还没有做完，等开桌数据库做完在进行
    {
        $dishes = new Dishes();
        $rowCount = $dishes->getRowCount();
        $row = 0;

        while($row<$rowCount){
            $r[$row] = $this->getRequest()->getParam($row, '');
            $row++;
        }
        //echo"$rowCount";
        /*
        $r[0] = $this->getRequest()->getParam('0', '');
        $r[1] = $this->getRequest()->getParam('1', '');
        $r[2] = $this->getRequest()->getParam('2', '');
        $r[3] = $this->getRequest()->getParam('3', '');
        $r[4] = $this->getRequest()->getParam('4', '');
        $r[5] = $this->getRequest()->getParam('5', '');*/
        var_dump($r);

    }

}