<?php

include_once("userlogin.php");
class ImportData 
{
	public $fields;
	public $filename;
	public $mandatory_fields;
	public $skip_fields;
	public $column_format;
	function __construct(){
		global $request;
		if($request['module'] == 'Customer'){
			$this->mandatory_fields = array('customer_name','customer_code','phoneno','status');
			$this->skip_fields = array('id','whodid');
			$this->column_format = array('customer_name','username','customer_code','contact_person','address','zipcode','city','state','phoneno','email','gstno','tinno','status','whodid');	
			$this->usertype = 'CUSTOMER';	
		}

	}

	function init(){

		if($_FILES['importfile']['name'] == '' ){
			$this->fields['error'] = "<H2 class='text-danger'>PLEASE SELECT FILE FOR IMPORT</H2>";
			return ;
		}
		$allowed =  array('xls','xlsx' );
		$filename = $_FILES['importfile']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
			$this->fields['error'] = 'INVALID FILE FORMAT TYPES, PLEASE USE XLS, XLSX FORMAT';
			return ;
		}
		$this->filename ='/tmp/importfile.'.$ext; 
		if(!move_uploaded_file($_FILES['importfile']['tmp_name'] , $this->filename)){
			$this->fields['error'] = 'SORRY CANNOT IMPORT FILE ';
			return ;
		}						

		$this->start_process();	
	}

	function start_process(){
		global $db ,$request;
		$inputFileName = $this->filename;
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		for ($row = 1; $row <= $highestRow; $row++){ 
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
					NULL,
					TRUE,
					FALSE);
			$data[] = $rowData;
		}
		$header = strtolower($data[0][0]);

		$table_header = '';
		unset($data[0]);
		$noofrecords = count($data);
		$i = 0;	

		foreach($this->column_format as $key => $column){
			if($table_header[$header[$key]] == ''){
				$table_header[$header[$key]] = $column; 
			}
		}

		foreach($data as $key => $content){
			$values = '';
			$isvalid = 1;	
			$isduplicate = 0;
			$content = $content[0];
			foreach($this->column_format as $key => $column){
				$val = addslashes($content[$key]);
				if(in_array($column,$this->mandatory_fields)){
					if($val == ''){
						$isvalid = 0;
						break;
					}	
				}
				if($column == 'username' and $val != ''){
					$isduplicate = $this->check_duplicate(strtolower($val));
					if($isduplicate)
						break;
				}
				if($column == 'whodid'){
					$val = $_SESSION['id'];
				}
				$values[$column] = $val; 
			}
			if($isvalid && !$isduplicate){
				if($request['module'] == 'Customer'){
				    $values['username'] = strtolower($values['username']);
					$sql = "insert into sra_customer (`".implode("` , `",$this->column_format)."`) VALUES ('".implode("' , '",$values)."');";
					$ex = $db->query($sql);
					if($ex) {
					    	$inserted++;
					}
					if($ex && $values['username'] !=''){	
						$_REQUEST['username'] = $values['username'];
						$_REQUEST['password'] = '123456';
						$_REQUEST['type']     = $this->usertype  ;
						frame_request();
						$Users = new User_login();
						$Users->save();
					}
				}
			}
			if($isduplicate){
				$duplicate[] = $content;
			}
			if(!$isvalid){
				$invalid_insert[] = $content;
			}
			$i++;
		}
		$this->fields['noofrecords'] = $noofrecords;
		$this->fields['duplicate'] = $duplicate;
		$this->fields['invalid_insert'] = $invalid_insert;
		$this->fields['inserted'] = $inserted == '' ? 0 : $inserted;
		$this->fields['header'] = $header;
		$this->fields['table_header'] = $table_header;
	}


	function check_duplicate($username,$module){
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

}

?>

