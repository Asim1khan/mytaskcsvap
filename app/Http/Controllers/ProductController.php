<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductImporter;

class ProductController extends Controller
{
    public function index()
    {
        return view('import');
    }
    public function import(Request $request, ProductImporter $productImporter)
     {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);
        $csvFilePath = $request->file('csv_file')->getPathname();
        $productImporter->importProductsFromUploadedCSV($csvFilePath);
        return redirect()->back()->with('success', 'Products imported successfully.');

     }
}
