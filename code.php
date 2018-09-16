<?php
	//载入验证码类
	require"Captcha.class.php";
	$captcha=new Captcha();//实例化对象
	//生成验证码图片
	$captcha->generate(70,22,5);
?>