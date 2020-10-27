<?php
include("config.php");
session_start();
$logout = session_destroy();
setcookie('syndicate_username','',$cookie_expiry * -1,'/',$site_url);
if($logout)
{
	header("Location: ../index.php");
}

?>
