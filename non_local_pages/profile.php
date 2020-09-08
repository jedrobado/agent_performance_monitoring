<?php $page_title="Profile Page"; ?>
<?php include('../template/start.php');?>
<script>var side_nav=[0,0];</script>
<!-- content -->
<div class="row">
	<div class="col-md-6 col-sm-12 col-12">
		<div class="card">
			<div class="card-header">
				User Information
			</div>
			<div class="card-body">
				<form method="POST" id="profile">
					<?php
						$get_user=getData("SELECT * FROM users WHERE username=? AND password=? AND type=?",array($_SESSION['username'],$_SESSION['password'],$_SESSION['type']));
					?>
					<label class="float-left text-deep-purple2 mb-0">Full Name</label>
					<input type="text" class="form-control" name="fullname" value="<?php echo $get_user[0]->fullname; ?>" required>
					<label class="float-left text-deep-purple2 mb-0">Username</label>
					<input type="text" class="form-control" name="username" value="<?php echo $get_user[0]->username; ?>" required>
					<label class="float-left text-deep-purple2 mb-0">Password</label>
					<input type="password" class="form-control" name="password" value="<?php echo $get_user[0]->password; ?>" required>
					<button class="btn btn-primary btn-sm" type="submit" name="upload_content">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!--content-->
<?php include('../template/end.php');?>
<!-- process -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#profile").submit(function(e){
			e.preventDefault();
			$.ajax({
				'url':'../processes/update_profile.php',
				'async':false,
				'type':'POST',
				'dataType':'JSON',
				'data':$(this).serialize(),
				success:function(data){
					if(data[0]==0){toastr["success"](data[1]);}
					if(data[0]==1){toastr["error"](data[1]);}
				}
			});
		});
	});
</script>