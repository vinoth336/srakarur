<?php
include("config.php");
global $db;
class MakeConnect
{
        var $servername;
        var $username;
        var $password;
        var $dbname;
        var $connect;
        function __construct()
        {
                global $dbconfig;
                @extract($dbconfig);

                $this->servername = $servername;
                $this->username = $username;
                $this->password = $password;
                $this->dbname = $dbname;
		$this->port	= $port;
                $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname,$this->port);
                if(!$this->connect)
                {
                        echo mysqli_error($this->connect);
                }
        }
        function Query($query)
        {
                $result = mysqli_query($this->connect, $query);
                if($result)
                {
                        return $result;
                }
                else
                {
                        echo mysqli_error($this->connect);
                }
        }
        function FetchByAssoc($ex)
        {
		$getresult = mysqli_fetch_assoc($ex);
		return $getresult;
        }
	function NumRows($ex){
		$rowcount=mysqli_num_rows($ex);
		return $rowcount;
	}

	function GetFields($ex){
		$rowcount=mysqli_fetch_field($ex);
		return $getresult;
	}
        function close($connect)
        {
                mysqli_close($this->connect);
        }
}

$db = new MakeConnect();
?>

