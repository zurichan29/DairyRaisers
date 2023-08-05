@extends('layouts.admin')

@section('content')
    <!-- Display the error message if it exists -->
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <style>
            #dataTable {
                font-size: 14px;
                /* Adjust the font size as per your preference */
            }
        </style>

        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h1 class="h3 text-primary">Activity Logs</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TYPE</th>
                                <th>ACTIVITY</th>
                                <th>DATE</th>
                                <th>IP ADDRESS</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>TYPE</th>
                                <th>ACTIVITY</th>
                                <th>DATE</th>
                                <th>IP ADDRESS</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($activity_logs as $logs)
                                @php
                                    
                                @endphp
                                <tr>
                                    <td>{{ $logs->activity_type }}</td>
                                    <td>{{ $logs->description }}</td>
                                    <td>{{ $logs->created_at }}</td>
                                    <td>{{ $logs->ip_address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var dataTable = null;
                dataTable = $('#dataTable').DataTable({
                    columns: [
                        null,
                        null,
                        {
                            render: function(data, type, row) {
                                return formatDateTime(data);
                            }
                        },
                        null
                    ]
                });

                function formatDateTime(data) {
                    const dateTime = moment(data);
                    const time = dateTime.format('h:mm A'); // Format time in 12-hour format
                    const date = dateTime.format('M/D/YYYY'); // Format date

                    return time + '<br>' + date; // Separate time and date with a line break (<br>)
                }
            });
        </script>
    @endif

@endsection
