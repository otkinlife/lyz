<?php

//初始化控制器，进行数据库的初始化。
class BaseController extends Zend_Controller_Action{

	public  function  init(){

		$url=constant("APPLICATION_PATH").DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini';
		$dbconfig=new Zend_Config_Ini($url,'mysql');

		$db=Zend_Db::factory($dbconfig->db);

		$db->query('set names utf8');
		$db=Zend_Db_Table::setDefaultAdapter($db);

	}
	public function IsManager()
	{
		//传值
		session_start();
		$loginuser=$_SESSION['loginuser'];
	
		//判断是否管理员
		if(!$loginuser['is_manager']){

			$this->view->erro='您不是管理员，请重新登录';
			$this->forward('index','index');
			return false;
		}
		return $loginuser;
	}
	public function passport_key($txt, $encrypt_key) {
		$encrypt_key = md5($encrypt_key);
		$ctr = 0;
		$tmp = '';
		for($i = 0; $i < strlen($txt); $i++) {
			$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
			$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
		}
		return $tmp;
	}
	//解密
	public function passport_decrypt($txt, $key) {
		$txt = $this->passport_key(base64_decode($txt), $key);
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
			$md5 = $txt[$i];
			$tmp .= $txt[++$i] ^ $md5;
		}
		return $tmp;
	}
	
	public function passport_encrypt($txt, $key) {
		srand((double)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
			$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
			$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
		}
	
		return base64_encode($this->passport_key($tmp, $key));
	}
	public function fenye($fenyeurl,$page,$totalnum,$perpage,$rewrite=0){
		$page = max($page,1);
		$totalpage = ceil($totalnum/$perpage);
		$rangepage = 6;
	
		$startpage = max(1,$page - $rangepage);
		$endpage   = min($totalpage,$startpage+$rangepage*2 - 1);
		$startpage = min($startpage,$endpage - $rangepage*2 + 1);
		if($startpage < 1) $startpage = 1;
	
		$fileext = $rewrite ? '.html':'';
		$html = '<ul>';
		$html .= '<li><a href="'.$fenyeurl.'1">首页</a></li>';
		$html .= $page > 1 ? '<li><a href="'.$fenyeurl.($page-1).'">上一页</a></li>':'';
		for($i = $startpage;$i <= $endpage;$i++){
			$html .= '<li><a href="'.$fenyeurl.$i.$fileext.'"'.($page == $i ? ' class="curr"':'').'>'.$i.'</a></li>';
			if($i == $totalpage) break;
		}
		$html .= $page < $totalpage ? '<li><a href="'.$fenyeurl.($page+1).'">下一页</a></li>':'';
		$html .= '<li><a href="'.$fenyeurl.$totalpage.'">末页</a></li>';
		$html .= '</ul>';
	
		return $html;
	}
	public function test($test){
		print '<pre>';
		print_r($test);
		print '</pre>';
		exit();
	}
}