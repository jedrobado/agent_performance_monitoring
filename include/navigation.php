<header class="default_background_color">
	<div id="slide-out" class="side-nav fixed default_background_color">
		<ul class="custom-scrollbar">
			<li>
				<div class="text-center default_background_color">
					<a href="index.php" class="p-0 py-1 h-auto"><img src="../img/footer_logo.png" alt="aurora" class="rounded-circle img-fluid footer_image"></a>
				</div>
			</li>
						<li>
				<ul class="collapsible collapsible-accordion m-0">
					<?php
						include("../include/".$_SESSION['type']."_nav.php");
					?>
				</ul>
			</li>
		</ul>
		<div class="sidenav-bg mask-strong"></div>
	</div>
	<nav class="py-0 navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav default_background_color pr-0">
		<div class="float-left">
			<a href="#" data-activates="slide-out" class="button-collapse ml-0"><i class="fas fa-stream"></i></a>
		</div>
		<div class="breadcrumb-dn mr-auto white-text">
			<p><?php echo $page_title;?></p>
		</div>
		<ul class="nav navbar-nav nav-flex-icons ml-auto">
			<li class="nav-item dropdown">
				<a class="hvr-pop nav-link" href="#" id="profile_menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="../img/person_male.png" alt="profile" style="width: auto;" class="nav_profile">
				</a>
				<div class="dropdown-menu dropdown-menu-right secondary_background_color custom_dropdown_menu" aria-labelledby="profile_menu">
					<a class="white-text btn btn-sm hvr-pop dropdown-item" href="profile.php">Profile</a>
					<a class="white-text btn btn-sm hvr-pop dropdown-item" href="../processes/logout.php">Logout</a>
				</div>
			</li>
		</ul>
	</nav>
</header>
<main class="ml-0 mr-0 pt-0 mt-5 mb-2">
    <div class="container-fluid">
