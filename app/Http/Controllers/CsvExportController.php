<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use App\Models\Sales;

class CsvExportController extends Controller
{
    public function downloadCsv(Request $request)
    {
        $data = Sales::all(); // Replace with how you fetch your data

        $csvFileName = 'export_' . Str::random(10) . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $handle = fopen('php://output', 'w');
        // Write CSV header
        fputcsv($handle, ['DATE', 'NAME', 'CATEGORY', 'PRICE', 'QTY', 'TOTAL SALES']);

        foreach ($data as $row) {
            fputcsv($handle, [
                $row->created_at,
                $row->name,
                $row->category,
                $row->price,
                $row->quantity,
                $row->total_sales,
            ]);
        }

        fclose($handle);

        return Response::stream(function () use ($handle) {
            fclose($handle);
        }, 200, $headers);
    }
}
