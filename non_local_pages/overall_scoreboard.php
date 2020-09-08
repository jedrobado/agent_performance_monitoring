<?php $page_title='Overall Score Board';?>
<?php include('../template/start.php');?>
<script>var side_nav=[1,1];</script>
<!-- content -->
<div class="row">
	<div class="col-md-6 col-sm-6 col-12 mb-1">
		<div class="card">
			<div class="card-header p-1">
				Choose Search Options
			</div>
			<div class="card-body p-1">
                <form method="POST" id="search">
					<div class="input-select">
						<select class="browser-default custom-select mb-1 category" name="category" required>
							<option value="1">Daily</option>
							<option value="2">Weekly</option>
							<option value="3">Monthly</option>
							<option value="4">Yearly</option>
							<option value="5">Search (Slow Search)</option>
						</select>
					</div>
					<div class="input-select">
						 <input type="date" class="form-control date1" name="date1" hidden> 
                          <label class="label_to" hidden> To </label> 
                         <input type="date" class="form-control date2" name="date2" hidden>
					</div>
					<button class="btn btn-primary btn-sm">Seach</button>
                </form>
			</div>
		</div>
	</div>
    <div class="col-md-6 col-sm-6 col-12 mb-1">
        <div class="card">
            <div class="card-header p-1">
                Agent UI Tracker
            </div>
            <div class="card-body p-1">
                <a href="agent_UI.php" target="_blank" class="btn btn-primary btn-sm">Open</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12 col-12 mb-1">
        <div class="card">
            <div class="card-header p-1">Total Results By Date</div>
            <div class="card-body p-1">
                <div class="table-responsive-sm" id="total_result">
                </div>  
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-12 mb-1">
		<div class="card">
		    <div class="card-header p-1">Dates Summation</div>
		    <div class="card-body p-1">
		        <div class="table-responsive-sm" id="daily_total_result">  
		        </div>  
				<div>
					<canvas id="breakdown1"></canvas> 
				</div>
				<div>
		        	<canvas id="breakdown2"></canvas> 
		    	</div>
		    </div>
		</div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-12 mb-1">
        <div class="card">
            <div class="card-header p-1">
                Total Results By Date (Chart)
            </div>
            <div class="card-body p-1">
            	<div>
                	<canvas id="breakdown3"></canvas>
            	</div>
            	<div>
                	<canvas id="breakdown4"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-12 mb-1">
        <div class="card">
            <div class="card-header p-1">Agent Output By Date</div>
            <div class="card-body p-1">
                <div class="table-responsive-sm" id="table_result">
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
    var category="";
    var date1="";
    var date2="";
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
        });


        setInterval(function(){
            if(category!="") {
                $.ajax({
                    url:'../processes/search_agent_scoreboard.php',
                    type:'POST',
                    dataType:'JSON',
                    async:false,
                    data:{date1:date1,date2:date2,category:category},
                    success:function(data){
                        var total_result="";
                        var total_quantity=[];
                        var total_duration=[];
                        //Agent Output By Date
                        total_result+='<table class="table table-hover table-bordered table-fixed table-striped text-center"><thead><tr><th rowspan=2 class="p-1">Name</th>';
                        for (var i=0; i<data[0].length; i++) { total_result+='<th class="p-1" colspan=2>'+data[0][i]+'</th>';} // Name Loop
                        total_result+="</tr><tr>";
                        for (var i = 0; i<data[0].length; i++) { total_result+='<th class="p-1">No of Calls</th><th class="p-1">Total Hours</th>';} //Head Loop
                        total_result+="</tr></thead><tbody>";
                        for (var i=0; i < data[1].length; i++) {
                            total_result+="<tr><td class='p-1'>"+data[1][i]+"</td>";
                                for (var j = 0; j < data[0].length; j++) {
                                    total_result+="<td class='p-1'>"+data[2][i][data[0][j]]+"</td><td class='p-1'>"+data[3][i][data[0][j]]+"</td>";
                                }
                            total_result+="</tr>";
                        }
                        total_result+='</tbody></table>';
                        $("#table_result").html(total_result);
                        //Total Results By Date
                        var total_result="";
                        total_result+='<table class="table table-hover table-bordered table-fixed table-striped text-center"><thead><tr><th class="p-1">Date</th><th class="p-1">Total Calls</th><th class="p-1">Total Hours</th></tr></thead><tbody>';
                        for (var i=0; i < data[0].length; i++) {
                            var quantity=0;
                            var duration=0;
                            for (var j=0; j<data[1].length; j++) {
                                quantity+=data[2][j][data[0][i]];
                                duration+=data[3][j][data[0][i]];
                            }
                            total_quantity[data[0][i]]=quantity;
							total_duration[data[0][i]]=(Math.round(parseFloat(duration)*100)/100);
                            total_result+="<tr><td class='p-1'>"+data[0][i]+"</td><td class='p-1'>"+(Math.round(parseFloat(quantity)*100)/100)+"</td><td class='p-1'>"+(Math.round(parseFloat(duration)*100)/100)+"</td></tr>";
                        }
                        total_result+='</tbody></table>';
                        $("#total_result").html(total_result);
                        //Dates Summation
                        var daily_total_result="";
                        daily_total_result+='<table class="table table-hover table-bordered table-fixed table-striped text-center"><thead><tr><th class="p-1"></th><th class="p-1">Daily Total</th></tr></thead><tbody><tr><td class="p-1">Total Calls</td><td class="p-1">'+data[5][0]+'</td></tr><tr><td class="p-1">Total Hours</td><td class="p-1">'+data[5][1]+'</td></tr></tbody></table>';
                        $("#daily_total_result").html(daily_total_result);
                        update_new(barChartData1,chart_breakdown1,"Total Calls",["Total Calls"],{"Total Calls":data[5][0]});
                        update_new(barChartData2,chart_breakdown2,"Total Duration",["Total Duration"],{"Total Duration":data[5][1]});
                        update_new(barChartData3,chart_breakdown3,"Calls By Date",data[0],total_quantity);
                        update_new(barChartData4,chart_breakdown4,"Duration By Date",data[0],total_duration);
                },
                error:function(data){
                    $("#total_Hours").html("<h1 class='text-center'>Connection Problems</h1>");
                    $("total_calls").html("<h1 class='text-center'>Connection Problems</h1>");
                    $("#display_result").html("<tr><td colspan='16'><h3 class='alert text-center' style='background-color:#ffbb33;'><span class='fa fa-info-circle'></span> Connection Problems</h3></td></tr>");
                },
            });
        }
    }, 2000);
});
</script>