<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImportResource;
use App\Http\Resources\ImportsCollection;
use App\Models\Import;
use App\Models\Initiative;
use App\Models\User;
use Illuminate\Http\Request;

class ImportsController extends Controller
{
    public function index()
    {
        return ImportResource::collection(Import::latest()->paginate(15));
    }

    public function import(Request $request)
    {
        $request->validate(
            [
                'file' => ['required', 'file', 'mimes:xlsx,csv,xls'],
                'initiative' => ['required', 'in:' . implode(',', Initiative::all()->pluck('id')->toArray())]
            ]
        );

        $file = $request->file('file');

        $import = auth()->user()->imports()->create([
            'file_name' => $file->getClientOriginalName(),
            'initiative_id' => $request->get('initiative', \Arr::random(Initiative::all()->pluck('id')->toArray())),
            'file' => $file->store('imports')
        ]);

        \Maatwebsite\Excel\Facades\Excel::queueImport(new \App\Imports\DataImport($import), $file);

        return ['success' => '1'];
    }

    public function download(Import $import)
    {
        return \Storage::download($import->file);
    }

    public function download_sample()
    {
        return \Storage::download('Sample Format.xlsx');
    }
}