<?php

namespace App\Http\Controllers;

use App\Http\Requests\InitiativesRequest;
use App\Models\Initiative;
use Illuminate\Http\Request;

class InitiativesController extends Controller
{
    public function index()
    {
        return response()->json(Initiative::latest()->get(['id', 'hackathon', 'edition', 'created_at']));
    }

    public function store(InitiativesRequest $request)
    {
        $initiative = Initiative::create($request->validated());

        return response()->json($initiative);
    }

    public function show(Initiative $initiative)
    {
        return response()->json($initiative);
    }

    public function update(InitiativesRequest $request,Initiative $initiative)
    {
        $initiative->update($request->validated());

        return response()->json($initiative);
    }

    public function destroy(Initiative $initiative)
    {
        $initiative->delete();

        return response()->json(['success' => 1]);
    }
}