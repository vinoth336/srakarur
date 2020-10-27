<?php
session_start();
$site_key="6LfV0YQUAAAAAAu4hNBDyn1jPqrQ-bgdiGYdtgz5";

if(isset($_COOKIE['sra_username']) && $_COOKIE['sra_username'] != ''){
        include("portal/userlogin.php");
        $user = new User_login();
        $user_name = $user->decrypt_sra_username($_COOKIE['sra_username']);
        $isvalid = $user->isValidUser($user_name);
        if($isvalid['status']){
                $user->Autologin($isvalid['record']);
                header("Location: portal/dashboard.php");
        }
}elseif(isset($_SESSION['sra_username'])){
                header("Location: portal/dashboard.php");
}



    if($_GET['status'] == 'error' || $_GET['invalid_user'] == 'invalid_user' || $_GET['status'] == 'Authentication Failed')
    {
                $msg = "INVALID ACCESS , PLEASE TRY AGAIN";
    }elseif($_GET['status'] == 'MCA-NOTAVAILABLE'){
                $msg = "MCA SERVICE TEMPORARILY NOT AVAILABLE ";
    }elseif($_GET['status'] == 'ACCOUNT-INACTIVE'){
                $msg = "YOUR ACCOUNT IS IN-ACTIVE , PLEASE CONTACT ADMIN ";
    }elseif($_GET['status'] == 'session_expire'){
                $msg = "SESSION EXPIRE";
    }else
                $msg = $_GET['status'];


    function get_client_ip() {
                $ipaddress = '';
                if (getenv('HTTP_CLIENT_IP'))
                        $ipaddress = getenv('HTTP_CLIENT_IP');
                else if(getenv('HTTP_X_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                else if(getenv('HTTP_X_FORWARDED'))
                        $ipaddress = getenv('HTTP_X_FORWARDED');
                else if(getenv('HTTP_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_FORWARDED_FOR');
                else if(getenv('HTTP_FORWARDED'))
                        $ipaddress = getenv('HTTP_FORWARDED');
                else if(getenv('REMOTE_ADDR'))
                        $ipaddress = getenv('REMOTE_ADDR');
                else
                        $ipaddress = 'UNKNOWN';
                return $ipaddress;
  }


	include("Header.php");

?>

	<section class="height-100 cover cover-8">
                <div class="col-md-7 col-sm-5  hidden-sm hidden-xs">
                    <div class="background-image-holder">
                        <img alt="image" src="img/hero13.jpg" />
                    </div>
                </div>
                <div class="col-md-5 col-sm-7 bg--white text-center">
                    <div class="pos-vertical-center">
                        <img class="logo" alt="" src="img/logo_wh.PNG" />
			<div class="text-left">
			<?php
			    echo show_error();
			?>
                            <form method="post" action="portal/userlogin.php">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-with-icon">
                                            <label>Username:</label>
                                            <i class="icon icon-Male-2"></i>
                                            <input type="text" name="username" placeholder="Username" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-with-icon">
                                            <label>Password:</label>
                                            <i class="icon icon-Security-Check"></i>
                                            <input type="password" name="password" placeholder="&bullet;&bullet;&bullet;&bullet;&bullet;&bullet;" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <div class="input-checkbox">
                                            <div class="inner"></div>
                                            <input type="checkbox"  name="rememberme" value="1"/>
                                        </div>
                                        <span class="type--fine-print">Keep me logged in</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" name='login' class="btn btn--primary">Login</button>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <p class="type--fine-print">
                                        Forgot password?
                                        <a href="#">Start password recovery</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
<?php 
	include("Footer.php");
?>
