<?php
if ((strlen($box) > 0) && (strlen($p) > 2)) {
	$tid = time();
	$ip = $_SERVER['REMOTE_ADDR'];

	if ((strncmp($ip, "158.39.",7) == 0) && !strstr($box,"[")) {
		$Query = "SELECT box, ip, tid, url FROM	boxtracker WHERE box = '$box'";
		$dbResult = mysql_query($Query);
		$exists = 0;
		while($dbRow = mysql_fetch_object($dbResult))
		{
			$exists = 1;
		}
		if ($exists == 0) {
			$q = "INSERT INTO boxtracker SET box = '$box', passord = '$p'";
			mysql_query($q);
			delta($b, "ny");
		}
	}

	$query = "UPDATE boxtracker SET tid = '$tid', ip ='$ip' WHERE box = '$box' AND passord = '$p'";
	mysql_query($query);
	print($query);
	exit();
} else if ($sp == "tjooheizann") {
	$offline = time() - 80;	// up to 20 seconds late is ok
	$q = "UPDATE boxtracker SET oppetikk = oppetikk - 1 WHERE tid < '$offline'";
	mysql_query($q);

	$q = "UPDATE boxtracker SET totaltikk = totaltikk + 1, oppetikk = oppetikk + 1";
	mysql_query($q);

	// kun masteroppdateringer endrer delta
	include("delta.php");

} else {
	// axx denied
}


?>
