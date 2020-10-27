<?php
global $db;
if(isset($request['mode'])){
	$page_function = array('ListCategory' , 'EditCategory' , 'ChangeStatus' ,'RemoveCategory' , 'SaveCategory');
	$mode = $request['mode'];
	if(in_array($mode,$page_function)){
		$mode();
	}
	exit;
}


function ListCategory(){
	global $db;
	$sql = "select a.id , a.category_name , a.`status`  from sra_category as a order by a.category_name ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	while($rs = $db->FetchByAssoc($ex)){
		$data[] = $rs;
	}	

	echo json_encode(array('data' => $data,'no_of_records' => $no_of_records),true);
} 

function EditCategory(){
	global $db,$request;
	$sql = "select a.id , a.category_name , a.`status`  from sra_category as a where id = ".$request['id']." order by a.category_name ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	$rs = $db->FetchByAssoc($ex);
	$data = $rs;
	echo json_encode(array('data' => $data,'no_of_records' => $no_of_records),true);

}

function ChangeStatus(){
	global $db , $request;

	if(!check_duplicate($request['id'],'id') && $request['id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	$sql = "UPDATE sra_category SET status = '".($request['status'] == 1 ? 1 : 0)."' where id = '".$request['id']."' ";
	$ex = $db->query($sql);
	if($ex)
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
	
	
}

function RemoveCategory(){
	global $db , $request;

	if(!check_duplicate($request['id'],'id') && $request['id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	$sql = "DELETE FROM  sra_product where category_id = '".$request['id']."' ";
	$ex = $db->query($sql);
	$sql = "DELETE FROM  sra_category where id = '".$request['id']."' ";
	$ex1 = $db->query($sql);
	if($ex && $ex1)
		echo json_encode(array('status' => true,'msg' => "REMOVED SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
}
 
function SaveCategory(){
	global $db , $request;
	if(check_duplicate($request['category_name'],'category_name') && $request['id'] == '' ){
		echo json_encode(array('status' => false,'msg' => "CATEGORY NAME ALREADY AVAILABLE"));
		return ;
	}	

	if(!check_duplicate($request['id'],'id') && $request['id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	if(check_duplicate($request['id'],'id') && $request['id'] != '' ){
		$sql = "UPDATE sra_category SET category_name = '{$request['category_name']}', status = '".($request['status'] == 1 ? 1 : 0)."' where id = '".$request['id']."' ";
				
	}else{
		$sql = "INSERT INTO sra_category (`category_name`,`status`,`whodid`) VALUES ('{$request['category_name']}','".($request['status'] == 1 ? 1 : 0)."','".$_SESSION['id']."')";
	}	
	
	$ex = $db->query($sql);
	if($ex)
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
	
	
}


function check_duplicate($category_name,$column){
	global $db;
	$sql = "select category_name from sra_category where $column = '$category_name' ;";
	$ex = $db->query($sql);
	return $db->NumRows($ex);	
}
?>
