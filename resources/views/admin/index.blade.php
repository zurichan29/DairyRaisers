@extends('layouts.admin')
@section('content')
    {{-- <h1>Hello {{ auth()->guard('admin')->user()->name }}</h1> --}}

    <div class="">
        <div class="row mb-3">
            <div class="col">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                    Staff</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $staffs->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-user-tie fa-3x text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                    Buffalos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $buffalos->sum('quantity') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-cow fa-3x text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                    Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $products->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-bottle-water fa-3x text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                    Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $orders->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-truck-moving fa-3x text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
                <!-- Pie Chart -->
                <div class="col-xl-4 col-lg-5 w-100">
                    <div class="card shadow h-100 d-flex flex-pill">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-start">
                            <h6 class="m-0 font-weight-bold text-primary">BUFFALOS BY CATEGORY</h6>

                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="buffaloChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Area Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow h-100 flex flex-pill">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-start">
                            <h6 class="m-0 font-weight-bold text-primary">PRODUCT STOCKS BY VARIANTS</h6>
                           
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="productStocksChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


          

            {{-- <div class="col">
                <div class="card shadow h-100 d-flex flex-fill">
                    <div class="card-header py-3">
                        <div class="row">
                            <h6 class="m-0 font-weight-bold text-primary">BUFFALOS BY CATEGORY</h6>
                        </div>
                    </div>
                    <div class="card-body p-2 flex-fill" style="height: 250px;">
                        <div style="position: relative; height:100%;">
                            <canvas id="buffaloChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow h-100 d-flex flex-fill ">
                    <div class="card-header py-3">
                        <div class="row">
                            <h6 class="m-0 font-weight-bold text-primary">PRODUCT STOCKS BY VARIANTS</h6>
                        </div>
                    </div>
                    <div class="card-body p-3 flex-fill" style="height: 250px;">
                        <div style="position: relative; height:100%;">
                            <canvas id="productStocksChart"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="card shadow ">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-md-8 d-flex justify-content-start align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">TOTAL MONTHLY SALES</h6>
                                <form id="monthlySalesYearFilter" class="d-flex ml-3">
                                    @csrf
                                    <div class="mr-2">
                                        <select id="year" name="year" class="form-select form-select-sm">
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}"
                                                    @if ($currentYear == $year) selected @endif>
                                                    {{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                                </form>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end align-items-center">
                                <button id="downloadButton" type="button" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-print"></i> Download
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="" style="height: 200px">
                            <canvas id="monthlySalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="card shadow h-100 d-flex flex-fill">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="row d-flex justify-content-between">
                            <div class="col d-flex justify-content-start align-items-center">
                                <h6 class="m-0 font-weight-bold">RECENT ORDERS</h6>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-light">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="ordersTable" width="100%" style="font-size: 14px"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ORDER NO</th>
                                        <th>STATUS</th>
                                        <th>METHOD</th>
                                        <th>DATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        @php
                                            $statusBadge = null;
                                            $icon = null;
                                            switch ($order->status) {
                                                case 'Pending':
                                                    $statusBadge = 'badge-info';
                                                    $icon = 'fa-solid fa-spinner me-1';
                                                    break;
                                                case 'Approved':
                                                    $statusBadge = 'badge-primary';
                                                    $icon = 'fa-solid fa-thumbs-up me-1';
                                                    break;
                                                case 'On The Way':
                                                    $statusBadge = 'badge-warning';
                                                    $icon = 'fa-solid fa-truck-fast me-1';
                                                    break;
                                                case 'Ready To Pick Up':
                                                    $statusBadge = 'badge-warning';
                                                    $icon = 'fa-solid fa-box-archive me-1';
                                                    break;
                                                case 'Delivered':
                                                    $statusBadge = 'badge-success';
                                                    $icon = 'fa-solid fa-circle-check me-1';
                                                    break;
                                                case 'Recieved':
                                                    $statusBadge = 'badge-success';
                                                    $icon = 'fa-solid fa-circle-check me-1';
                                                    break;
                                                default:
                                                    break;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td class=" text-center">
                                                <p class="badge {{ $statusBadge }} text-center text-wrap py-2"
                                                    style="width: 8rem;">
                                                    <i class="{{ $icon }}"></i>
                                                    {{ $order->status }}
                                                </p>
                                            </td>
                                            <td>{{ $order->shipping_option }}</td>
                                            <td>{{ date('M d, Y', strtotime($order->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow h-100 d-flex flex-fill">
                    <div class="card-header text-white py-3">
                        <div class="row d-flex justify-content-between">
                            <div class="col d-flex justify-content-start align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">ACTIVITY LOGS</h6>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center">
                                <a href="{{ route('admin.activity_logs') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col">
                            @foreach ($logs as $log)
                                <div class="shadow border-start border-dark row fw-light mb-3 pb-0"
                                    style="font-size: 15px">
                                    <div class="">
                                        <p class=""> {{ $log->description }} </p>
                                    </div>
                                    <div class="">
                                        <p>{{ $log->created_at }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            var monthlySalesChart;
            var ordersTable = null;

            ordersTable = $('#ordersTable').DataTable();

            function initBuffaloChart() {
                // Data for the donut chart
                const data = {
                    labels: ['Baby Male', 'Adult Male', 'Baby Female', 'Adult Female'],
                    datasets: [{
                        data: @json($buffaloData),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                        hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    }, ],
                };

                // Configuration options for the donut chart
                const options = {
                    responsive: true,
                    maintainAspectRatio: false,
                };

                // Create the donut chart
                const ctx = document.getElementById('buffaloChart').getContext('2d');
                const donutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: options,
                });


            }

            function initProductStocksChart(labels, data) {
                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Product Stocks',
                        data: data,
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                    }],
                };

                const chartOptions = {
                    indexAxis: 'y',
                    maintainAspectRatio: false,
                    responsive: true,

                };

                const ctx = document.getElementById('productStocksChart').getContext('2d');
                const lineChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: chartOptions,
                });
            }

            function initMonthlySalesChart(labels, earningData) {
                if (monthlySalesChart) {
                    monthlySalesChart.destroy();
                }
                var chartlabels = labels;
                var earningData = earningData;

                var ctx = document.getElementById("monthlySalesChart").getContext("2d");
                monthlySalesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartlabels,
                        datasets: [{
                                label: 'Products',
                                backgroundColor: "#4e73df",
                                hoverBackgroundColor: "#2e59d9",
                                data: earningData.map(data => data[0]),
                            },
                            {
                                label: 'Buffalo',
                                backgroundColor: "#1cc88a",
                                hoverBackgroundColor: "#17a673",
                                data: earningData.map(data => data[1]),
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                                time: {
                                    unit: 'month'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 12
                                },
                                maxBarThickness: 25,
                            },
                            y: {
                                stacked: true,
                                ticks: {
                                    min: 0,
                                    max: 15000,
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    callback: function(value, index, values) {
                                        return '₱' + value;
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }

                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var datasetLabel = context.dataset.label || '';
                                        var value = context.parsed.y;
                                        return datasetLabel + ': ₱' + value
                                            .toLocaleString(); // Add .toLocaleString() to format the value with commas and a peso sign
                                    }
                                }
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 12,
                                fontColor: '#858796'
                            }
                        },
                    }
                });
            }

            $('#monthlySalesYearFilter').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.sales_report.update-year') }}',
                    data: formData,
                    success: function(response) {
                        var labels = response.labels;
                        var earningData = response.earningData;
                        initMonthlySalesChart(labels, earningData);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            const productStocksData = <?php echo json_encode($productStocksDatasets); ?>;
            const productStocksLabels = <?php echo json_encode($productStocksLabels); ?>;
            const stocksData = productStocksData.map(item => item.data);

            initProductStocksChart(productStocksLabels, stocksData);
            initBuffaloChart();
            initMonthlySalesChart(@json($monthlySalesLabel), @json($earningData));

             //Download Chart
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById("downloadButton").addEventListener("click", function () {
                    // Get the chart image data from the canvas
                    var chartImageData = document.getElementById("monthlySalesChart").toDataURL("application/octet-stream");
            
                    // Log the chart image data to the console for debugging
                    console.log(chartImageData);

                    // Redirect the user to the chart download route with the image data
                    window.location.href = "{{ route('admin.dashboard.download-chart') }}" + "?chartImageData=" + encodeURIComponent(chartImageData);

                    
                });
            });

        });
    </script>
@endsection
