<?php
	require("account.php");
	date_default_timezone_set('America/New_York');
    function errorReporting()
    {
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
		ini_set('display_errors' , 1);
		return;
	}
	function resetSession(){
		session_unset();
		session_destroy();
		return;
	}

	function startSession(){
		session_start();
		return;
	}

	function isAdminLoggedIn(){
		return(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] && isset($_SESSION["user_type"]) && strcmp($_SESSION["user_type"], "admin") == 0);
	}

	function isReaaderLoggedIn(){
		return(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] && isset($_SESSION["user_type"]) && strcmp($_SESSION["user_type"], "reader") == 0);
	}

	function logoutButton(){
		
	}

    function connectDB(&$db, &$fag_c)
    {
		global $hostname, $username, $password, $project;
		$db=mysqli_connect($hostname, $username, $password, $project);
		if (mysqli_connect_errno()){
			$fag_c=TRUE;
		}
		return;
	}
	
	function mysqliOOP(){
		global $hostname, $username, $password, $project;
		$mysqli = new mysqli($hostname, $username, $password, $project);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		return($mysqli);
	}

	function mysqliCloseOOP(&$ms){
		$ms->close();
	}

    function closeDB(&$db)
    {
		mysqli_close($db);
		return;
    }
    function POST($fieldname, &$flag_empty, &$flag_isset)
    {
		// global $db;
		$flag_empty=TRUE;
		$flag_isset=FALSE;
		$flag_isset=isset($_POST[$fieldname]);
		if(!$flag_isset){
			//echo("smth");
			return;
		}
		$flag_isset=TRUE;
		$v=$_POST[$fieldname];
		$v=trim($v);
		if ($v==""){
			$flag_empty = true;
			//echo "<br><br>$fieldname is empty.";
			return;
		}
		// $v=mysqli_real_escape_string($db, $v);
		$flag_empty=FALSE;
		//echo "$fieldname is $v.<br>";
		//echo($v);
		return $v; 
	}
	
	function GET($fieldname, &$flag_empty, &$flag_isset){
		global $db;
		$flag_empty=TRUE;
		$flag_isset=FALSE;
		$flag_isset=isset($_GET[$fieldname]);
		if(!$flag_isset){
			//echo("smth");
			return;
		}
		$flag_isset=TRUE;
		$v=$_GET[$fieldname];
		$v=trim($v);
		if ($v==""){
			$flag_empty = true;
			//echo "<br><br>$fieldname is empty.";
			return;
		}
		$v=mysqli_real_escape_string($db, $v);
		$flag_empty=FALSE;
		//echo "$fieldname is $v.<br>";
		//echo($v);
		return $v; 
	}

	function getCurrentDate(){
		return(date("Y-m-d"));
	}

	function computeFine($borrow, $return){
		$maxBorrowLimitDays = 20;
		$fineRatePerDayAfterDueDate = 0.2;
		$qd = mysqliOOP();
		$fine = 0.0;
		$diff = "SELECT DATEDIFF('$return', '$borrow') AS `date_diff`;";
		$dres = $qd->query($diff);
		$drow = $dres->fetch_row();
		$num = (int)$drow[0];
		if($num > $maxBorrowLimitDays){
			$fine += $fineRatePerDayAfterDueDate * ($num - $maxBorrowLimitDays);
		}
		mysqliCloseOOP($qd);
		return($fine);
	}

    function authenticate($user, $pass)
    {
		// global $db;
		// $s="select * from AA where UCID='$UCID' and pass='$pass'";
		// ($t=mysqli_query($db,$s)) or die(mysqli_error($db));
		// if(mysqli_num_rows($t)!=1){
		// 	return(FALSE);
		// }
		// else{
		// 	return(TRUE);
		// }

		if(strcmp($user, "admin") == 0 && strcmp($pass, "adminpass") == 0){
			return(TRUE);
		}
		return(FALSE);
	}
?>