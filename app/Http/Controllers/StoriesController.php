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
            $alumni_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
                ->where('display', 'alumni')->limit(3)->get();
            $mentor_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
                ->where('display', 'mentor')->limit(3)->get();

            return [
                'alumni' => $alumni_stories,
                'mentor' => $mentor_stories,
            ];
        });

        return response()->json($stories);
    }

    public function public_show($id)
    {
        $id = (int) $id;

        if ($id < 1 || $id > 6) {
            abort(404);
        }

        $stories = \Cache::rememberForever('stories_public', function () {
            $alumni_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
                ->where('display', 'alumni')->limit(3)->get();
            $mentor_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
                ->where('display', 'mentor')->limit(3)->get();

            return [
                'alumni' => $alumni_stories,
                'mentor' => $mentor_stories,
            ];
        });

        if ($id < 4) {
            if (isset($stories['alumni'][$id - 1])) {
                return response()->json($stories['alumni'][$id - 1]);
            }

            return abort(404);
        }

        if (isset($stories['mentor'][$id - 4])) {
            return response()->json($stories['mentor'][$id - 4]);
        }

        return abort(404);
    }

    public function index()
    {
        return response()->json(Story::with('user')->orderByDesc('display')->paginate(2));
    }

    public function show(?User $user)
    {
        $user = $user->id ? $user : auth()->user();

        return response()->json($user->stories()->exists() ?
            $user->stories()->get()->mapWithKeys(function ($story) {
                $array = [
                    'title' => $story->title,
                    'description' => $story->description,
                    'status' => $story->display
                ];

                return [$story->id => $array];
            }) :
            []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
            ]
        );

        return response()->json(auth()->user()->stories()->create($validated));
    }

    public function update(Request $request, Story $story)
    {
        $user = auth()->user();

        $validated = $request->validate(
            [
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
            ]
        );

        $story->update($validated);

        $alumni_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
            ->where('display', 'alumni')->limit(3)->get();
        $mentor_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
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

        $alumni_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
            ->where('display', 'alumni')->limit(3)->get();
        $mentor_stories = Story::select(['title', 'description', 'user_id'])->with('user:id,name,picture')
            ->where('display', 'mentor')->limit(3)->get();

        \Cache::put('stories_public', [
            'alumni' => $alumni_stories,
            'mentor' => $mentor_stories,
        ]);

        return response()->json(Story::latest()->with('user')->orderBy('display')->get());
    }
}