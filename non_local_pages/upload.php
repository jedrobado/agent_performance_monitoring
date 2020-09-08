<?php $page_title='Upload CSV To Database';?>
<?php include('../template/start.php');?>
<script>var side_nav=[2,1];</script>
<!-- content -->
<div class="row">
	<div class="col-md-6 col-sm-12 col-12 mb-1">
		<div class="card">
			<div class="card-header">
				Upload Daily Scores
			</div>
			<div class="card-body">
				<form method="POST">
					<label class="float-left text-deep-purple2 mb-0">Select CSV File</label>
					<div class="input-group">
						<div class="custom-file mb-1">
							<input type="file" class="custom-file-input" id="file_input" name="file" required>
							<label class="custom-file-label text-truncate" for="file_input">Choose file & date</label>
						</div>
					</div>
					<input type="date" class="form-control" id="date_input" name="date" required aria-describedby="date_label">
    				<small id="date_label" class="form-text text-muted">Make sure to fill out all fields.</small>
					<button class="btn btn-info btn-sm" type="submit" name="show_content">Show Content</button>
					<button class="btn btn-primary btn-sm" type="submit" name="upload_content">Upload Content</button>
				</form>
			</div>
		</div>
	</div>
	<!-- <div class="col-md-6 col-sm-12 col-12 mb-1">
		<div class="card">
			<div class="card-header">
				Manage Uploads
			</div>
			<div class="card-body">
				<form method="POST">
					<label class="float-left text-deep-purple2 mb-0">Select Date</label>
					<input type="date" class="form-control" id="date_search" name="date" required aria-describedby="date_label">
					<button class="btn btn-info btn-sm" type="submit" name="show_uploaded">Show Uploaded</button>
				</form>
			</div>
		</div>
	</div> -->
	<div class="col-12">
		<div class="card">
			<div class="card-body" id="show_file_content">
				
			</div>
		</div>
	</div>
</div>
<!-- content -->
<?php include('../template/end.php');?>
<!-- process -->
<script type="text/javascript">
function manage(values){
	$.ajax({
		'url':'../processes/manage.php',
		'type':'POST',
		'dataType':'JSON',
		'data': values,
		'async':false,
		'processData': false,
		'contentType': false,
		success:function(data){
			if(data[0]==1){
				toastr["success"](data[2]);
				$("#show_file_content").html(data[1]);
			}
			if(data[0]==2){
				toastr["error"](data[1]);
			}
		}
	});
}
$(document).ready(function(){
	// manage
	$("button[name='show_uploaded']").click(function(e){
		e.preventDefault();
		var values = new FormData();
		values.append("type", "1");
		values.append("date", $('#date_search').val());
		manage(values);
	});
	// upload
	$("button[name='show_content']").click(function(e){
		e.preventDefault();
		var values = new FormData();
		values.append("type", "1");
		upload(values);
	});
	$("button[name='upload_content']").click(function(e){
		e.preventDefault();
		var values = new FormData();
		values.append("type", "2");
		upload(values);
	});
	function upload(values){
		values.append("date", $('#date_input').val());
		values.append("file", $('#file_input').prop('files')[0]);
		$.ajax({
			'url':'../processes/upload.php',
			'type':'POST',
			'dataType':'JSON',
			'data': values,
			'async':false,
			'processData': false,
			'contentType': false,
			success:function(data){
				if(data[0]==1){
					toastr["success"](data[2]);
					$("#show_file_content").html(data[1]);
				}
				if(data[0]==2){
					toastr["error"](data[1]);
				}
			}
		});
	}
});
</script>