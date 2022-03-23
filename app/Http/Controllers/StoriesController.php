<?php

namespace App\Http\Controllers;


use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function public_index()
    {
        $stories = \Cache::rememberForever('stories_public', function () {
            $alumni_stories = Story::select(['title', 'description'])->with('user:name,picture')
                ->where('display', 'alumni')->limit(3)->get();
            $mentor_stories = Story::select(['title', 'description'])->with('user:name,picture')
                ->where('display', 'mentor')->limit(3)->get();

            return [
                'alumni' => $alumni_stories,
                'mentor' => $mentor_stories,
            ];
        });

        return response()->json($stories);
    }

    public function index()
    {
        return response()->json(Story::latest()->with('user')->orderBy('display')->get());
    }

    public function show(?User $user)
    {
        $user = $user->id ? $user : auth()->user();

        return response()->json($user->story()->exists() ? $user->story : []);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate(
            [
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
            ]
        );

        if ($user->story()->exists()) {
            $user->story()->update($validated);
        } else {
            $user->story()->create($validated);
        }

        $alumni_stories = Story::select(['title', 'description'])->with('user:name,picture')
            ->where('display', 'alumni')->limit(3)->get();
        $mentor_stories = Story::select(['title', 'description'])->with('user:name,picture')
            ->where('display', 'mentor')->limit(3)->get();

        \Cache::put('stories_public', [
            'alumni' => $alumni_stories,
            'mentor' => $mentor_stories,
        ]);

        return $user->story;
    }

    public function updateDisplay(Request $request, Story $story)
    {
        $request->validate(
            [
                'display' => ['required', 'in:none,alumni,mentor']
            ]
        );

        $story->update([
            'display' => $request->display,
        ]);

        $alumni_stories = Story::select(['title', 'description'])->with('user:name,picture')
            ->where('display', 'alumni')->limit(3)->get();
        $mentor_stories = Story::select(['title', 'description'])->with('user:name,picture')
            ->where('display', 'mentor')->limit(3)->get();

        \Cache::put('stories_public', [
            'alumni' => $alumni_stories,
            'mentor' => $mentor_stories,
        ]);

        return response()->json(Story::latest()->with('user')->orderBy('display')->get());
    }
}