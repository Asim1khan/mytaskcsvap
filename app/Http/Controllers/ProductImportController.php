<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductImportController extends Controller
{

    public function index()
    {
        return view('import');
    }
}
