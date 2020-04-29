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

	function getLocationOfCopy($docid, $copyno, $libid){
		$qd = mysqliOOP();
		$query = "SELECT * FROM `COPY` WHERE `DOCID`=$docid AND `COPYNO`=$copyno AND `LIBID`=$libid;";
		$result = $qd->query($query);
		while($row = $result->fetch_assoc()){
			$rtn = $row['POSITION'];
		}
		mysqliCloseOOP($qd);
		return($rtn);
	}

	function isAdminLoggedIn(){
		return(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] && isset($_SESSION["user_type"]) && strcmp($_SESSION["user_type"], "admin") == 0);
	}

	function isReaaderLoggedIn(){
		return(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] && isset($_SESSION["user_type"]) && strcmp($_SESSION["user_type"], "reader") == 0);
	}

	function borrowCopy($bor_docid, $bor_copyno, $bor_libid, $readerID){
		$qd = mysqliOOP();
		$deleteQuery = "DELETE FROM `RESERVES` WHERE `DOCID`=$bor_docid AND `COPYNO`=$bor_copyno AND `LIBID`=$bor_libid AND `READERID`=$readerID;";
		$deleteResult = $qd->query($deleteQuery);
		$insertQuery = "INSERT INTO `BORROWS` (`BORNUMBER`, `READERID`, `DOCID`, `COPYNO`, `LIBID`, `BDTIME`, `RDTIME`) VALUES (NULL, '$readerID', '$bor_docid', '$bor_copyno', '$bor_libid', NOW(), NULL);";
		$insertResult = $qd->query($insertQuery);
		mysqliCloseOOP($qd);
		return;
	}

	function isCopyBorrowable($bor_docid, $bor_copyno, $bor_libid, $readerID){
		$qd = mysqliOOP();
		$query1 = "SELECT * FROM `BORROWS` WHERE `DOCID`=$bor_docid AND `COPYNO`=$bor_copyno AND `LIBID`=$bor_libid AND `RDTIME` IS NULL;";
		$result = $qd->query($query1);
		if($result->num_rows > 0){
			return(FALSE);
		}
		$query2 = "SELECT * FROM `RESERVES` WHERE `DOCID`=$bor_docid AND `COPYNO`=$bor_copyno AND `LIBID`=$bor_libid;";
		$query3 = "SELECT * FROM `RESERVES` WHERE `DOCID`=$bor_docid AND `COPYNO`=$bor_copyno AND `LIBID`=$bor_libid AND `READERID`=$readerID;";
		$result2 = $qd->query($query2);
		if($result2->num_rows > 0){
			$result3 = $qd->query($query3);
			if($result3->num_rows <= 0){
				return(FALSE);
			}
		}
		mysqliCloseOOP($qd);
		return(TRUE);
	}

	function isCopyReservable($bor_docid, $bor_copyno, $bor_libid){
		$qd = mysqliOOP();
		$query1 = "SELECT * FROM `BORROWS` WHERE `DOCID`=$bor_docid AND `COPYNO`=$bor_copyno AND `LIBID`=$bor_libid AND `RDTIME` IS NULL;";
		$result = $qd->query($query1);
		if($result->num_rows > 0){
			return(FALSE);
		}
		$query2 = "SELECT * FROM `RESERVES` WHERE `DOCID`=$bor_docid AND `COPYNO`=$bor_copyno AND `LIBID`=$bor_libid;";
		$result2 = $qd->query($query2);
		if($result2->num_rows > 0){
			return(FALSE);
		}
		mysqliCloseOOP($qd);
		return(TRUE);
	}

	function reserveCopy($res_docid, $res_copyno, $res_libid, $readerID){
		$qd = mysqliOOP();
		$insertQuery = "INSERT INTO `RESERVES` (`RESNUMBER`, `READERID`, `DOCID`, `COPYNO`, `LIBID`, `DTIME`) VALUES (NULL, '$readerID', '$res_docid', '$res_copyno', '$res_libid', NOW());;";
		$insertResult = $qd->query($insertQuery);
		mysqliCloseOOP($qd);
		return;
	}

	function returnDocumentCopy($BORNUMBER){
		$query = "UPDATE `BORROWS` SET `RDTIME` = NOW() WHERE `BORROWS`.`BORNUMBER` = $BORNUMBER;";
		$qd = mysqliOOP();
		$result = $qd->query($query);
		mysqliCloseOOP($qd);
		return;
	}

	function makeReservationIntoBorrowing($RESNUMBER){
		$qd = mysqliOOP();
		$lookupQuery = "SELECT * FROM `RESERVES` WHERE `RESNUMBER`=$RESNUMBER;";
		$res = $qd->query($lookupQuery);
		if($res){
			$row = $res->fetch_row();
			$readerID = $row[1];
			$bor_docid = $row[2];
			$bor_copyno = $row[3];
			$bor_libid = $row[4];
			borrowCopy($bor_docid, $bor_copyno, $bor_libid, $readerID);
		}
		mysqliCloseOOP($qd);
		return;
	}

	function dropReservation($RESNUMBER){
		$qd = mysqliOOP();
		$deleteQuery = "DELETE FROM `RESERVES` WHERE `RESNUMBER`=$RESNUMBER;";
		$result = $qd->query($deleteQuery);
		mysqliCloseOOP($qd);
		return;
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
		// global $db;
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
		// $v=mysqli_real_escape_string($db, $v);
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