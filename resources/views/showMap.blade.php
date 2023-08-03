
<!-- Show Graph Data -->
<script src="https://cdnjs.com/libraries/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>

<div style="display:flex; margin-bottom:4rem;">
    <div class="map_canvas mt-4" style="width:70%; background-color:white; box-shadow: 13px 13px 13px #cbced1, -13px -13px 13px #fff;">
        <canvas id="myChart" width="auto" height="100"></canvas>
    </div>
    <div style="margin-left:20px; padding:50px; width:30%; box-shadow: 13px 13px 13px #cbced1, -13px -13px 13px #fff;">
        <h5 style="margin-bottom: 25px;">Legend:</h5>
        <h6 style="">🟦 Milk</h6>
        <h6>🟩 Buffalo</h6>
        
    </div>
</div>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($milkStock) ?>,
        datasets: [{
            label: '',
            data: <?php echo json_encode($milkStock); ?>,
            backgroundColor: [
                'rgba(31, 58, 147, 1)',
                'rgba(37, 116, 169, 1)',
                'rgba(92, 151, 191, 1)',
                'rgb(200, 247, 197)',
                'rgb(77, 175, 124)',
                'rgb(30, 130, 76)'
            ],
            borderColor: [
                'rgba(31, 58, 147, 1)',
                'rgba(37, 116, 169, 1)',
                'rgba(92, 151, 191, 1)',
                'rgb(200, 247, 197)',
                'rgb(77, 175, 124)',
                'rgb(30, 130, 76)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                max: 200,
                min: 0,
                ticks: {
                    stepSize: 20
                }
            }
        },
        plugins: {
            title: {
                display: false,
                text: 'Custom Chart Title'
            },
            legend: {
                display: false,
            }
        }
    }
});
</script>