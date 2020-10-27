<?php
include("libraries/phpmailer/class.phpmailer.php");

class SendMail extends PHPMailer
{

        function __construct(){
                //$mail = new PHPMailer(); // create a new object
                $this->IsSMTP(); // enable SMTP
                $this->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                $this->SMTPAuth = true; // authentication enabled
                $this->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                $this->Host = "mail.srakarur.com";
                $this->Port = 465; // or 587
                $this->IsHTML(true);
                $this->Username = "admin@srakarur.com";
                $this->Password = "Jayam##^050%";
                $this->SetFrom("admin@srakarur.com");

        }

        function sendmail(){
                if(!$this->Send()) {
                        echo $this->ErrorInfo;
                } else {
                        echo 'Message has been sent';
                }
        }

}
