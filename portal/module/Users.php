<?php
global $db;
if(isset($request['mode'])){
	$page_function = array('ListUsers' , 'EditUsers' , 'ChangeStatus' ,'RemoveUsers' , 'SaveUsers','UpdatePassword');
	$mode = $request['mode'];
	if(in_array($mode,$page_function)){
		$mode();
	}
	exit;
}


function ListUsers(){
	global $db;
	$sql = "select a.id , a.name , city, u.type as 'rolename', phoneno , a.`status`  from sra_users as a 
		inner join users as u on u.username = a.username
		order by a.username ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	while($rs = $db->FetchByAssoc($ex)){
		$data[] = $rs;
	}	

	echo json_encode(array('data' => $data,'no_of_records' => $no_of_records),true);
} 

function EditUsers(){
	global $db,$request;
	$sql = "select * , a.id as 'user_id' , type as 'rolename'  from sra_users as a
		inner join users as u on u.username = a.username
		 where a.id = ".$request['user_id']." order by a.username ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	$rs = $db->FetchByAssoc($ex);
	$data = $rs;
	echo json_encode(array('data' => $data,'no_of_records' => $no_of_records),true);

}

function UpdatePassword(){
	global $db , $request;
	if(!check_duplicate($request['user_id']) && $request['user_id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}
	$username = get_username($request['user_id']);		
	include_once("userlogin.php");
	$_REQUEST['username'] = $username;
	$_REQUEST['password'] = '1234567';
	frame_request();
	$Users = new User_login();
	$Users->save();
	echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY" ,'password' => $_REQUEST['password']));
}

function ChangeStatus(){
	global $db , $request;

	if(!check_duplicate($request['user_id']) && $request['user_id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	$sql = "UPDATE sra_users SET status = '".($request['status'] == 1 ? 1 : 0)."' where id = '".$request['user_id']."' ";
	$ex = $db->query($sql);
	if($ex)
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
	
	
}

function RemoveUsers(){
	global $db , $request;

	if(!check_duplicate($request['user_id']) && $request['user_id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	
	
	$username = get_username($request['user_id']);	

	$sql = "DELETE FROM users where username = '".$username."' ";
	$ex = $db->query($sql);
	$sql = "DELETE FROM  sra_users where id = '".$request['user_id']."' ";
	$ex1 = $db->query($sql);
	if($ex && $ex1)
		echo json_encode(array('status' => true,'msg' => "REMOVED SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
}
 
function SaveUsers(){
	global $db , $request;

	if($request['username'] == ''){
		echo json_encode(array('status' => false,'msg' => "USERNAME SHOULD NOT BE EMPTY"));
		return ;
	
	}
	if(check_duplicateusername($request['username'],$request['user_id'])){
		echo json_encode(array('status' => false,'msg' => "USERNAME NAME ALREADY AVAILABLE"));
		return ;
	}	


	if(check_duplicate($request['user_id']) && $request['user_id'] != '' ){
		$prv_username = get_username($request['user_id']);
		$sql = "UPDATE sra_users SET username = '{$request['username']}',name = '{$request['name']}',address = '{$request['address']}',zipcode = '{$request['zipcode']}',city = '{$request['city']}',state = '{$request['state']}',phoneno = '{$request['phoneno']}',email = '{$request['email']}', status = '".($request['status'] == 1 ? 1 : 0)."' where id = '".$request['user_id']."' ";
				
	}else{
		$sql = "INSERT INTO sra_users (`username`,`name`,`address`,`zipcode`,`city`,`state`,`phoneno`,`email`,`status`,`whodid`) VALUES ('{$request['username']}','{$request['name']}','{$request['address']}','{$request['zipcode']}','{$request['city']}','{$request['state']}','{$request['phoneno']}','{$request['email']}','".($request['status'] == 1 ? 1 : 0)."','".$_SESSION['id']."')";
		

	}
	$ex = $db->query($sql);
	if($request['username'] != $prv_username && $prv_username != ''){
		$sql =" UPDATE users SET username = '{$request['username']}' , type = '{$request['rolename']}'  where username = '$prv_username' ;";
		$db->query($sql);
	}
	if($request['user_id'] != ''){	
		$sql =" UPDATE users SET type = '{$request['rolename']}'  where username = '{$request['username']}' ;";
		$db->query($sql);
	}
	if(!check_duplicateusername($request['username'],$request['user_id']) && $request['user_id'] == ''){
		include_once("userlogin.php");
		$_REQUEST['username'] = $request['username'];
		$_REQUEST['password'] = '123456';
		$_REQUEST['type']     = $request['rolename'];
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
	$sql = "select username from sra_users as sc where sc.id = '$userid' ;";
	$ex = $db->query($sql);
        $rs = $db->FetchByAssoc($ex);
	return $rs['username'];
}

function check_duplicate($userid){
	global $db;
	$sql = "select id from sra_users as sc  where sc.id = '$userid' ;";
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
        if($db->NumRows($ex))
                return true;


	$sql = "select u.username , sc.id from users as u
		inner join sra_users as sc on sc.username = u.username 
		where u.username = '$username'
		 ;";
	$ex = $db->query($sql);
        $rs = $db->FetchByAssoc($ex);

        return ( ( $rs['id'] == $userid ) || $rs['id'] == '') ? false : true;
}



?>
