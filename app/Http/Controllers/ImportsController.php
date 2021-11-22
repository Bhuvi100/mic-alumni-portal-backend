<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\User;
use Illuminate\Http\Request;

class ImportsController extends Controller
{
    public function index()
    {
        return Import::latest()->get();
    }

    public function import()
    {
        auth()->login(User::first());
        auth()->user()->imports()->create(['file_name' => request()->file('file')->getClientOriginalName()]);

        \Maatwebsite\Excel\Facades\Excel::queueImport(new \App\Imports\DataImport(), request()->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);

        return ['success' => '1'];
    }
}