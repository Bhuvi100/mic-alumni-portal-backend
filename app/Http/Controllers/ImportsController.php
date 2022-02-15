<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImportsCollection;
use App\Models\Import;
use App\Models\User;
use Illuminate\Http\Request;

class ImportsController extends Controller
{
    public function index()
    {
        return new ImportsCollection(Import::latest()->paginate(10));
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        $import = auth()->user()->imports()->create([
            'file_name' => $file->getClientOriginalName(),
            'hackathon' => $request->get('hackathon', 'Smart India Hackathon'),
            'file' => $file->store('imports')
        ]);

        \Maatwebsite\Excel\Facades\Excel::queueImport(new \App\Imports\DataImport($import), $file);

        return ['success' => '1'];
    }

    public function download(Import $import)
    {
        return \Storage::download($import->file);
    }
}