<?php
	session_start();
	include_once("portal/Util.php");
?>
<!doctype html>
<html lang="en">
    
<!-- Mirrored from pillar.mediumra.re/home-business-classic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 Aug 2019 11:53:19 GMT -->
<head>
        <meta charset="utf-8">
        <title>SR AGENCIES</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/socicon.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/iconsmind.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/interface-icons.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/lightbox.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/theme.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/custom.css" rel="stylesheet" type="text/css" media="all" />
        <link href='css/fonts_google.css' rel='stylesheet' type='text/css'>
    </head>
    <body class="scroll-assist">
        <a id="top"></a>
        <div class="loader"></div>
        <nav class="transition--fade" id="home_page">
            <div class="nav-bar nav--absolute nav--transparent" data-fixed-at="200">
                <div class="nav-module logo-module left">
		    <a href="index.php" style="color: #fff;font-size: 28px;letter-spacing: 3px;">
                                SRA
                    </a>

                </div>
                <div class="nav-module menu-module left">
                    <ul class="menu">
                        <li>
                            <a href="index.php" class="menubar" data-targ="home_page">
                                Home
                            </a>
			</li>
                        <li>
                            <a href="index.php#about_us" class="menubar" data-targ="about_us">
                               About Us	 
                            </a>
			</li>
                        <li>
                            <a  href="index.php#contact_us" class="menubar" data-targ="contact_us">
                               Contact Us 
                            </a>
			</li>
                    </ul>
                </div>
                <!--end nav module-->
                <div class="nav-module right">
                    <ul class="menu">
                        <li style="padding-right:15px;">
			<?php
				if(isset($_SESSION['sra_username'])){
			?>
                            <a href="portal/Category.php" style="letter-spacing:5px;">
                               Portal
                            </a>
	
			<?php
				}else{
			?>	
                            <a href="login.php" style="letter-spacing:5px;">
                               Login
                            </a>
			<?php
				}
			?>
			</li>
		    </ul>
                </div>
            </div>
            <!--end nav bar-->
            <div class="nav-mobile-toggle visible-sm visible-xs">
                <i class="icon-Align-Right icon icon--sm"></i>
            </div>
        </nav>
