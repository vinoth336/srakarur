<?php
	global $db;
	$id = $_SESSION['id'];
	if($_SESSION['type'] == 'CUSTOMER'){
		$sql = "select * from sra_customer where id=$id";
		$ex  = $db->query($sql);
		$rs  = $db->FetchByAssoc($ex);
	}

	

?>
