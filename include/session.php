<?php 
	session_start();
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		$login_failed=0;
		include("connect.php");
		$get_user=getData("SELECT * FROM users WHERE username=? AND password=? AND type=?",array($_SESSION['username'],$_SESSION['password'],$_SESSION['type']));
		if(COUNT($get_user)==1){
			// folder directory per type
			include("type.php");
			foreach ($folder_name as $key => $value) {
				if($_SESSION['type']==$key){
					if(strpos($_SERVER['REQUEST_URI'], $value) === false) {
						header("Location://".$_SERVER['HTTP_HOST']."/web_app/".$value."/index.php");
					}
				}
			}
		}
		else{
			$login_failed=1;
		}
		if($login_failed==1){
			session_destroy();
			header("Location://".$_SERVER['HTTP_HOST']."/web_app/pages/index.php");
		}
	}
	else{
		if($_SERVER['REQUEST_URI']!="/web_app/pages/index.php"){
			header("Location://".$_SERVER['HTTP_HOST']."/web_app/pages/index.php");
		}
	}
?>