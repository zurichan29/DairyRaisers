@extends('layouts.admin')
@section('content')
    <h1>Hello {{ auth()->guard('admin')->user()->first_name }}</h1>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded shadow-sm p-4">
            <h1 class="text-2xl font-bold mb-4">Manage Buffalo List</h1>

            <!-- Add the select dropdown for selecting a product -->
            <div class="mb-4">
                <label for="buffalo" class="block text-gray-700 font-semibold mb-2">Select Buffalo</label>
                <select name="buffalo" id="buffalo" class="form-select rounded-md border-gray-300">
                    @foreach
                        <option value=""></option>
                    @endforeach
                </select>
            </div>

            <!-- Add the form for adding product stock -->
            <div id="addStockFormContainer" class="hidden">
                <h2 class="text-xl font-bold mb-4">Add Buffalo</h2>
                <form id="addStockForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="buffalo_id" id="buffalo_id">
                    <input type="hidden" name="date_created" id="date_created">
                    <div class="mb-4">
                        <label for="buffalo_quantity" class="block text-gray-700 font-semibold mb-2">Buffalo Quantity</label>
                        <input type="number" name="stock" id="buffalo_quantity"
                            class="form-input rounded-md border-gray-300">
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add
                            Buffalo</button>
                    </div>
                </form>
            </div>

            <!-- Add the graph container -->
            <div>
                <canvas id="stockChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Add the JavaScript code to handle form submission and update the chart -->
    <script>
        // Get the product select dropdown and the add stock form
        const productSelect = document.getElementById('product');
        const addStockFormContainer = document.getElementById('addStockFormContainer');
        const addStockForm = document.getElementById('addStockForm');
        const productIDInput = document.getElementById('product_id');
        const stockChartElement = document.getElementById('stockChart');

        // Create the initial chart instance
        let chartInstance = null;

        // Function to create the chart instance
        function createChart(labels, datasets) {
            const ctx = stockChartElement.getContext('2d');
            return new Chart(ctx, {
                type: 'bar', // Change the chart type as per your requirement
                data: {
                    labels: labels,
                    datasets: datasets,
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    animation: {
                        duration: 500, // Animation duration in milliseconds
                    },
                },
            });
        }

        // Function to load stock data for the selected product
        function loadStockData(productId) {
            // Show the add stock form and set the product ID
            addStockFormContainer.classList.remove('hidden');
            productIDInput.value = productId;

            // Make an AJAX request to fetch the stock data for the selected product
            fetch(`/admin/products/stock/${productId}`)
                .then(response => response.json())
                .then(data => {
                    // Destroy the existing chart instance if it exists
                    if (chartInstance !== null) {
                        chartInstance.destroy();
                    }

                    // Create a new chart instance with the updated data
                    chartInstance = createChart(data.labels, [{
                        label: 'Stock Quantity',
                        data: data.datasets[0].data,
                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1,
                    }]);
                })
                .catch(error => {
                    console.log(error);
                });
        }

        // Add an event listener to the product select dropdown
        productSelect.addEventListener('change', function() {
            const productId = this.value;

            // Show the add stock form and set the product ID
            addStockFormContainer.classList.remove('hidden');
            productIDInput.value = productId;

            // Load stock data for the selected product
            loadStockData(productId);
        });

        // Add an event listener to the add stock form for form submission
        addStockForm.addEventListener('submit', function(event) {
            event.preventDefault();

            // Get the form data
            const formData = new FormData(this);

            // Make an AJAX request to add product stock
            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    // Update the chart data and labels
                    chartInstance.data.labels = data.labels;
                    chartInstance.data.datasets[0].data = data.datasets[0].data;

                    // Update the chart
                    chartInstance.update();
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    // Reset the form
                    addStockForm.reset();
                });
        });

        // Automatically select the first product and load the necessary graph
        const firstProductId = productSelect.options[0].value;
        loadStockData(firstProductId);
    </script>
@endsection
