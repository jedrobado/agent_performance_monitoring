<?php
	include("../include/connect.php");
	if($_POST['date']!=""){
		$get_uploads=getData("SELECT * FROM upload_history WHERE action=? AND date=?",array("Upload", $_POST['date']));
		if(COUNT($get_uploads)>0){
			if($_POST['type'==1]){
				foreach ($get_uploads as $value) {
					
				}
			}
			if($_POST['type']==2){

			}
		}
		else{
			echo json_encode(array(2, "No upload(s) found."));
		}
	}
	else{
		echo json_encode(array(2, "Please input a date."));
	}
?>