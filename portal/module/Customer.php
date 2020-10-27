<?php
global $db;
include('module/SendMail.php');
if(isset($request['mode'])){
	$page_function = array('ListCustomer' , 'EditCustomer' , 'ChangeStatus' ,'RemoveCustomer' , 'SaveCustomer','UpdatePassword');
	$mode = $request['mode'];
	if(in_array($mode,$page_function)){
		$mode();
	}
	exit;
}


function ListCustomer(){
	global $db;
	$sql = "select a.id , a.customer_name , city, phoneno , a.`status`, a.customer_code, a.username  from sra_customer as a 
		order by a.customer_name ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	while($rs = $db->FetchByAssoc($ex)){
		$data[] = $rs;
	}	

	echo json_encode(array('data' => $data,'no_of_records' => $no_of_records),true);
} 

function EditCustomer(){
	global $db,$request;
	$sql = "select * , id as 'customer_id'  from sra_customer as a where id = ".$request['customer_id']." order by a.customer_name ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	$rs = $db->FetchByAssoc($ex);
	$data = $rs;
	echo json_encode(array('data' => $data,'no_of_records' => $no_of_records),true);

}
function UpdatePassword(){
	global $db , $request;
        if(!check_duplicate($request['customer_id']) && $request['customer_id'] != '' ){
                echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
                return ;
	}
        $username = get_username($request['customer_id']);
        include_once("userlogin.php");
        $_REQUEST['username'] = $username;
        $_REQUEST['password'] = '1234567';
        frame_request();
        $Users = new User_login();
        $Users->save();
	#$SendMail = new SendMail();
	#$SendMail->Subject = "Password Reset";
	#$SendMail->Body = file_get_contents('email/reset_content.php');
	#$SendMail->AddAddress('vinoth336@gmail.com');
	#$SendMail->sendmail();
	echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY. <br> New Password is <b>" . $_REQUEST['password'] . "</b>",'password' => $_REQUEST['password']));
}


function ChangeStatus(){
	global $db , $request;

	if(!check_duplicate($request['customer_id']) && $request['customer_id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	$sql = "UPDATE sra_customer SET status = '".($request['status'] == 1 ? 1 : 0)."' where id = '".$request['customer_id']."' ";
	$ex = $db->query($sql);
	if($ex)
	{
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	}
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
	
	
}

function RemoveCustomer(){
	global $db , $request;

	if(!check_duplicate($request['customer_id']) && $request['customer_id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	
	
	$username = get_username($request['customer_id']);	

	$sql = "DELETE FROM users where username = '".$username."' ";
	$ex = $db->query($sql);
	$sql = "DELETE FROM  sra_customer where id = '".$request['customer_id']."' ";
	$ex1 = $db->query($sql);
	if($ex && $ex1)
		echo json_encode(array('status' => true,'msg' => "REMOVED SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
}
 
function SaveCustomer(){
	global $db , $request;

	
	//if($request['username'] == ''){
	//	echo json_encode(array('status' => false,'msg' => "USERNAME SHOULD NOT BE EMPTY"));
	//	return ;
	//
	//}

	if(check_duplicateusername($request['username'],$request['customer_id'])){
		echo json_encode(array('status' => false,'msg' => "USERNAME NAME ALREADY AVAILABLE"));
		return ;
	}	

	if(check_duplicatecustomercode($request['customer_code'],$request['customer_id'])){
		echo json_encode(array('status' => false,'msg' => "CUSTOMER CODE IS ALREADY AVAILABLE"));
		return ;
	}

	if(check_duplicate($request['customer_id']) && $request['customer_id'] != '' ){
		$prv_username = get_username($request['customer_id']);
		$sql = "UPDATE sra_customer SET customer_name = '{$request['customer_name']}',username = '{$request['username']}',customer_code = '{$request['customer_code']}',contact_person = '{$request['contact_person']}',address = '{$request['address']}',zipcode = '{$request['zipcode']}',city = '{$request['city']}',state = '{$request['state']}',phoneno = '{$request['phoneno']}',email = '{$request['email']}',gstno = '{$request['gstno']}',tinno = '{$request['tinno']}', status = '".($request['status'] == 1 ? 1 : 0)."' where id = '".$request['customer_id']."' ";
				
	}else{
		$sql = "INSERT INTO sra_customer (`customer_name`,`username`,`customer_code`,`contact_person`,`address`,`zipcode`,`city`,`state`,`phoneno`,`email`,`gstno`,`tinno`,`status`,`whodid`) VALUES ('{$request['customer_name']}','{$request['username']}','{$request['customer_code']}','{$request['contact_person']}','{$request['address']}','{$request['zipcode']}','{$request['city']}','{$request['state']}','{$request['phoneno']}','{$request['email']}','{$request['gstno']}','{$request['tinno']}','".($request['status'] == 1 ? 1 : 0)."','".$_SESSION['id']."')";
		

	}

	$ex = $db->query($sql);
	if($request['username'] != $prv_username && $prv_username != ''){
		$sql =" UPDATE users SET username = '{$request['username']}' where username = '$prv_username' ;";
		$db->query($sql);
	}
	if(!check_duplicateusername($request['username'],$request['customer_id']) && $request['customer_id'] == ''){
		include_once("userlogin.php");
		$_REQUEST['username'] = $request['username'];
		$_REQUEST['password'] = '123456';
		$_REQUEST['type']     = 'CUSTOMER';
		frame_request();
		$Users = new User_login();
		$Users->save();

	}
	if($ex)
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
	
	
}

function get_username($userid){
	global $db;
	$sql = "select username from sra_customer as sc where sc.id = '$userid' ;";
	$ex = $db->query($sql);
        $rs = $db->FetchByAssoc($ex);
	return $rs['username'];
}

function check_duplicate($userid){
	global $db;
	$sql = "select id from sra_customer as sc  where sc.id = '$userid' ;";
	$ex = $db->query($sql);
        $rs = $db->FetchByAssoc($ex);
        return $rs['id'] ? true : false;
}


function check_duplicateusername($username,$userid){
	global $db;
	$sql = "select u.username , sc.id from users as u
		inner join sra_customer as sc on sc.username = u.username 
		where u.username = '$username'
		 ;";
	$ex = $db->query($sql);
        $rs = $db->FetchByAssoc($ex);

	$sql = "select u.username , sc.id from users as u
		inner join sra_users as sc on sc.username = u.username 
		where u.username = '$username'
		 ;";
	$ex = $db->query($sql);
	if($db->NumRows($ex))
		return true;
        return ( ( $rs['id'] == $userid ) || $rs['id'] == '') ? false : true;
}
function check_duplicatecustomercode($customer_code,$userid){
        global $db;
        $sql = "select customer_code , id from sra_customer where customer_code = '$customer_code' and customer_code != ''  limit 1;";
        $ex = $db->query($sql);
        $rs = $db->FetchByAssoc($ex);
        return ( $rs['id'] == $userid || $rs['id'] == '') ? false : true;
}



?>
