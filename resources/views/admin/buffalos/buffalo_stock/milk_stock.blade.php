@extends('layouts.admin')
@section('content')

    <!-- INPUT DATA -->
    <div class="modal fade" id="input_mf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" method="POST" action="../process/process-buffalo.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Data: </span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold fs-3">Total Lactating Buffalos: </p>
                    <div class="form-floating mb-3">
                        <input type="date" min="2020-01-01" max="" class="form-control" id="mf_date" name="mf_date" value="" placeholder="select date" required>
                        <label for="mf_date">Select Date :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="mf_pregBuffalo" name="mf_pregBuffalo" placeholder="Total Pregnancy Buffalo:" required>
                        <label for="mf_data">Total Pregnant Buffalo: </label>
                    </div>
                    <div class="form-floating">
                        <input type="number" class="form-control" id="mf_data" name="mf_data" placeholder="milk production in Liters:" required>
                        <label for="mf_data">milk production in Liters: </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submit_input_mf" name="submit_input_mf" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- REMOVE DATA -->
    <div class="modal fade" id="remove_mf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" method="POST" action="../process/process-buffalo.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Remove Data: </span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="date" min="2020-01-01" class="form-control" id="mf_date_1" name="mf_date_1" value="" placeholder="select date" required>
                        <label for="mf_date_1">Select Date Value 1:</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" min="2020-01-01" class="form-control" id="mf_date_2" name="mf_date_2" value="" placeholder="select date" required>
                        <label for="mf_date_2">Select Date Value 2:</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submit_removal_mf" name="submit_removal_mf" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- UPDATE STOCKS -->
    <div class="modal fade" id="milk_stocks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" method="POST" action="../process/process-buffalo.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Milk Stock: </span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-between align-items-center">
                        <!-- IN -->
                        <div class="form-floating w-100">
                            <input type="number" name="increase_ms" id="increase_ms" class="form-control border border-success" value="0" placeholder="increase">
                            <label class="text-success" for="increase_ms">IN:</label>
                        </div>
                        <div class="px-2 py-2 text-center">
                            <p class="lead">Current Milk Stock:  liters</p><!-- CURRENT -->
                        </div>
                        <!-- OUT -->
                        <div class="form-floating w-100">
                            <input type="number" name="decrease_ms" id="decrease_ms" class="form-control border border-danger" value="0" placeholder="decrease">
                            <label class="text-danger" for="decreased_ms">OUT:</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submit_update_ms" name="submit_update_ms" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- HEADER CONTAINER -->
    <div class="mb-2 pb-2 border-bottom d-flex flex-row justify-content-between align-items-center overflow-hidden">
        <div class=" d-flex justify-content-center align-items-center flex-row">
            <div class="header-container bg-primary d-flex flex-column justify-content-end align-items-center" style="width: 70px;">
                <i class="fa-solid fa-cow img-fluid me-4" style="font-size:3rem; color:whitesmoke; padding:1rem;"></i>
            </div>
            <div class=" d-flex flex-column justify-content-center align-items-start">
                <p class="lead py-0 my-0 mb-2" style="font-size: 16px;"> Milk Stocks <i class="bi bi-box-seam me-1"></i> :: <span class=" fw-bold">  LITERS</span> <button type="button" class="ms-1 my-0 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#milk_stocks">Update</button></p>
                <p class="lead py-0 my-0" style="font-size: 16px;"> Last Update <i class="bi bi-calendar-check me-1"></i> :: <span class="fw-bold"> </span></p>
            </div>
        </div>
        <div class="px-3 py-2 rounded d-flex bg-primary flex-row justify-content-center align-items-center text-center">
            <p class="lead text-light py-0 my-auto text-center me-3" style="font-size: 16px;"> <i class="bi bi-filter-circle-fill me-2"></i>Filter ::</p>
            <div class=" d-flex flex-row justify-content-center align-items-center">
                <div class="form-floating me-3 p-0">
                    <select name="YearsFilter" id="YearsFilter" class="form-select form-select-sm">

                    </select>
                    <label for="YearsFilter">Year :</label>
                </div>
                <div class="form-floating me-3 p-0">
                    <select name="MonthsFilter" id="MonthsFilter" class="form-select form-select-sm">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <label for="MonthsFilter">Months :</label>
                </div>
                <div class="form-floating p-0">
                    <select name="WeeksFilter" id="WeeksFilter" class="form-select form-select-sm">
                        <option value="1st">1st Week</option>
                        <option value="2nd">2nd Week</option>
                        <option value="3rd">3rd Week</option>
                        <option value="4th">4th Week</option>
                    </select>
                    <label for="WeeksFilter">Week :</label>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
            <button type="button" data-bs-toggle="modal" data-bs-target="#input_mf" class="btn btn-sm btn-success mb-1 w-100 d-flex justify-content-between align-items-center text-center"><i class="bi bi-patch-plus me-2"></i>Input Data</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#remove_mf" class="btn btn-sm btn-danger w-100 d-flex justify-content-between align-items-center text-center"><i class="bi bi-patch-minus me-2"></i>Remove Data</button>
        </div>
    </div>

    <!-- MAIN CONTENTS -->
    <div class="container mt-3 p-2">
        <p class="fw-bold fs-3 mb-3 text-center">Milk Harvest Chart</p>
        <div class="d-flex flex-column justify-content-between align-items-center h-100">
            <div class="chartBox mb-3">
                <canvas id="myChart1"></canvas>
            </div>
            <div class="chartBox">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
    </div>
@endsection
