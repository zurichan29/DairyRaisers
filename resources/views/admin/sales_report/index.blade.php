@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <link rel="stylesheet" href="{{ asset('css/sales-print.css') }}" media="print">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-8 d-flex justify-content-start align-items-center">
                        <h5 class="m-0 font-weight-bold text-primary">TOTAL MONTHLY SALES</h5>
                        <form id="filterForm" class="d-flex ml-3">
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
                        <button id="downloadChartButton" type="button" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-print"></i> Download
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-8 d-flex justify-content-start align-items-center">
                        <h5 class="m-0 font-weight-bold text-primary">DAILY SALES (₱)</h5>
                        <div class="d-flex ml-3">
                            <input type="text" class="form-control form-control-sm ml-3" id="dateRange"
                                placeholder="Select date range" autocomplete="off">
                        </div>
                        <div class="d-flex ml-3">
                            <select lect id="categoryFilter" name="categoryFilter" class="form-select form-select-sm mr-2">
                                <option value="">All</option>
                                <option value="Products">Products</option>
                                <option value="Buffalo">Buffalo</option>
                            </select>
                            <button type="button" id="applyCategoryFilterBtn" class="btn btn-sm btn-primary">Apply</button>
                        </div>
                    </div> <!-- COPY, PRINT, CSV AND EXCEL BUTTON -->
                    <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <button type="button" id="copy" class="mr-2 btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-copy"></i> Copy
                        </button>
                        <button type="button" id="downloadExcelButton" class="mr-2 btn btn-sm btn-outline-primary">
                            <i class="fa-regular fa-file-excel"></i> Excel
                        </button>
                        <button type="button" id="printButton" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" style="font-size: 14px"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>NAME</th>
                                <th>CATEGORY</th>
                                <th>PRICE</th>
                                <th>QTY</th>
                                <th>TOTAL SALES</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:right">Total:</th>
                                <th id="totalSalesValue"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- CHART --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

        {{-- PRINT, EXCEL, AND COPY SOURCE --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.0.63/print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
        </script>

        <script>
            $(document).ready(function() {
                var myBarChart;
                var dataTable = null;
                var currentDataTablePage = 1;

                dataTable = $('#dataTable').DataTable();

                $('#dateRange').daterangepicker({
                    opens: 'right',
                    autoUpdateInput: false,
                });

                $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                        'YYYY-MM-DD'));

                    var startDate = picker.startDate.format('YYYY-MM-DD');
                    var endDate = picker.endDate.format('YYYY-MM-DD');
                    var category = $('#categoryFilter').val();
                    console.log(startDate);
                    console.log(endDate);
                    refreshDataTable(startDate, endDate, category);
                });

                // Add event listener for clearing the date range
                $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
                    // Clear the input field value
                    $(this).val('');
                });

                // Footer callback function
                function footerCallback() {
                    var api = this.api();
                    var totalSalesColumn = api.column(5).data()
                        .toArray(); // Use column index 4 for the 'total_sales' column

                    // Calculate the sum of total sales column
                    var totalSalesSum = totalSalesColumn.reduce(function(acc, val) {
                        return acc + parseFloat(val);
                    }, 0);

                    // Update the footer cell with the calculated total sales value
                    $('#totalSalesValue').html('₱' + totalSalesSum.toFixed(2));
                }

                // Function to initialize DataTable
                function initializeDataTable(data) {
                    dataTable = $('#dataTable').DataTable({
                        data: data,
                        columns: [{
                                data: 'created_at',
                                title: 'DATE',
                                render: function(data) {
                                    return moment(data).format('YYYY-MM-DD');
                                }
                            }, {
                                data: 'name',
                                title: 'NAME'
                            },
                            {
                                data: 'category',
                                title: 'CATEGORY'
                            },
                            {
                                data: 'price',
                                title: 'PRICE'
                            },
                            {
                                data: 'quantity',
                                title: 'QTY'
                            },
                            {
                                data: 'total_sales',
                                title: 'TOTAL SALES',
                                render: function(data, type, row) {
                                    return '₱' + data;
                                }
                            },
                        ],
                        footerCallback: footerCallback
                    });
                }

                // Function to fetch updated data and refresh DataTable
                function refreshDataTable(startDate, endDate, category) {
                    // Save the current page number before refreshing the table
                    currentDataTablePage = dataTable.page.info().page + 1;
                    // Get the CSRF token value
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.sales_report.daily-sales') }}",
                        type: "POST",
                        data: {
                            start_date: startDate,
                            end_date: endDate,
                            category: category,
                        },

                        success: function(response) {
                            // Call the function to initialize DataTable with updated data
                            // Destroy the existing DataTable instance before re-initializing with updated data
                            if (dataTable) {
                                dataTable.destroy();
                            }
                            initializeDataTable(response);
                            console.log(response);
                            // Restore the current page after the table is refreshed
                            dataTable.page(currentDataTablePage - 1).draw('page');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Event listener for the Apply Category Filter button
                $('#applyCategoryFilterBtn').click(function(e) {
                    e.preventDefault();
                    var dateRange = $('#dateRange').data('daterangepicker');
                    var startDate = dateRange.startDate.format('YYYY-MM-DD');
                    var endDate = dateRange.endDate.format('YYYY-MM-DD');
                    var category = $('#categoryFilter').val(); // Get the selected category value
                    refreshDataTable(startDate, endDate, category);
                });

                // Add event listener for the download button
                $('#downloadChartButton').on('click', function() {
                    var selectedYear = $('#year').val();
                    downloadChartImage(selectedYear);
                });

                // Function to capture chart as image and initiate download
                function downloadChartImage(year) {
                    var canvas = $('#myBarChart')[0];
                    var image = canvas.toDataURL('image/png'); // Convert canvas to base64 image
                    // Construct the filename using the selected year
                    var filename = 'monthly_sales_chart_' + year + '.png';
                    // Use downloadjs to initiate the download
                    download(image, filename, 'image/png');
                }

                // Function to initialize the chart
                function initializeChart(labels, earningData) {
                    // Check if the previous chart instance exists and destroy it
                    if (myBarChart) {
                        myBarChart.destroy();
                    }
                    var chartlabels = labels;
                    var earningData = earningData;

                    var ctx = document.getElementById("myBarChart").getContext("2d");
                    myBarChart = new Chart(ctx, {
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
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
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
                                        // Include a peso sign in the ticks
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
                            tooltips: {
                                mode: 'index', // Enable mode: 'index' to show all datasets for the hovered x-axis index
                                intersect: false,
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                                // Include a peso sign in the tooltip label
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label ||
                                            '';
                                        var value = tooltipItem.yLabel;
                                        return datasetLabel + ': ₱' + value;
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: 'top', // You can change the legend position here
                                labels: {
                                    // Change the legend label here
                                    boxWidth: 12,
                                    fontColor: '#858796'
                                }
                            },
                           
                            animation: {
                                onComplete: function(context) {
                                    var chartInstance = context.chart;
                                    var ctx = chartInstance.ctx;

                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'bottom';
                                    ctx.font = 'bold 12px Arial';

                                    var datasets = chartInstance.data.datasets;

                                    // Calculate the total sum for each stacked bar
                                    var totalSums = [];

                                    datasets.forEach(function(dataset) {
                                        dataset.data.forEach(function(value, index) {
                                            if (typeof totalSums[index] === 'undefined') {
                                                totalSums[index] = 0;
                                            }
                                            totalSums[index] += value;
                                        });
                                    });

                                    datasets.forEach(function(dataset, datasetIndex) {
                                        var meta = chartInstance.getDatasetMeta(datasetIndex);

                                        meta.data.forEach(function(element, index) {
                                            var model = element.tooltipPosition();

                                            // Display the total sum only for the first dataset in each stacked bar
                                            if (datasetIndex ===
                                                1) { // Check if it's the Buffalo dataset
                                                ctx.fillStyle = 'black';
                                                ctx.fillText('₱' + totalSums[index], model
                                                    .x, model.y
                                                    ); // Adjust y position here
                                            }
                                        });
                                    });
                                }
                            }



                        }
                    });
                }

                // Handle form submission using Ajax
                $('#filterForm').submit(function(e) {
                    e.preventDefault();

                    var formData = $(this).serialize();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.sales_report.update-year') }}',
                        data: formData,
                        success: function(response) {
                            var labels = response.labels;
                            var earningData = response.earningData;
                            console.log(labels);
                            console.log(earningData)
                            console.log(response.selectedYear);;
                            // Reinitialize the chart with new data
                            initializeChart(labels, earningData);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });

                // Initialize the chart on page load
                var labels = @json($labels);
                var earningData = @json($earningData);
                console.log(earningData);
                initializeChart(labels, earningData);

                // Initialize Clipboard.js
                new ClipboardJS('#copy', {
                    text: function(trigger) {
                        // Find the datatable
                        var dataTable = $('#dataTable');

                        // Extract and format the datatable data
                        var dataTableData = [];

                        // Include the table header
                        var headerRow = [];
                        dataTable.find('thead th').each(function() {
                            headerRow.push($(this).text());
                        });
                        dataTableData.push(headerRow.join('\t'));

                        // Include the data rows
                        dataTable.find('tbody tr').each(function() {
                            var row = [];
                            $(this).find('td').each(function() {
                                row.push($(this).text());
                            });
                            dataTableData.push(row.join('\t')); // Use tab delimiter for columns
                        });

                        // Include the footer row
                        var footerRow = [];
                        dataTable.find('tfoot th').each(function() {
                            footerRow.push($(this).text());
                        });
                        dataTableData.push(footerRow.join('\t'));

                        return dataTableData.join('\n'); // Use newline delimiter for rows
                    }
                });

                // Handle button click event
                $('#copy').click(function() {
                    showNotification('success', 'Data copied to clipboard!');
                });

                $('#printButton').on('click', function() {
                    if (dataTable.rows().count() > 0) {
                        // Create a header row with the desired content
                        var headerRow =
                            '<tr><th colspan="6" style="text-align:center"><h2 style="text-align:center">Sales Report</h2></th></tr>';

                        // Append the header row to the table
                        $('#dataTable thead').prepend(headerRow);
                        printJS({
                            printable: 'dataTable', // Provide the ID of the element to print
                            type: 'html', // Specify the type of content
                            // header: '<h2>Your Sales Report</h2>', // Optional header content
                            css: ["{{ asset('css/sales-print.css') }}"],
                        });
                        // Remove the header row from the table
                        $('#dataTable thead tr:first-child').remove();

                    } else {
                        showNotification('error', 'No data to print');
                    }
                });

                // Add event listener for the download button
                $('#downloadExcelButton').on('click', function() {
                    var wb = XLSX.utils.table_to_book(document.getElementById('dataTable'));
                    var wbout = XLSX.write(wb, {
                        bookType: 'xlsx',
                        bookSST: true,
                        type: 'binary'
                    });

                    function s2ab(s) {
                        var buf = new ArrayBuffer(s.length);
                        var view = new Uint8Array(buf);
                        for (var i = 0; i !== s.length; ++i) {
                            view[i] = s.charCodeAt(i) & 0xFF;
                        }
                        return buf;
                    }

                    var blob = new Blob([s2ab(wbout)], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var filename = 'month_sales.xlsx'; // You can customize the filename here
                    saveAs(blob, filename);
                });

            });
        </script>
    @endif
@endsection
