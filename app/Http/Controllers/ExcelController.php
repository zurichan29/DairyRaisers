<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function downloadExcel()
    {
        $data = DB::table('dataTable')->get(); // Replace 'your_table_name' with your actual table name
        return Excel::download(new ExcelExport($data), 'data.xlsx');
    }
}
