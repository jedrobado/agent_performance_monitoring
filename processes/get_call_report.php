<?php
	header('Content-Type: application/json');
	include('../include/connect.php');
	date_default_timezone_set("America/New York");
	$getReport=getData("SELECT * FROM call_report");
	$data = array();
	foreach ($getReport as $row) {
		$data[] = $row;
	}
	echo json_encode($data);
?>