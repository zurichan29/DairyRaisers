    <div class="py-4 px-6">
        <div class="bg-sky-300 rounded-lg shadow-lg p-6">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <script>
        const pieChart = new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    data: [12, 19, 3],
                    backgroundColor: ['red', 'blue', 'yellow']
                }]
            }
        });
    </script>
