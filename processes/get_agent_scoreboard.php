<?php
	function add_time($time_list){
		$total_seconds=0;
		for ($i=0; $i < COUNT($time_list); $i++) { 
			$time_list[$i]=explode(":", $time_list[$i]);
			$total_seconds+=($time_list[$i][0]*60*60);
			$total_seconds+=($time_list[$i][1]*60);
			$total_seconds+=($time_list[$i][2]);
		}
		$total_seconds=(($total_seconds/60)/60);
		return number_format($total_seconds,2);
	}
	function date_list($date1, $date2, $send_agent){
		$dates_array=array();
		$get_date=getData("SELECT DISTINCT(date) FROM call_report WHERE fullname=? AND date BETWEEN ? AND ? ORDER BY date ASC",array($send_agent,$date1,$date2));
		foreach ($get_date as $value) {
			array_push($dates_array,date("Y-m-d",strtotime($value->date)));
		}
		return $dates_array;
	}
	include("../include/connect.php");
	date_default_timezone_set('America/New_York'); 
	$return_array=array(array(),array(),array(),array(),array(),array(),array(),array());
	$daily_calls=array();
	$daily_duration=array();
	$date1="";
	$date2="";
	$days=array("Monday"=>0,"Tuesday"=>1,"Wednesday"=>2,"Thursday"=>3,"Friday"=>4,"Saturday"=>5,"Sunday"=>6);
	if($_POST['send_category']==1){
		$date1=date("Y-m-d");
		$date2=date("Y-m-d");
	}
	if($_POST['send_category']==2){
		$date1=date("Y-m-d", strtotime("-".($days[date("l", strtotime(date("Y-m-d")))])." days"));
		$date2=date("Y-m-d", strtotime("+".((6-$days[date("l", strtotime(date("Y-m-d")))]))." days"));
	}
	if($_POST['send_category']==3){
		$date1=date("Y-m-01");
		$date2=date("Y-m-31");
	}
	if($_POST['send_category']==4){
		$date1=date("Y-01-01");
		$date2=date("Y-12-31");
	}
	if($_POST['send_category']==5){
		$date1=date("Y-m-d", strtotime($_POST['send_date1']));
		$date2=date("Y-m-d", strtotime($_POST['send_date2']));
	}
	$dates_return=date_list($date1, $date2, $_POST['send_agent']);
	foreach ($dates_return as $value) {
		$daily_calls[$value]=0;
		$daily_duration[$value]=0;
	}
	$get_report=getData("SELECT * FROM call_report WHERE fullname=? AND date BETWEEN ? AND ? ORDER BY date DESC",array($_POST['send_agent'],$date1,$date2));
	foreach ($get_report as $report) {
		$daily_calls[$report->date]+=$report->quantity;
		$daily_duration[$report->date]+=add_time(array($report->duration));
		array_push($return_array[0], $report);
	}
	array_push($return_array[1], "Quantity","Duration (Hours)","Total Quantity","Total Duration (Hours)");
	array_push($return_array[2], $dates_return);
	array_push($return_array[3], array("Total Quantity"), array("Total Duration (Hours)"));
	array_push($return_array[4], $daily_calls);
	array_push($return_array[5], $daily_duration);
	array_push($return_array[6], array("Total Quantity"=>array_sum($daily_calls)));
	array_push($return_array[7], array("Total Duration (Hours)"=>array_sum($daily_duration)));	
	echo json_encode($return_array);
?>