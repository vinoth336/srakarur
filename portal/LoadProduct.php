<?php
if($db == ''){
include_once("portal/Engine.php");
include_once("portal/Util.php");
include_once("portal/UsersUtil.php");	
}
global $db;
function LoadPage(){
	global $db;
	$sql = "select a.id  ,   a.productname as 'ProductName' , a.`status` , b.category_name as 'CategoryName' , b.id as 'categoryid' , a.thumbnail as 'Thumbnail' , a.description as 'Description'  from sra_product as a 
		inner join sra_category as b on b.id = a.category_id and b.status = 1 and a.status = 1
		order by b.category_name";
	$ex = $db->query($sql);
	$CategoryName = '';
	$i=0;
	while($rs = $db->FetchByAssoc($ex)){
		$data[$rs['id']] = $rs;
		
		if(!in_array($rs['CategoryName'],$CategoryName))
			$CategoryName[$i++] = $rs['CategoryName'];
	}
	$sql = "select productid , path  from sra_productimages as a order by productid ,`order`;";
	$ex = $db->query($sql);
	while($rs = $db->FetchByAssoc($ex)){
		$productImage[$rs['productid']][] = $rs['path'];
	}

	return array('data' => $data , 'ProductImage' => $productImage ,'CategoryName' => $CategoryName);
}

function SetTemplates(){

	$Rs = LoadPage();

	
	$data = $Rs['data'];
	$ProductImage = $Rs['ProductImage'];
		
	foreach($data as $productid => $content){
		@extract($content);
		 include("HomePageProductTemplate.php");
	}	
	return null;
}
?>
