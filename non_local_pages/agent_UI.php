<?php $page_title='Agent Performance';?>
<?php include('../include/connect.php');?>
<?php include('../include/session.php');?>
<?php include('../include/header.php');?>
<!-- content -->
<div class="container-fluid mt-1">
	<div class="row">
		<div class="col-md-10 col-sm-12 col-12 mb-1">
			<div class="card">
				<div class="card-header p-1 text-center">
					Agent Performance
				</div>
				<div class="card-body p-1">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-12 mb-1  animated fadeIn toggle_visibility option1">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="p-1 text-center align-middle" rowspan="2"><i class="fas fa-user-tie" data-toggle="tooltip" title="Name"></i><label class="mb-0 d-none d-lg-block"> Name</label></th>
										<th colspan="2" class="p-1 text-center"><i class="far fa-calendar" data-toggle="tooltip" title="Monday"></i> <label class="mb-0 d-none d-lg-block">Monday</label></th>
										<th colspan="2" class="p-1 text-center"><i class="far fa-calendar" data-toggle="tooltip" title="Tuesday"></i> <label class="mb-0 d-none d-lg-block">Tuesday</label></th>
										<th colspan="2" class="p-1 text-center"><i class="far fa-calendar" data-toggle="tooltip" title="Wednesday"></i> <label class="mb-0 d-none d-lg-block">Wednesday</label></th>
										<th colspan="2" class="p-1 text-center"><i class="far fa-calendar" data-toggle="tooltip" title="Thursday"></i> <label class="mb-0 d-none d-lg-block">Thursday</label></th>
										<th colspan="2" class="p-1 text-center"><i class="far fa-calendar" data-toggle="tooltip" title="Friday"></i> <label class="mb-0 d-none d-lg-block">Friday</label></th>
										<th colspan="2" class="p-1 text-center"><i class="far fa-calendar" data-toggle="tooltip" title="Saturday"></i> <label class="mb-0 d-none d-lg-block">Saturday</label></th>
										<th colspan="2" class="p-1 text-center"><i class="far fa-calendar" data-toggle="tooltip" title="Sunday"></i> <label class="mb-0 d-none d-lg-block">Sunday</label></th>
									</tr>
									<tr>
										<?php for($i=0; $i<7; $i++){?>
											<th class="p-1 text-center"><i class="fas fa-phone" data-toggle="tooltip" title="Quantity"></i></th>
											<th class="p-1 text-center"><i class="fas fa-clock" data-toggle="tooltip" title="Duration"></i></th>
										<?php }?>
									</tr>
								</thead>
								<tbody id="agent_breakdown">
									<!--  -->
								</tbody>
							</table>
						</div>
						<div class="col-md-12 col-sm-12 col-12 mb-1 animated fadeIn toggle_visibility option2 d-none">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="p-1 text-center" colspan="10" id="last_day_with_values"></th>
									</tr>
									<tr>
										<?php for($i=0; $i<3; $i++){?>
											<th class="p-1 text-center align-middle"><i class="fas fa-user-tie" data-toggle="tooltip" title="Name"></i></th>
											<th class="p-1 text-center"><i class="fas fa-phone" data-toggle="tooltip" title="Quantity"></i></th>
											<th class="p-1 text-center"><i class="fas fa-clock" data-toggle="tooltip" title="Duration"></i></th>
										<?php }?>
									</tr>
								</thead>
								<tbody id="agent_breakdown_row">
								<!--  -->
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2 col-sm-12 col-12 mb-1">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12 mb-1 animated fadeIn">
					<div class="card">
						<div class="card-header p-1 text-center">
							Weekly Average
						</div>
						<div class="card-body p-1" id="weekly_average">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center p-1"><i class="fas fa-phone" data-toggle="tooltip" title="Average Quantity"></i></th>
										<th class="text-center p-1" id="average_quantity">0</th>
									</tr>
									<tr>
										<th class="text-center p-1"><i class="fa fa-clock" data-toggle="tooltip" title="Average Duration"></i></th>
										<th class="text-center p-1" id="average_duration">0</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-12 mb-1 animated fadeIn">
					<div class="card">
						<div class="card-header p-1 text-center">
							Weekly Total
						</div>
						<div class="card-body p-1" id="weekly_average">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center p-1"><i class="fas fa-phone" data-toggle="tooltip" title="Weekly Total Quantity"></i></th>
										<th class="text-center p-1" id="weekly_total_quantity">0</th>
									</tr>
									<tr>
										<th class="text-center p-1"><i class="fa fa-clock" data-toggle="tooltip" title="Weekly Total Duration"></i></th>
										<th class="text-center p-1" id="weekly_total_duration">0</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-12 mb-1 animated fadeIn">
					<div class="card">
						<div class="card-header p-1 text-center">
							Weekly Breakdown
						</div>
						<div class="card-body p-1" id="weekly_average">
							<?php
								$weekly_array=array("Monday"=>array("0_quantity","0_duration"),"Tuesday"=>array("1_quantity","1_duration"),"Wednesday"=>array("2_quantity","2_duration"),"Thursday"=>array("3_quantity","3_duration"),"Friday"=>array("4_quantity","4_duration"),"Saturday"=>array("5_quantity","5_duration"),"Sunday"=>array("6_quantity","6_duration"));
								foreach ($weekly_array as $key => $value) {
							?>
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="text-center p-1" colspan="2"><?php echo $key;?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center p-1"><i class="fas fa-phone" data-toggle="tooltip" title="Total Quantity"></i></td>
											<td class="text-center p-1" id="<?php echo $value[0]; ?>">0</td>
										</tr>
										<tr>
											<td class="text-center p-1"><i class="fa fa-clock" data-toggle="tooltip" title="Total Duration"></i></td>
											<td class="text-center p-1" id="<?php echo $value[1]; ?>">0</td>
										</tr>
									</tbody>
								</table>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-12 mb-1">
					<div class="card">
						<div class="card-header p-1 text-center">
							Display Options
						</div>
						<div class="card-body p-1 text-center">
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input toggle_group" id="option1" checked>
								<label class="custom-control-label" for="option1">Full Details</label>
							</div>
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input toggle_group" id="option2">
								<label class="custom-control-label" for="option2">Essential Details</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- content -->
<?php include('../include/footer.php');?>
<?php include('../include/modal.php');?>
<?php include('../include/bottom.php');?>
<!-- process -->
<script type="text/javascript">
	$(document).ready(function(){
		$(".toggle_group").click(function(){
			$(".toggle_visibility").addClass("d-none");
			$("."+$(this).attr('id')).removeClass("d-none");
			$("input").prop("checked", false);
			$(this).prop("checked", true);
		});
		setInterval(function(){
            $.ajax({
                url:'../processes/agent_UI.php',
                type:'POST',
                dataType:'JSON',
                async:false,
                success:function(data){
                	$("#agent_breakdown").html(data[0][0]);
                	for (var i = 0; i < data[1][0].length; i++) {
                		$("#"+i+"_quantity").text(data[1][0][i][0]);
                		$("#"+i+"_duration").text(data[1][0][i][1]);
                	}
                	$("#average_quantity").html(data[3][0]);
                	$("#average_duration").html((Math.round(parseFloat(data[3][1])*100)/100));
                	$("#weekly_total_quantity").html(data[2][0]);
                	$("#weekly_total_duration").html((Math.round(parseFloat(data[2][1])*100)/100));
                	var last_day_with_values=Object.keys(data[4]);
                	$("#last_day_with_values").html(last_day_with_values);
                	$("#agent_breakdown_row").html(data[4][last_day_with_values]);
                }
            });
        }, 1000);
	});
</script>