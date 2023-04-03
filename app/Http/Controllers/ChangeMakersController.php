<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeMakerRequest;
use App\Http\Resources\ChangeMakerResource;
use App\Models\ChangeMaker;

class ChangeMakersController extends Controller
{
    public function index()
    {
        $changeMakers = ChangeMaker::with('user:id,name')->orderBy('status')->paginate(15);

        return response()->json($changeMakers);
    }

    public function store(ChangeMakerRequest $request)
    {
        $changemakers = ChangeMaker::create($request->validated() + ['user_id' => auth()->id()]);

        \Cache::put('changemakers_public', ChangeMaker::latest()->with('user:id,name')->where('status', 'live')->get());

        return response()->json($changemakers->toArray());
    }

    public function show(ChangeMaker $changemaker)
    {
        return response()->json(new ChangeMakerResource($changemaker));
    }

    public function update(ChangeMakerRequest $request, ChangeMaker $changemaker)
    {
        $changemaker->update($request->validated());

        \Cache::put('changemakers_public', ChangeMaker::latest()->with('user:id,name')->where('status', 'live')->get());

        return response()->json($changemaker->toArray());
    }

    public function destroy(ChangeMaker $changemaker)
    {
        $changemaker->delete();

        \Cache::put('changemakers_public', ChangeMaker::latest()->with('user:id,name')->where('status', 'live')->get());

        return response()->json(['status' => 'success']);
    }
}
