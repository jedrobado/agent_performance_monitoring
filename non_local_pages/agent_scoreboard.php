<?php $page_title="Agent Score Board"; ?>
<?php include('../template/start.php');?>
<script>var side_nav=[1,2];</script>
<!-- content -->
<div class="row">
	<div class="col-md-6 col-sm-12 col-12 mb-1">
		<div class="card">
			<div class="card-header p-1">
				Choose Search Options
			</div>
			<div class="card-body p-1">
				<form method="POST" id="search">
					<div class="input-group">
						<select class="browser-default custom-select custom-select-sm mb-1 category" required>
							<option value="1">Daily</option>
							<option value="2">Weekly</option>
							<option value="3">Monthly</option>
							<option value="4">Yearly</option>
							<option value="5">Search (Slow Search)</option>
						</select>
					</div>
					<div class="input-group">
						<select class="browser-default custom-select custom-select-sm mb-1 agent" required>
							<?php
								$get_agents=getData("SELECT DISTINCT(fullname) FROM call_report");
								foreach ($get_agents as $agents) {
									echo "<option value='".$agents->fullname."'>".ucfirst(strtolower($agents->fullname))."</option>";
								}
							?>
						</select>
					</div>
					<div class="input-group slow-search">
						<input type="date" class="form-control form-control-sm date1" hidden> <label class="label_to" hidden>&nbsp To &nbsp</label> 
						<input type="date" class="form-control form-control-sm date2" hidden>
					</div>
					<button class="btn btn-primary btn-sm search">Search</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-12 mb-1">
		<div class="card">
			<div class="card-header p-1">
				Breakdown
			</div>
			<div class="card-body p-1">
				<div class="row custom_responsive_1">
					<div class="col-12"><canvas id="breakdown1"></canvas></div>
					<div class="col-12"><canvas id="breakdown2"></canvas></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 col-12 mb-1">
		<div class="card">
			<div class="card-header p-1">
				Output List
			</div>
			<div class="card-body p-1">
				<table class="table table-hover table-bordered table-fixed table-striped text-center">
					<thead>
						<tr>
							<th class="p-1">Name</th>
							<th class="p-1">Quantity</th>
							<th class="p-1">Duration</th>
							<th class="p-1">Date</th>
						</tr>
					</thead>
					<tbody id="table_view"></tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 col-12 mb-1">
		<div class="card">
			<div class="card-header p-1">
				Summation
			</div>
			<div class="card-body p-1">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-12"><canvas id="breakdown3"></canvas></div>
					<div class="col-md-6 col-sm-12 col-12"><canvas id="breakdown4"></canvas></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--content-->
<?php include('../template/end.php');?>
<!-- process -->
<script>
	$(document).ready(function(){
		var date1="";
		var date2="";
		var agent="";
		var category="";
		// bar chart 1
		var barChartData1 = {labels: [],datasets: [{label: '',data: []}]};
		var breakdown1 = document.getElementById('breakdown1').getContext('2d');
		var chart_breakdown1 = new Chart(breakdown1, {type: 'bar',data: barChartData1,options: {plugins: {datalabels: {anchor :'end',align :'center',}},showAllTooltips: true, animation: false, responsive: true,maintainAspectRatio: false,responsive: true,scales:{yAxes:[{ticks:{beginAtZero: true}}]},}});
		// bar chart 2
		var barChartData2 = {labels: [],datasets: [{label: '',data: []}]};
		var breakdown2 = document.getElementById('breakdown2').getContext('2d');
		var chart_breakdown2 = new Chart(breakdown2, {type: 'bar',data: barChartData2,options: {plugins: {datalabels: {anchor :'end',align :'center',}},showAllTooltips: true, animation: false, responsive: true,maintainAspectRatio: false,responsive: true,scales:{yAxes:[{ticks:{beginAtZero: true}}]},}});
		// bar chart 3
		var barChartData3 = {labels: [],datasets: [{label: '',data: []}]};
		var breakdown3 = document.getElementById('breakdown3').getContext('2d');
		var chart_breakdown3 = new Chart(breakdown3, {type: 'bar',data: barChartData3,options: {plugins: {datalabels: {anchor :'end',align :'center',}},showAllTooltips: true, animation: false, responsive: true,maintainAspectRatio: false,responsive: true,scales:{yAxes:[{ticks:{beginAtZero: true}}]},}});
		// bar chart 4
		var barChartData4 = {labels: [],datasets: [{label: '',data: []}]};
		var breakdown4 = document.getElementById('breakdown4').getContext('2d');
		var chart_breakdown4 = new Chart(breakdown4, {type: 'bar',data: barChartData4,options: {plugins: {datalabels: {anchor :'end',align :'center',}},showAllTooltips: true, animation: false, responsive: true,maintainAspectRatio: false,responsive: true,scales:{yAxes:[{ticks:{beginAtZero: true}}]},}});

		// update_new(barChartData,chart_breakdown);
		function update_new(barChartData,chart_breakdown,dataset_label,data_label,data_values){
			// remove dataset
			barChartData.datasets.pop();
			chart_breakdown.update();
			// remove data
			barChartData.labels.splice(0, barChartData.labels.length);
			barChartData.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});
			chart_breakdown.update();
			// add dataset with datas and labels
			var newDataset = {
				label: dataset_label,
				data: []
			};
			for (var i = 0; i < data_label.length; i++) {
				newDataset.data.push(data_values[data_label[i]]); //value
				barChartData.labels.push(data_label[i]); //label
			}
			barChartData.datasets.push(newDataset);
			chart_breakdown.update();
			// chart
		}
		$(".category").change(function(){
			if($(".category option:selected").val()=="5"){
				$(".date1").prop("hidden",false);
				$(".label_to").prop("hidden",false);
				$(".date2").prop("hidden",false);
			}
			else{
				$(".date1").prop("hidden",true);
				$(".label_to").prop("hidden",true);
				$(".date2").prop("hidden",true);
			}
        });
		$("#search").submit(function(e){
			e.preventDefault();
			category=$(".category option:selected").val();
			date1=$(".date1").val();
			date2=$(".date2").val();
			agent=$(".agent").val();
		});
		setInterval(function(){
			if(agent!="" && category!=""){
				$.ajax({
					'url':'../processes/get_agent_scoreboard.php',
					'type':'POST',
					'dataType':'JSON',
					'async':false,
					'data':{send_category:category,send_date1:date1,send_date2:date2,send_agent:agent},
					success:function(data){
						table_results="";
						for (var i = 0; i < data[0].length; i++) {
							table_results+="<tr><td class='p-1'>"+data[0][i]['fullname']+"</td><td class='p-1'>"+data[0][i]['quantity']+"</td><td class='p-1'>"+data[0][i]['duration']+"</td><td class='p-1'>"+data[0][i]['date']+"</td></tr>";
						}
						$("#table_view").html(table_results);
						label1=["Total Quantity"];
						label2=["Total Duration (Hours)"];
						update_new(barChartData1,chart_breakdown1,data[1][0],data[2][0],data[4][0]);
						update_new(barChartData2,chart_breakdown2,data[1][1],data[2][0],data[5][0]);
						update_new(barChartData3,chart_breakdown3,data[3][0],label1,data[6][0]);
						update_new(barChartData4,chart_breakdown4,data[3][1],label2,data[7][0]);
					}
				});
			}
		}, 2000);
	});
</script>