<?php $page_title='Web App Login';?>
<?php include('../include/connect.php');?>
<?php include('../include/session.php');?>
<?php include('../include/header.php');?>
<link href="../css/custom_styles/index_style.css" rel="stylesheet">
<!-- content -->
<section>
	<div class="bg">
		<div class="apply-gradient d-flex justify-content-center align-items-center">
			<div class="container">
				<div class="row">
					<div class="col-md-6 d-none d-md-block wow fadeIn" data-wow-delay="0.3s">
						<div class="card align-self-center intro-card z-depth-0">
							<div class="card-body">
								<h1 class="h1-responsive font-weight-bold mt-sm-4">Web App Login</h1>
								<hr class="border-white">
							</div>
						</div>
					</div>
					<div class="col-md-6 wow fadeIn">
						<div class="card card-image align-self-center login-card">
							<div class="card-body apply-gradient-login-card">
								<form class="text-center p-2 text-white" method="POST" onsubmit="confirmation('login_form');return false;" id="login_form">
									<p class="h4 mb-1 pt-2">Sign in</p>
								    <input type="text" class="form-control mb-1" placeholder="Username" required name="username">
								    <input type="password" class="form-control mb-1" placeholder="Password" required name="password">
									<label>Type</label>
								    <select class="browser-default custom-select mb-1" required name="type">
										<option selected disabled value=""></option>
										<option value="local">Local</option>
										<option value="non_local">Non-Local</option>
								    </select>
								    <button class="btn btn-default teal darken-4 darken-1 btn-block my-2 m-0" type="submit" name="submit"><i class="far fa-paper-plane"></i> &nbsp Sign in</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- content -->
<?php include('../include/bottom.php');?>
<?php include('../include/modal.php');?>
<!-- process -->
<script type="text/javascript">
function login_form(form_id){
	$("button[type='submit']").attr("disabled","disabled");
	var submit_values=$("#"+form_id).submit();
	var data={};
	submit_values.find('[name]').each(function(index, value){
		var element=$(this);
		name=element.attr('name');
		value=element.val();
		data[name]=value;
	});
	$.ajax({
		'url':'../processes/login_process.php',
		'type':'POST',
		'dataType':'JSON',
		'data': data,
		success:function(data){
			if(data[1]==2){
				$("button[type='submit']").removeAttr("disabled");
				toastr["error"](data[0]);
			}
			// message_modal(data[0],data[1]);
			if(data[1]==1){
				toastr["success"](data[0]);
				setInterval(function(){
					location.reload();
				},1000);
			}
		}
	});
}
</script>
<!-- process -->