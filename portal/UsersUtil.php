<?php

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

	function get_user_hash($input) {
                return strtolower(md5($input));
        }


	function CheckPasswordIsExpire(){
		global $db;
		if(!$db)
			include_once("Engine.php");
		

		$sql = "select 	DATEDIFF(CURDATE(),pwd_status) as 'diff' , password_in_days as 'expdate' from vtiger_users 
				inner join password_session_policy where vtiger_users.id = ".$_SESSION['lenderid'].";";

		$ex  = $db->query($sql);
		$rs = $db->FetchByAssoc($ex);
		if($rs['diff'] >= $rs['expdate'] && $rs['expdate'] > 0){
			return true;
		}

		return false;

	}

?>
