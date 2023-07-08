
    <div class="py-4 px-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <script>
        const barChart = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March'],
                datasets: [{
                    label: 'Data',
                    data: [10, 20, 15],
                    backgroundColor: 'blue'
                }]
            }
        });
    </script>

