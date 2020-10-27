<?php
global $db;
include_once("UsersUtil.php");
if(isset($request['mode'])){
	$page_function = array('UpdateProfile','ChangePassword');
	$mode = $request['mode'];
	if(in_array($mode,$page_function)){
		$mode();
	}
}


function UpdateProfile(){
	global $request , $db;
	$name = $request['name'];
	$contact_person = $request['contact_person'];
	$email = $request['email'];
	$phoneno = $request['phoneno'];
	$address = $request['address'];
	$city	= $request['city'];
	$state	= $request['state'];
	$zipcode = $request['zipcode'];
	$gst_no = $request['gst_no'];
	$tin_no	= $request['tin_no'];
			

	if($_SESSION['type'] == 'CUSTOMER'){

		$sql = "UPDATE sra_customer SET customer_name = '$name', contact_person = '$contact_person' , email = '$email' , address = '$address' , city = '$city' , state = '$state' , zipcode = '$zipcode' , gstno = '$gst_no' , tinno = '$tin_no' , whodid = '".$_SESSION['current_user']."' where id = '".$_SESSION['id']."';";
	}else{

		$sql = "UPDATE sra_users SET name = '$name', phoneno = '$phoneno' , email = '$email' , address = '$address' , city = '$city' , state = '$state' , zipcode = '$zipcode' , whodid = '".$_SESSION['current_user']."'  where id = '".$_SESSION['id']."';";
	}

	$ex = $db->query($sql);
	if($ex){
		$msg = array('status' => true , 'msg' => 'UDATED SUCCESSFULLY');
	}else{
		$msg = array('status' => false , 'msg' => 'SOMETHING WENT WRONG, LEASE TRY AGAIN');
	}
	echo json_encode($msg,true);
}



function ChangePassword(){
	global $request,$db;
	if(isset($request['old_password']) && isset($request['new_password'])){


                $id = $_SESSION['current_user'];

                $old_password = $request['old_password'];
                $new_password = $request['new_password'];

                if($old_password == '' || $new_password == ''){
                        echo json_encode(array('status' => false , 'message' => 'Password Is Not Null'),true);
                        exit;

                }
                if(strlen($old_password) < 6  || strlen($new_password)  < 6){
                        echo json_encode(array('status' => false , 'message' => 'PASSWORD LENGTH MINIMUM 6'),true);
                        exit;
                }
                if(strlen($old_password) > 30  || strlen($new_password)  > 30){
                        echo json_encode(array('status' => false , 'message' => 'PASSWORD LENGTH MAXIMUM 30'),true);
                        exit;
                }
                $sql = "select username , password from users where id = $id ;";
                $ex = $db->query($sql);
                $rs = $db->FetchByAssoc($ex);

                $old_password = encrypt_password($rs['username'],$old_password);

                if($rs['password'] == $old_password ){
                        $new_password   = encrypt_password($rs['username'],$new_password);
                        $sql = "update users set password = '$new_password' where id = '$id';";
                        $db->query($sql);
                        $msg = array("status" => true , "message" => "Updated Successfully");
                }else{
                        $msg = array("status" => false , "message" => "Old Password Not Matched");
                }

        }else
                $msg = array("status" => false , "message" => "Invalid Access");

        echo json_encode($msg,true);
        exit;

	

}

 
?>
