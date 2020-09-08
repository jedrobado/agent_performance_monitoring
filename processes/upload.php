<?php
	include("../include/connect.php");
	session_start();
	if(isset($_FILES['file']) && $_POST['date']!=""){
		$target_dir = "../files/";
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType == "csv") {
			if (!file_exists($target_file)) {
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					read_content($target_file);	
				}
				else{
					echo json_encode(array("2", "Reading failed, cannot upload."));
				}
			}
			else{
				echo json_encode(array("2", "File already exsist. Please rename the file."));
			}
		}
		else{
			echo json_encode(array("2", "Reading failed, error file or file type."));
		}
	}
	else{
		echo json_encode(array("2", "Reading failed, no file found or date."));
	}
	function add_time($time_list){
		$total_seconds=0;
		for ($i=0; $i < COUNT($time_list); $i++) { 
			$time_list[$i]=explode(":", $time_list[$i]);
			$total_seconds+=($time_list[$i][0]*60*60);
			$total_seconds+=($time_list[$i][1]*60);
			$total_seconds+=($time_list[$i][2]);
		}
		return floor($total_seconds / 3600) . gmdate(":i:s", $total_seconds % 3600);
	}
	function read_content($target_file){
		$read_file = fopen($target_file,"r");
		$array=array();
		$array_push=array();
		$get_sub_total=0;
		for ($i = 0; $file = fgetcsv($read_file); $i++){
			if($file[0]=="Grand Total"){
				break;
			}
			else{
				if($i>7){
					if($file[0]!=""){
						array_push($array_push, $file[0]);
					}
					if(COUNT($array_push)){
						if($get_sub_total==1){
							array_push($array_push, ($file[4]+$file[14]), add_time(array($file[9],$file[17])));
							array_push($array, $array_push);
							$array_push=array();
							$get_sub_total=0;
						}
						if($file[1]=="Sub Total"){
							$get_sub_total=1;
						}
					}
				}	
			}
		}
		$echo="<div><label>File Contents</label></div><table class='table table-hover table-bordered table-fixed table-striped text-center'><thead class='thead-dark'><tr class='p-1'><th class='p-1'>Name</th><th class='p-1'>Total Calls</th><th class='p-1'>Total Duration</th></tr></thead><tbody>";
		for ($i=0; $i < COUNT($array); $i++) {
			$echo.="<tr><td class='p-1'>".$array[$i][0]."</td><td class='p-1'>".$array[$i][1]."</td><td class='p-1'>".$array[$i][2]."</td></tr>";
		}
		$echo.="</tbody></table>";
		$success_msg="";
		if($_POST['type']==2){
			insertQuery("INSERT INTO upload_history (users_id,file_name,date,action)VALUES(?,?,?,?)",array($_SESSION['id'], $target_file, $_POST['date'], "Upload"));
			$get_insert_id=getData("SELECT id FROM upload_history WHERE users_id=? AND file_name=? AND date=? AND action=?",array($_SESSION['id'], $target_file, $_POST['date'], "Upload"));
			for ($i=0; $i < COUNT($array); $i++) { 
				insertQuery("INSERT INTO call_report (fullname,quantity,duration,date,upload_history_id)VALUES(?,?,?,?,?)",array($array[$i][0], $array[$i][1], $array[$i][2], $_POST['date'], $get_insert_id[0]->id));
			}
			$success_msg="Success saving to database.";
		}
		if($_POST['type']==1){
			unlink($target_file);
			$success_msg="Success reading file content(s).";
		}
		echo json_encode(array("1", $echo, $success_msg));
	}
?>