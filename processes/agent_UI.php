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
	$return_array=array(array(),array(),array(),array(),array());
	$date1="";$date2="";$echo_table="";$echo_compact_table="";$number_of_days=0;$flag=1;$date_limit=date("l");
	$weekly_breakdown=array(array(0,0),array(0,0),array(0,0),array(0,0),array(0,0),array(0,0),array(0,0));
	$days=array("Monday"=>0,"Tuesday"=>1,"Wednesday"=>2,"Thursday"=>3,"Friday"=>4,"Saturday"=>5,"Sunday"=>6);
	$date1=date("Y-m-d", strtotime("-".($days[date("l", strtotime(date("Y-m-d")))])." days"));
	$date2=date("Y-m-d", strtotime("+".((6-$days[date("l", strtotime(date("Y-m-d")))]))." days"));
	$get_agent=getData("SELECT DISTINCT(fullname) FROM call_report WHERE date BETWEEN ? AND ?",array($date1,$date2));
	$date_limit=getData("SELECT date FROM call_report WHERE date BETWEEN ? AND ? ORDER BY date DESC LIMIT 1",array($date1,$date2));
	$date_limit=(COUNT($date_limit)>0?$date_limit[0]->date:date("l"));
	if(COUNT($get_agent)>0){
		$append_compact_table="";
		foreach ($get_agent as $agent) {
			$echo_compact_table.=($flag==1?"<tr>":"")."<td class='p-0 text-center align-middle' rowspan=2>".$agent->fullname."</td>";
			$echo_table.="<tr><td rowspan='2' class='p-0 text-center align-middle'>".$agent->fullname."</td>";
			$performance=array(array(0,0),array(0,0),array(0,0),array(0,0),array(0,0),array(0,0),array(0,0));
			$fibonacci_sequence=array(array(0,0),array(0,0),array(0,0),array(0,0),array(0,0),array(0,0),array(0,0));
			$append_table="<tr>";
			for ($i=0; $i < 7; $i++) {
				$number_of_days=($i+1);
				$get_results=getData("SELECT * FROM call_report WHERE fullname=? AND date=?", array($agent->fullname, date("Y-m-d",strtotime($date1." +".$i." days"))));
				foreach ($get_results as $results) {
					$performance[$i][0]+=$results->quantity;
					$performance[$i][1]+=add_time(array($results->duration));
					$weekly_breakdown[$i][0]+=$results->quantity;
					$weekly_breakdown[$i][1]+=add_time(array($results->duration));
				}
				$fibonacci_sequence[$i][0]+=$performance[$i][0]+$fibonacci_sequence[($i-1)][0];
				$fibonacci_sequence[$i][1]+=$performance[$i][1]+$fibonacci_sequence[($i-1)][1];
				$bg1="";$bg2="";
				if($performance[$i][0]>=140 || $performance[$i][1]>=3){$bg1="class='bg-success text-center text-white p-0'";}else{$bg1="class='bg-danger text-center text-white p-0'";}
				$echo_table.="<td ".$bg1.">".$performance[$i][0]."</td><td ".$bg1.">".$performance[$i][1]."</td>";
				if($fibonacci_sequence[$i][0]>=(140*($i+1)) || $fibonacci_sequence[$i][1]>=(3*($i+1))){$bg2="class='bg-success text-center text-white p-0'";}else{$bg2="class='bg-danger text-center text-white p-0'";}
				$append_table.="<td ".$bg2.">".$fibonacci_sequence[$i][0]."</td><td ".$bg2.">".$fibonacci_sequence[$i][1]."</td>";
				if($date_limit==date("Y-m-d",strtotime($date1." +".$i." days"))){
					$echo_compact_table.="<td ".$bg1.">".$performance[$i][0]."</td><td ".$bg1.">".$performance[$i][1]."</td>";
					$append_compact_table.="<td ".$bg2.">".$fibonacci_sequence[$i][0]."</td><td ".$bg2.">".$fibonacci_sequence[$i][1]."</td>";
					for ($i; $i < 6; $i++) { 
						$echo_table.="<td class='text-center p-0'>0</td><td class='text-center p-0'>0</td>";
						$append_table.="<td class='text-center p-0'>0</td><td class='text-center p-0'>0</td>";
					}
				}
			}
			$echo_table.="</tr>".$append_table."</tr>";
			$echo_compact_table.=(($flag%3)==0 || $flag==COUNT($get_agent)?"</tr>"."<tr>".$append_compact_table."</tr>".($flag!=COUNT($get_agent)?"<tr>":""):"");
			$append_compact_table=(($flag%3)==0?"":$append_compact_table);
			$flag++;
		}
	}
	for ($i=0; $i < COUNT($weekly_breakdown); $i++) { 
		$return_array[2][0]+=$weekly_breakdown[$i][0];
		$return_array[2][1]+=$weekly_breakdown[$i][1];
	}
	$return_array[3][0]=$return_array[2][0]/$number_of_days;
	$return_array[3][1]=$return_array[2][1]/$number_of_days;
	$return_array[4][date("l",strtotime($date_limit))]=$echo_compact_table;
	array_push($return_array[0], $echo_table);
	array_push($return_array[1], $weekly_breakdown);
	echo json_encode($return_array);
?>