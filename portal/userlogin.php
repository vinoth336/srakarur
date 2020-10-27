<?php	
session_start();
include_once("Engine.php");
include_once("Util.php");
include_once("UsersUtil.php");
        frame_request();
	class User_login extends MakeConnect
	{
		public $valuemap;
		public $rawvaluemap;	
		function __construct($values = array(), $rawvalues = array()) {
			$this->valuemap = $values;
			$this->rawvaluemap = $rawvalues;
		}

		function login()
		{
			global $db;
			global $request;
			global $cookie_expiry;
			global $site_url;
			$username = strtolower($request['username']);
			$password = $request['password'];

			if($username == '' || $password == ''){
				$this->invalidaccess();
			}	
		 	$sql = "select username , password , type , id from users where username='$username' ; ";
			$ex  = $db->query($sql);
			$row = $db->FetchByAssoc($ex);
			if($row['username'])
			{
					$password = encrypt_password($row['username'],$password);
					if(strtolower($row['username']) == $username && $row['password'] == $password)
					{

						$sql = "
							SELECT sra_customer.id, sra_customer.customer_name AS 'user_name'
							FROM sra_customer
							where
							sra_customer.username = '{$row['username']}'
							union
							select
							sra_users.id AS 'id', sra_users.name AS 'user_name'
							from sra_users 
							WHERE
							sra_users.username = '{$row['username']}'
								  ";
							$ex  = $db->query($sql);
							$rs = $db->FetchByAssoc($ex);

							$_SESSION['sid'] = session_id();
							$_SESSION['id'] = $rs['id'];
							$_SESSION['sra_username'] 	= $row['username'];
							$_SESSION['user_name'] 	= $row['name'];
							$_SESSION['type'] 	= $row['type'];

							
							$sql = "select session_time from password_session_policy ;";
							$ex  = $db->query($sql);
							$rs  = $db->FetchByAssoc($ex);

							$_SESSION['timeout'] = $rs['session_time'];
							$_SESSION['time'] = date("Y-m-d H:i:s" ,strtotime("+".$_SESSION['timeout']." seconds"));
	
							$_SESSION['REPORT_VIEW']['payment'] = $row['payment_view'] != '' ? $row['payment_view'] : 'week' ;
							
							if($request['rememberme'] == 1){
								setcookie('sra_username',$this->encrypt_username($row['username']),$cookie_expiry,'/',$site_url);
							}							
							$_SESSION['current_user'] = $row['id'];
							header("Location: ViewPurchaseOrder.php");
					}else{
                                                $this->invalidaccess();
                                        }

			}
			else
			{
					$this->invalidaccess();	

			}
		}

		function invalidaccess(){
			$_SESSION['flash_message']['error'] = 'Invalid UserName or Password';
				header("Location: " . $_SERVER['HTTP_REFERER']);
				exit;
		}

		function Save(){
			global $db,$request;
			$username = $request['username'];
			$password = $request['password'];
			$type	  = $request['type'];
		 	$sql = "select username from users where username = '$username' ; ";
			$ex  = $db->query($sql);
			$row = $db->FetchByAssoc($ex);
			if($row['username'])
			{
				$password = $this->encrypt_password($username,$password);
				$sql = "UPDATE users SET password = '".$password."' where username = '$username'";
			}else{
				$password = $this->encrypt_password($username,$password);
				$sql = "INSERT INTO users (`username`,`password`,`type`,`created_at`,`updated_at`) VALUES ('$username','$password','$type',NOW(),NOW()); ";
			}
			$ex = $db->query($sql);
			if($ex)
				return true;
			else
				return false;
			
		}

		function encrypt_username($username){
			$key = "498#2D83B631%3800EBD!801600D*7E3CC13";
			$date=date("Y-m-d H:i:s",time());
			$encrypt_method = "AES-128-ECB";
			$secret_iv = 'S34 ***343 FDK!!@SECRETNOTHI23)(*';

			// hash
			$key = hash('sha256', $key);
			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$output = openssl_encrypt($username, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);
			return $output;

		}
		function decrypt_username($username){
			$key ="498#2D83B631%3800EBD!801600D*7E3CC13";
			$encrypt_method = "AES-128-ECB";
			$secret_key = 'This is my secret key';
			$secret_iv = 'S34 ***343 FDK!!@SECRETNOTHI23)(*';
			// hash
			$key = hash('sha256', $key);
			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$output= openssl_decrypt($username, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);	
			return $output;
		}

		function encrypt_password($user_name ,$user_password ,$crypt_type='PHP5.3MD5') {
			// encrypt the password.
			$salt = substr($user_name, 0, 2);
			// For more details on salt format look at: http://in.php.net/crypt
			if($crypt_type == 'MD5') {
			$salt = '$1$' . $salt . '$';
			} elseif($crypt_type == 'BLOWFISH') {
			$salt = '$2$' . $salt . '$';
			} elseif($crypt_type == 'PHP5.3MD5') {
			//only change salt for php 5.3 or higher version for backward
			//compactibility.
			//crypt API is lot stricter in taking the value for salt.
				$salt = '$1$' . str_pad($salt, 9, '0');
			}
			$encrypted_password = crypt($user_password, $salt);
			return $encrypted_password;
		}


		function Autologin($record){
			global $db;
			$_SESSION['sid'] = session_id();
			$_SESSION['id'] = $record['id'];
			$_SESSION['username'] 	= $record['username'];
			$_SESSION['user_name'] 	= $record['first_name']." ".$record['last_name'];
			$_SESSION['deal_document'] = $record['show_personal_document'];


			$_SESSION['view_other_lenders_report'] = $record['view_other_lenders_report'] == 'yes' ? true : false;

			if($record['payment_view'] == 'Weekly')	
				$record['payment_view'] = 'week';
			if($record['payment_view'] == 'Daily')
				$record['payment_view'] = 'date';							


			$sql = "select session_time from password_session_policy ;";
			$ex  = $db->query($sql);
			$rs  = $db->FetchByAssoc($ex);
			$_SESSION['timeout'] = $rs['session_time'];
			$_SESSION['time'] = date("Y-m-d H:i:s" ,strtotime("+".$_SESSION['timeout']." seconds"));
			$_SESSION['REPORT_VIEW']['payment'] = $record['payment_view'] != '' ? $record['payment_view'] : 'week' ;
			$_SESSION['current_user'] = $record['id'];
			$_SESSION['lenderid'] = $record['id'];

		}

	}

if(isset($_POST['login'])){
	$log = new User_login();
	$log->login();
}
?>
