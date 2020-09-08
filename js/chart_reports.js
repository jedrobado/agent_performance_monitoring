getCallReport();
function getCallReport()
    {
        {
            $.post("../processes/get_call_report.php", function(data)
            {
                console.log(data);
                var fullname=[];
                var quantity=[];
                var duration=[];
                var date=[];

                for (var i in data) {
                    fullname.push(data[i].fullname);
                    quantity.push(data[i].quantity);
                    duration.push(data[i].duration);
                    date.push(data[i].date);
                }

                var chartData = {
                    labels: fullname,
                    datasets:[
                        {
                            label:'Call Report',
                            backgroundColor:'#49e2ff',
                            borderColor:'#46d5f1',
                            hoverBackgroundColor:'#FF8800',
                            hoverBorderColor:'#666666',
                            data:quantity
                        }
                    ]
                };

                var graphTarget = $("#myChart");
                var barGraph = new Chart(graphTarget,{
                    type:'bar',
                    data:chartData
                });
            });
        }
    }