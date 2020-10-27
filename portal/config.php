<?php
        #ini_set('display_errors','on'); 
        global $dbconfig;
        global $page_limit;
        global $site_url;
        global $cookie_expiry;
        global $webform ;
        global $is_production;
        global $Api_url;
        global $Support_Order;
        global $hide_menus;
                $live = 0;
                if($live){
                        $dbconfig['servername'] = 'localhost';
                        $dbconfig['port']       = 3310;
                        $dbconfig['username']   = 'srakarur_vinoth';
                        $dbconfig['password']   = 'SraKarur!@#45';
                        $dbconfig['dbname']     = 'srakarur_sra';

                }else{
                        $dbconfig['servername'] = 'localhost';
                        $dbconfig['port']       = 3306;
                        $dbconfig['username']   = 'root';
                        $dbconfig['password']   = 'root';
                        $dbconfig['dbname']     = 'srakarur_sra';

                }

        $is_production = false;
        $site_URL = "http://localhost/sra";
        $cookie_expiry = time()+60*60*24*365;
        $root_directory = '/var/www/html/sra/';
        $webform['publicid']    = "5d066895f86f4e691cdae0afa2693695";
    
    
?>

