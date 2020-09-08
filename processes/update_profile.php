<?php
	include("../include/connect.php");
	session_start();
	if(getRowCount("SELECT * FROM users WHERE username=? AND id!=?",array($_POST['username'],$_SESSION['id']))==0){
		insertQuery("UPDATE users SET fullname=?, username=?, password=? WHERE id=?",array($_POST['fullname'],$_POST['username'],$_POST['password'],$_SESSION['id']));
		if(getRowCount("SELECT * FROM users WHERE fullname=? AND username=? AND password=? AND id=?",array($_POST['fullname'],$_POST['username'],$_POST['password'],$_SESSION['id']))>0){
			echo json_encode(array(0,"Update success."));
		}
		else{
			echo json_encode(array(1,"Update failed, try again later."));
		}
	}
	else{
		echo json_encode(array(1,"Update failed, username already taken."));
	}
?>