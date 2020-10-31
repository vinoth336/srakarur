<?php
global $db;
ini_set("memory_limit",-1);
ini_set('max_execution_time', 0);
if(isset($request['mode'])){
	$page_function = array('ListProduct' , 'EditProduct' , 'ChangeStatus' ,'RemoveProduct' , 'SaveProduct');
	$mode = $request['mode'];
	if(in_array($mode,$page_function)){
		$mode();
	}
	exit;
}

function ListProduct(){
	global $db;
	$sql = "select a.id ,   a.productname , a.`status` , b.category_name as 'categoryname' , b.id as 'categoryid' , a.thumbnail, a.price, a.productcode, a.tax  from sra_product as a 
                inner join sra_category as b on b.id = a.category_id and b.status = 1
                order by a.productname  ";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	while($rs = $db->FetchByAssoc($ex)){
		$data[] = $rs;
	}	
	#$category = GetCategory();	
	echo json_encode(array('data' => $data,'no_of_records' => $no_of_records ,'category' => $category),true);
} 

function GetCategory(){
	global $db;
	$sql = "select a.id , a.category_name from sra_category as a where status = 1 order by a.category_name ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	while($rs = $db->FetchByAssoc($ex)){
		$data[$rs['id']] = $rs['category_name'];
	}
	return $data;	
}

function EditProduct(){
	global $db,$request;
	$sql = "select a.id , a.productname , a.`status` , a.category_id, a.thumbnail , a.description, a.productcode,a.price,a.discount_price, a.tax  from sra_product as a where id = ".$request['id']." order by a.productname ;";
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

	$sql = "UPDATE sra_product SET status = '".($request['status'] == 1 ? 1 : 0)."' where id = '".$request['id']."' ";
	$ex = $db->query($sql);
	if($ex)
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
}

function RemoveProduct(){
	global $db , $request;

	if(!check_duplicate($request['id'],'id') && $request['id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	$sql = "DELETE FROM  sra_product where id = '".$request['id']."' ";
	$ex = $db->query($sql);
	$sql = "DELETE FROM  sra_productimages where productid = '".$request['id']."' ";
	$ex1 = $db->query($sql);
	if($ex && $ex1)
		echo json_encode(array('status' => true,'msg' => "REMOVED SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
}
 
function SaveProduct(){
	global $db , $request,$root_directory;
	#if(check_duplicate($request['productname'],'productname') && $request['id'] == '' ){
	#	echo json_encode(array('status' => false,'msg' => "PRODUCT NAME ALREADY AVAILABLE"));
	#	return ;
	#}	

	if(check_duplicateproductcode($request['productcode'],$request['id']) && $request['productcode'] != '' ){
		echo json_encode(array('status' => false,'msg' => "PRODUCT CODE ALREADY AVAILABLE"));
		return ;
	}	
	if(!check_duplicate($request['id'],'id') && $request['id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	if(count($_FILES) == 0 && $request['id'] == ''){
		echo json_encode(array('status' => false,'msg' => "PRODUCT SHOULD HAVE PRODUCT IMAGE"));
		return ;

	}

	if(count($_FILES) > 0){
		foreach($_FILES['filename']['name'] as $key => $flag){

#CROP AND SAVE THE IMAGE
			$ext = pathinfo($_FILES['filename']['name'][$key], PATHINFO_EXTENSION);
			$productname = preg_replace('/[^A-Za-z0-9\-]/','',$request['productname'])."_".date("YmdHis");
			$filename = $root_directory."img/product/".$productname.".".$ext;
			$thumbnail = $root_directory."img/product/thumbnail/".$productname.".".$ext;
			$thumbnail_path = "img/product/thumbnail/".$productname.".".$ext;
			$productimage_path = "img/product/".$productname.".".$ext;

			if(move_uploaded_file($_FILES['filename']['tmp_name'][$key],$filename)){
				system("convert ".$filename." -resize 800x693 ".$filename);		
				system("convert ".$filename."  -resize 190x190 ".$thumbnail);		
			}else {
				die('not uploaded');
			}
			break;
		}

	}
	if(check_duplicate($request['id'],'id') && $request['id'] != '' ){
		
		$sql = "UPDATE sra_product SET productname = '{$request['productname']}', status = '".($request['status'] == 1 ? 1 : 0)."' , category_id = '".$request['categoryname']."' , description = '{$request['description']}', productcode = '{$request['productcode']}' , price = '{$request['price']}', discount_price='{$request['discount_price']}', tax= '{$request['tax']}' where id = '".$request['id']."' ";

				
	}else{
		$sql = "INSERT INTO sra_product (`productname`,`category_id`,`status`,`description`,`thumbnail`,`whodid`,`productcode`,`price`,`discount_price`, `tax`) VALUES ('{$request['productname']}','{$request['categoryname']}','".($request['status'] == 1 ? 1 : 0)."','{$request['description']}','".$thumbnail_path."','".$_SESSION['id']."','{$request['productcode']}','{$request['price']}','{$request['discount_price']}', '{$request['tax']}')";
	}
	$ex = $db->query($sql);
	if($request['id'] == ''){

		$sql = "select id from sra_product order by id desc limit 1 ;";
		$ex2  = $db->query($sql);
		$rs  = $db->FetchByAssoc($ex2);
		$request['id'] = $rs['id'];		
	}
	
	if($productimage_path != ''){
		unlink_productimage($request['id']);
		$sql = "DELETE FROM sra_productimages WHERE productid = '".$request['id']."';";
		$ex3 = $db->query($sql);

		$sql = "INSERT INTO sra_productimages (`productid`,`path`,`order`) VALUES ('".$request['id']."' , '$productimage_path','1'); ";
		$db->query($sql);
		
		$sql = "UPDATE sra_product SET thumbnail = '".$thumbnail_path."'  where id = '".$request['id']."' ";
		$db->query($sql);
	}


	if($ex)
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
	
	
}

function unlink_productimage($productid){
	global $db;
	$sql = "select path from sra_productimages where productid = '$productid' ;";
	$ex = $db->query($sql);
	while($rs = $db->FetchByAssoc($ex)){
		unlink($rs['path']);		
	}
	$sql = "select thumbnail from sra_product id = '$productid'";
	$ex = $db->query($sql);
	$rs = $db->FetchByAssoc($ex);
	if($rs['thumbnail']!='')
		unlink($rs['thumbnail']);
	
}

function check_duplicate($productname,$column){
	global $db;
	$sql = "select productname from sra_product where $column = '$productname' ;";
	$ex = $db->query($sql);
	return $db->NumRows($ex);	
}
function check_duplicateproductcode($productcode,$productid){
	global $db;
	$sql = "select productname , id from sra_product where productcode = '$productcode' ;";
	$ex = $db->query($sql);
	$rs = $db->FetchByAssoc($ex);
	return ( $rs['id'] == $productid || $rs['id'] == '') ? false : true;	
}
?>

