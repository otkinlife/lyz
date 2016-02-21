	//ajax函数部分
	function getXmlHttpObject(){
		
		var xmlHttpRequest;
		//不同的浏览器获取该对象方法不一样
		if(window.ActiveXObject){
			
			xmlHttpRequest=new ActiveXObject("Microsoft.XMLHTTP");		
		}else{
			
			xmlHttpRequest=new XMLHttpRequest();
		}
		return xmlHttpRequest;
	}

	//回调函数
	function chuli(){
		if(myXmlHttpRequest.readyState==4){

			document.getElementById("mynickname").innerHTML = myXmlHttpRequest.responseText;
		}
	}
	//这里写一个函数
	function $(id){
		return document.getElementById(id);
	}
	
	//邮箱验证
	function checkEmail()
	{
		//对电子邮件的验证
		var patten=new RegExp(/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/);
	    if(!patten.test(email.value))
	    {
	    	document.getElementById("myemail").innerHTML = '提示\n\n请输入有效的E_mail！';
	    	return true;
		}else if(email.value.length>30){
			document.getElementById("myemail").innerHTML = '邮箱不能超过30个字符！';
			return true;
		}else{
	    	document.getElementById("myemail").innerHTML = ' ';
			return false;
		}	
	}
	
	var myXmlHttpRequest="";
	//昵称验证
	function checkNickname(){
		
		if(nickname.value==""||nickname.value==null){
			
			document.getElementById("mynickname").innerHTML = '昵称不能为空';
			return true;
		}
		if(nickname.value.length>20){

			document.getElementById("mynickname").innerHTML = "昵称不能超过20个字符！";
			return true;
		}
		
		myXmlHttpRequest=getXmlHttpObject();
		//如何判断创建ok
		if(myXmlHttpRequest){

			var url="/login/getajaxenrollview";
			var data="nickname="+$('nickname').value;
			//打开请求
			myXmlHttpRequest.open("post",url,true);
			//post方式必选
			myXmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			//指定回调函数，处理是函数名
			myXmlHttpRequest.onreadystatechange=chuli;
			
			//真的发送请求，如果是get请求则填入null即可
			//如果是post请求，则填入实际的数据
			myXmlHttpRequest.send(data);
		}
		
		return false;
	}

	//密码验证
	function checkPassword1()
	{	
		if(password1.value=="" || password2.value==null){
			
			document.getElementById("mypassword1").innerHTML = "密码不能为空！";
			return true;
		}else if(password1.value.length>20){
			
			document.getElementById("mypassword1").innerHTML = "密码不能超过20个字符！";
			return true;
		}else{
			
			document.getElementById("mypassword1").innerHTML = "";
			return false;
		}
	}
	//密码验证2
	function checkPassword2()
	{		
		if(password1.value != password2.value){
			document.getElementById("mypassword2").innerHTML = "两次密码输入不相同！";

//			password1.value = "";
//			password2.value = "";
			return true;
		}else{
			
			document.getElementById("mypassword2").innerHTML = " ";
			return false;
		}
	}
	
	//真实姓名验证
	function checkUsername()
	{
		
		if(username.value.length>20)
		{
			document.getElementById("myusername").innerHTML = "真实姓名不能超过20个字符！";
			return true;
		}else{
	    	document.getElementById("myusername").innerHTML = ' ';
	    	return false;
		}

	}
	//qq验证
	function checkQQ()
	{
		var patten=new RegExp(/^[0-9]+$/);		
		if(qq.value.length>11)
		{
		
			document.getElementById("myqq").innerHTML = "qq不能超过11个字符！";
			return true;
		}else if(!patten.test(qq.value)) {

			document.getElementById("myqq").innerHTML = "qq只准是数字！"; 
			return true;
		}else{
	    
	    	document.getElementById("myqq").innerHTML = ' ';
			return false;
		}
	}
	//联系方式验证
	function checkTel()
	{
		var patten=new RegExp(/^[0-9]+$/);
		if(tel.value.length>11)
		{
			document.getElementById("mytel").innerHTML = "联系方式不能超过11个字符！";
			return true;
		}else if(!patten.test(tel.value)) 
		{
			document.getElementById("mytel").innerHTML = "联系方式只准是数字！"; 
			return true;
		}else{
	    	document.getElementById("mytel").innerHTML = ' ';
	    	return false;
		}
	}
	
	//个人简介验证
	function checkInfo()
	{		
		if(info.value.length>100)
		{
			document.getElementById("myinfo").innerHTML = "个人简介不能超过100个字符！";
			return true;
		}else{
	    	document.getElementById("myinfo").innerHTML = ' ';
	    	return false;
		}
	}
	
	//submit验证
	function check()
	{/*
		if(checkNickname() || checkPassword1() || checkPassword2() || checkUsername() || checkEmail() || checkQQ() || checkTel() || checkInfo() )
		{
			alert('注册失败');
			return false;
		}
*/
		document.forms[0].submit();
		return true;
	
	}
