<?php
	include("userlogin.php");	
	$_REQUEST['username'] = 'hari';
	$_REQUEST['password'] = '123456';
	frame_request();
	$Users = new User_login();

	$Users->save();				



?>
