<?php
session_start();
include('Engine.php');
include('Util.php');
global $request;
frame_request();
if(!isset($_SESSION['sra_username'])){
	ob_end_clean();
	if(isset($_REQUEST['mode'])){
		echo json_encode(array('code' => 1501),true);
		exit;
	}else{
		ob_end_clean();
		header("Location: login.php");
		exit;
	}
}

$page=explode("/",$_SERVER['PHP_SELF']);
$page_name=$page[count($page)-1];

$mode           = $request['mode'];


$request['module'] = $request['view'] == '' ? $request['module'] : $request['view'];

$module         = $request['module'];

if(file_exists('module/'.$module)){
	header("Location: dashboard.php");
}else{
	include_once('module/'.$module.'.php');
}


?>



