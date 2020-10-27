<?php
global $db;
if(isset($request['mode'])){
	$page_function = array('PurchaseOrderList', 'GetPurchaseOrderList' , 'EditCategory' , 'ChangeStatus' ,'RemovePurchaseOrder' , 'SavePurchaseOrder','PurchaseOrderDetail');
	$mode = $request['mode'];
	if(in_array($mode,$page_function)){
		$mode();
	}
	exit;
}

function PurchaseOrderList(){
	global $db;

	$HeaderInfo = PurchaseOrderColumns();
	$PurchaseOrderList = GetPurchaseOrderList();
	$return = array_merge($HeaderInfo,$PurchaseOrderList);
	echo json_encode($return,true);
}

function GetPurchaseOrderList(){
	global $db;
	$wh = ListQueryCondition();
	$sql = "select
		sra_purchaseorder.id as 'purchaseorderid',
		sra_purchaseorder.po_code,
		sra_po_orderstatus.status,
		sra_customer.customer_name,
		sra_customer.customer_code,
		sra_purchaseorderitem.no_items,
		sra_purchaseorderitem.qty,
		sra_purchaseorder.created_on,
		sra_purchaseorder.order_status,
		if(po_whodid.id , po_whodid.customer_name , sra_users.name ) as 'whodid',
			sra_purchaseorder.`type`
				from sra_purchaseorder 
				inner join 
				(
					select
					 count(sra_purchaseorderitem.purchasedorder_id) as 'no_items',
					 sum(sra_purchaseorderitem.qty) as 'qty',
					 sra_purchaseorderitem.purchasedorder_id
					 from 
					 sra_purchaseorderitem
					 group by sra_purchaseorderitem.purchasedorder_id	
				) sra_purchaseorderitem on sra_purchaseorderitem.purchasedorder_id = sra_purchaseorder.id
				inner join sra_customer on sra_customer.id =  sra_purchaseorder.customerid
				inner join sra_po_orderstatus on sra_po_orderstatus.id = sra_purchaseorder.order_status
				left join sra_customer as po_whodid on po_whodid.id =  sra_purchaseorder.whodid
				left join sra_users on sra_users.id = sra_purchaseorder.whodid
				where
					".implode(" and ",$wh)."
		";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex); 
	while($rs = $db->FetchByAssoc($ex)){
		$rs['qty'] = number_format($rs['qty'],0);
		$data[] = $rs;
	}	
	return array('data' => $data , 'no_of_records' => $no_of_records);
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

function GetCustomerList($customer=''){
	global $db,$request;
	
	$where = '';
	if($customer != ''){
		$where = " where sra_customer.id = '$customer'";
	}

	$sql = "select
		sra_customer.id,
		sra_customer.customer_name,
		sra_customer.customer_code
			from 
			sra_customer 
			$where
			order by 
			sra_customer.customer_name asc;
	";
	$ex = $db->query($sql);
	$no_of_records = $db->NumRows($ex);
	while($rs  = $db->FetchByAssoc($ex)){
		$data[] = array('id' => $rs['id'] , 'customername' =>  $rs['customer_name']." (".$rs['customer_code'].") ");
	}
	return	 $data;

}

function GetOrderStatus($order=''){
        global $db,$request;
	if($order != ''){
		$where = " where id = '$order' ";
	}
        $sql = "select id , status  from sra_po_orderstatus $where order by status ;";
        $ex  = $db->query($sql);
        $no_of_records = $db->NumRows($ex);
        while($rs = $db->FetchByAssoc($ex)){
                $data[] = $rs;
        }
        return $data;

}


function ChangeStatus(){
	global $db , $request;

	if(!check_duplicate($request['purchaseorderid'],'id') && $request['purchaseorderid'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	
        $sql = "select a.id , status  from sra_po_orderstatus as a where a.id = '{$request['update_po_order_status']}'  ;";
        $ex  = $db->query($sql);
        $no_of_records = $db->NumRows($ex);
	if($no_of_records == 0){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}

	$sql = "UPDATE sra_purchaseorder SET order_status = '".$request['update_po_order_status']."' where id = '".$request['purchaseorderid']."' ";
	$ex = $db->query($sql);
	if($ex)
		echo json_encode(array('status' => true,'msg' => "UPDATE SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
	
	
}

function RemovePurchaseOrder(){
	global $db , $request;

	if(!check_duplicate($request['id'],'id') && $request['id'] != '' ){
		echo json_encode(array('status' => false,'msg' => "INVALID ACCESS"));
		return ;
	}	

	$sql = "DELETE FROM  sra_purchaseorderitem where purchasedorder_id = '".$request['id']."' ";
	$ex = $db->query($sql);
	$sql = "DELETE FROM  sra_purchaseorder where id = '".$request['id']."' ";
	$ex1 = $db->query($sql);
	if($ex && $ex1)
		echo json_encode(array('status' => true,'msg' => "REMOVED SUCCESSFULLY"));
	else
		echo json_encode(array('status' => true,'msg' => "SOMETHING WENT WRONG"));
		
	return ;	
}
 
function SavePurchaseOrder(){
	global $db , $request;
	$PurchasedItem = json_decode($request['PurchasedItem'],true);
	$purchaseorderid = $request['purchaseorderid'];


	if(count($PurchasedItem) <= 0){
		echo json_encode(array('status' => false,'msg' => 'PLEASE SELECT PRODUCT'),true);
		exit;
	}
	$selected_products = array_keys($PurchasedItem);
	$NoofValidProducts = CheckRequestProductsAreValid($selected_products);
	if($NoofValidProducts != count($PurchasedItem)){
		echo json_encode(array('status' => false,'msg' => 'INVALID ACCESS'),true);
		exit;
	}	


	if($_SESSION['type'] == 'CUSTOMER'){
		$customer_id = $_SESSION['id'];		
	}else
		$customer_id = $request['customer'];
	
	if($customer_id == '')
	{
		echo json_encode(array('status' => false,'msg' => 'Please Select Customer'),true);
		exit;
	}	
	//CHECK IS VALID CUSTOMER ARE NOT
	$customer = GetCustomerList($customer_id);
	if(count($customer) == 0){
		echo json_encode(array('status' => false,'msg' => 'Invalid Customer'),true);
		exit;
	}		
		
	$request['order_status'] = preg_replace('/[^0-9]/', '', $request['order_status']);
	$order_status = 1;
	
	if($request['order_status'] != ''){
		$order_status = $request['order_status'];	
		//CHECK IS ORDER STATUS IS VALID ONE
		$isValidOrderStatus = GetOrderStatus($order_status);
		if(count($isValidOrderStatus) == 0){
			echo json_encode(array('status' => false,'msg' => 'Invalid Order Status'),true);
			exit;
		}
	}	

	$is_not_new = 1;
	if($purchaseorderid == '' ){
		$po_code	= GetPoCode();	
		$new_po_code = $po_code + 1;
		$sql = "INSERT INTO sra_purchaseorder(`po_code`,`customerid`,`order_status`,`whodid`,`type`,`created_on`) VALUES ('PO".$po_code."','$customer_id','$order_status','{$_SESSION['id']}','{$_SESSION['type']}',NOW());"; 
		$db->query($sql);
		$purchaseorderid = GetPurchaseOrderId();
		$is_not_new = 0;
		UpdatePoCode($new_po_code);
	}
	
	if(!$is_not_new){
		$sql = "DELETE FROM sra_purchaseorderitem where purchasedorder_id = '$purchaseorderid';";
		$db->query($sql);
	}
	


	foreach($PurchasedItem as $productid => $orderinfo){
		$sql = "INSERT INTO sra_purchaseorderitem (`purchasedorder_id`,`product_id`,`qty`) VALUES ('$purchaseorderid','$productid','{$orderinfo['qty']}');";	
		$db->query($sql);
	}	
	
	echo json_encode(array('status' => true,'msg' => "ADDED SUCCESSFULLY"));
	
}

function CheckRequestProductsAreValid($productid){
	global $db;
	$sql = "select count(id) as 'count' from sra_product where id in (".implode(',',$productid).");";
	$ex = $db->query($sql);
	$rs  = $db->FetchByAssoc($ex);
	return $rs['count'];	
}

function GetPoCode(){
	global $db;
	$sql = "select po_code from po_code_generator ";
	$ex  = $db->query($sql);
	$rs  = $db->FetchByAssoc($ex);
	$po_code = $rs['po_code'];
	return $po_code;	
}

function UpdatePoCode($new_po_code){
	global $db;
	$sql = "UPDATE po_code_generator SET `po_code` = '$new_po_code';";
	$db->query($sql);	
}

function GetPurchaseOrderId(){
	global $db;
	$sql = "select id from sra_purchaseorder order by id desc limit 1;";
	$ex  = $db->query($sql);
	$rs  = $db->FetchByAssoc($ex);
	return $rs['id'];	
	
}

function check_duplicate($purchaseorderid,$column){
	global $db;
	$sql = "select id from sra_purchaseorder where $column = '$purchaseorderid' ;";
	$ex = $db->query($sql);
	return $db->NumRows($ex);	
}

function ListQueryCondition(){
	global $request;
	
	if($request['date'] == ''){
		$request['date'] = date("01/m/Y")."-".date("d/m/Y");
	}

	if($request['date'] != ''){
		$temp = explode(" - ",$request['date']);
		$wh[] = " date(sra_purchaseorder.created_on) between '".date("Y-m-d",strtotime(str_replace("/",'-',$temp[0])))."' and '".date("Y-m-d",strtotime(str_replace("/",'-',$temp[1])))."' ";	
	}

	if($request['order_status'] != ''){
		$wh[]  = " sra_purchaseorder.order_status = '{$request['order_status']}' ";
	}

	if($_SESSION['type'] == 'CUSTOMER'){
		$request['customer'] = $_SESSION['id'];
	}
	
	if($request['customer'] != ''){
		$wh[]  = " sra_purchaseorder.customerid = '{$request['customer']}' ";
	}

	
	if($request['user'] != ''){
		$wh[]  = " sra_purchaseorder.whodid = '{$request['user']}' ";
	}

	return $wh;
}

function PurchaseOrderColumns(){

	if($_SESSION['type'] == 'CUSTOMER'){
		$Header  = array('po_code' => 'PO CODE','no_items' => 'NO OF ITEMS' , 'qty' => 'QTY', 'status' => 'ORDER STATUS', 'created_on' => "CREATED ON");
		$column_format  = array('po_code' => 's','no_items' => 'n' , 'qty' => 'n', 'status' => 's', 'created_on' => "d");
	}else{

		$Header  = array('po_code' => 'PO CODE','customer_name' => 'CUSTOMER NAME', 'customer_code' => 'CODE','no_items' => 'NO OF ITEMS' , 'qty' => 'QTY', 'status' => 'ORDER STATUS', 'created_on' => "CREATED ON");
		$column_format  = array('po_code' => 's','no_items' => 'n' , 'qty' => 'n', 'status' => 's', 'created_on' => "d",'customer_name' => 's','customer_code' => 's');
	}
	
	return array('column_format' => $column_format , 'Header' => $Header);

}

function PurchaseOrderDetail(){
	global $db,$request;


	$sql = "select
		a.po_code,
		a.customerid,
		a.order_status,
		date(a.created_on) as 'created_on',
		b.customer_name,
		b.address,
		b.zipcode,
		b.city,
		b.state,
		b.phoneno,
		b.email
			from sra_purchaseorder as a
			inner join sra_customer as b on b.id = a.customerid
			where
				a.id = '{$request['purchaseorderid']}';
			";
	$ex = $db->query($sql);
	$purchaseInfo['info'] = $db->FetchByAssoc($ex);

	
	$sql = "select
		a.po_code,
		a.customerid,
		a.order_status,
		a.created_on,
		p.productname,
		p.productcode,
		b.qty
			from sra_purchaseorder as a
			inner join sra_purchaseorderitem as b on b.purchasedorder_id = a.id
			inner join sra_product as p on p.id = b.product_id
			where
				a.id = '{$request['purchaseorderid']}';
			";
	$ex = $db->query($sql);
	$no_of_records = $db->NumRows($ex);
	while($rs = $db->FetchByAssoc($ex)){
		$rs['qty'] = (int) $rs['qty'];
		$purchaseInfo['items'][] = $rs;
	}

	
	echo json_encode(array('status' => $no_of_records > 0 ? true : false,'data' => $purchaseInfo ));
}


function GetPurchaseOrderForExport(){
        global $db;
        $wh = ListQueryCondition();
        $sql = "select
                sra_purchaseorder.id as 'purchaseorderid',
                sra_purchaseorder.po_code,
                sra_po_orderstatus.status,
                sra_customer.customer_name,
                sra_customer.customer_code,
                sra_purchaseorderitem.qty,
                sra_purchaseorder.created_on,
                sra_po_orderstatus.status as 'order_status',
		sra_product.productname,
		sra_product.productcode,
                if(po_whodid.id , po_whodid.customer_name , sra_users.name ) as 'whodid',
                        sra_purchaseorder.`type`
                                from sra_purchaseorder 
                                inner join 
                                         sra_purchaseorderitem
                                on sra_purchaseorderitem.purchasedorder_id = sra_purchaseorder.id
                                inner join sra_customer on sra_customer.id =  sra_purchaseorder.customerid
				inner join sra_product on sra_product.id = sra_purchaseorderitem.product_id 	
                                left join sra_po_orderstatus on sra_po_orderstatus.id = sra_purchaseorder.order_status
                                left join sra_customer as po_whodid on po_whodid.id =  sra_purchaseorder.whodid
                                left join sra_users on sra_users.id = sra_purchaseorder.whodid
                                where
                                        ".implode(" and ",$wh)."
		 order by sra_purchaseorder.id asc";
        $ex  = $db->query($sql);
        $no_of_records = $db->NumRows($ex);
        while($rs = $db->FetchByAssoc($ex)){
                $rs['qty'] = number_format($rs['qty'],0);
                $data[] = $rs;
        }
	$header = array('po_code' => 'PURCHASE CODE','created_on' => 'DATE','customer_name' => 'CUSTOMER NAME' , 'customer_code' => 'CUSTOMER CODE','productcode' => 'PRODUCT CODE','productname' => 'PRODUCT NAME','qty' => 'QTY', 'whodid' => 'WHO DID','order_status' => 'ORDER STATUS');


	$column_format = array('po_code' => 's','created_on' => 'date','customer_name' => 's' , 'customer_code' => 's','productname' => 's','qty' => 'n', 'whodid' => 's','order_status' => 's','productcode' => 's');
        return array('header' => $header, 'data' => $data , 'no_of_records' => $no_of_records,'column_format' => $column_format);
}



?>

