<?php
	session_start();
	$_SESSION['re_code']='';
	$type = 'gif';
	$width= 45;
	$height= 20;
	header("Content-type: image/".$type);
	srand((double)microtime()*1000000);
	$randval = randStr(4,"ALL");
	if($type!='gif' && function_exists('imagecreatetruecolor')){
	     $im = @imagecreatetruecolor($width,$height);
	}else{
	     $im = @imagecreate($width,$height);
	}
	     $r = Array(225,211,255,223);
	     $g = Array(225,236,237,215);
	     $b = Array(225,236,166,125);
	
	     $key = rand(0,3);
	 
	     $backColor = ImageColorAllocate($im,$r[$key],$g[$key],$b[$key]);//鑳屾櫙鑹诧紙闅忔満锛�
	     $borderColor = ImageColorAllocate($im, 20, 66, 111);//杈规鑹�
	     $pointColor = ImageColorAllocate($im, 255, 170, 255);//鐐归鑹�
	
	     @imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);//鑳屾櫙浣嶇疆
	     @imagerectangle($im, 0, 0, $width-1, $height-1, $borderColor); //杈规浣嶇疆
	     $stringColor = ImageColorAllocate($im, 255,255,255);
	
	     for($i=0;$i<=100;$i++){
	           $pointX = rand(2,$width-2);
	           $pointY = rand(2,$height-2);
	           @imagesetpixel($im, $pointX, $pointY, $pointColor);
	     }
	
	     @imagestring($im, 3, 5, 1, $randval, $stringColor);
	     $ImageFun='Image'.$type;
	     $ImageFun($im);
	     @ImageDestroy($im);
	     $_SESSION['re_code'] = $randval;
	//浜х敓闅忔満瀛楃涓�
	function randStr($len=6,$format='ALL') {
	           switch($format) {
	                 case 'ALL':
	                 $chars='ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'; break;
	                 case 'CHAR':
	                 $chars='ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz'; break;
	                 case 'NUMBER':
	                 $chars='123456789'; break;
	                 default :
	                 $chars='ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
	                 break;
	           }
	     $string="";
	     while(strlen($string)<$len)
	     $string.=substr($chars,(mt_rand()%strlen($chars)),1);
	     return $string;
	}

 
?>