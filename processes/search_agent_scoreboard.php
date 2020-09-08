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
	include("../include/connect.php");
	date_default_timezone_set('America/New_York'); 
	$return_array=array(array(),array(),array(),array(),array(),array());
	$date1="";$date2="";
	$days=array("Monday"=>0,"Tuesday"=>1,"Wednesday"=>2,"Thursday"=>3,"Friday"=>4,"Saturday"=>5,"Sunday"=>6);
	if($_POST['category']==1){$date1=date("Y-m-d");$date2=date("Y-m-d");}
	if($_POST['category']==2){
		$date1=date("Y-m-d", strtotime("-".($days[date("l", strtotime(date("Y-m-d")))])." days"));
		$date2=date("Y-m-d", strtotime("+".((6-$days[date("l", strtotime(date("Y-m-d")))]))." days"));
	}
	if($_POST['category']==3){$date1=date("Y-m-01");$date2=date("Y-m-31");}
	if($_POST['category']==4){$date1=date("Y-01-01");$date2=date("Y-12-31");}
	if($_POST['category']==5){$date1=date("Y-m-d", strtotime($_POST['date1']));$date2=date("Y-m-d", strtotime($_POST['date2']));}
	//$get_report=getData("SELECT * FROM call_report WHERE date BETWEEN ? AND ? ORDER BY date DESC",array($date1,$date2));
	$get_report=getData("SELECT DISTINCT(fullname) FROM call_report WHERE date BETWEEN ? AND ?",array($date1,$date2));
	
	$get_date=getData("SELECT DISTINCT(date) FROM call_report WHERE date BETWEEN ? AND ? ORDER BY date ASC",array($date1,$date2));
	foreach ($get_date as $value) {
		array_push($return_array[0],date("Y-m-d",strtotime($value->date)));
	}

	$temp_quantity=array();
	$temp_duration=array();
	foreach ($get_report as $report){
		array_push($return_array[1],$report->fullname);
		$total_duration=array();
		$total_quantity=array(); 
		foreach($return_array[0] as $key) { //per day loop
			$get_report2=getData("SELECT * FROM call_report WHERE date=? AND fullname=?",array($key,$report->fullname));
			$quantity=0;$duration=0;
			foreach ($get_report2 as $report2){
				$quantity+=$report2->quantity;
				$duration+=add_time(array($report2->duration));
			}
			$temp_quantity[$key]+=$quantity;
			$temp_duration[$key]+=$duration;
			$total_quantity[$key]=$quantity;
			$total_duration[$key]=$duration;
		} // per day loop
		array_push($return_array[2],$total_quantity);
		array_push($return_array[3],$total_duration);
	}
	array_push($return_array[4], $temp_quantity,$temp_duration);
	array_push($return_array[5],array_sum($temp_quantity),array_sum($temp_duration));
	echo json_encode($return_array);
?>