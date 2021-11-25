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

    public function import(Request $request)
    {
        auth()->login(User::find(1)); //TODO REMOVE AFTER

        auth()->user()->imports()->create([
            'file_name' => $request->file('file')->getClientOriginalName(),
            'hackathon' => $request->get('hackathon', 'Smart India Hackathon'),
            ]);

        \Maatwebsite\Excel\Facades\Excel::queueImport(new \App\Imports\DataImport(), request()->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);

        return ['success' => '1'];
    }
}