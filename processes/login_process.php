<?php
	include('../include/connect.php');
	$echo_return=array();
	$get_user=getData("SELECT * FROM users WHERE username=? AND password=? AND type=?",array($_POST['username'],$_POST['password'],$_POST['type']));
	if(COUNT($get_user)==1){
		session_start();
		$_SESSION['username']=$_POST['username'];
		$_SESSION['password']=$_POST['password'];
		$_SESSION['type']=$_POST['type'];
		$_SESSION['id']=$get_user[0]->id;
		array_push($echo_return, "Login success, redirecting you to your account.", "1");
	}
	else{
		array_push($echo_return, "Login failed, username and password does not match.", "2");
	}
	echo json_encode($echo_return);
?>