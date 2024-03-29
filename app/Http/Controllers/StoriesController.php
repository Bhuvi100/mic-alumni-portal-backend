<?php

namespace App\Http\Controllers;


use App\Exports\StoriesExport;
use App\Mail\StoryPublishedMail;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function public_home()
    {
        $stories = \Cache::rememberForever('stories_public', function () {
            $alumni_stories = Story::select(['id', 'title', 'description', 'user_id'])->with(['user:id,name,picture,organization_name,designation'])
                ->where('display', 'alumni')->get();
            $mentor_stories = Story::select(['id', 'title', 'description', 'user_id'])->with(['user:id,name,picture,organization_name,designation'])
                ->where('display', 'mentor')->get();

            return [
                'alumni' => $alumni_stories,
                'mentor' => $mentor_stories,
            ];
        });

        return response()->json($stories);
    }

    public function public_index(string $display)
    {
        return response()->json([
            'stories' => Story::select(['id', 'title', 'description', 'user_id'])->with(['user:id,name,picture,organization_name,designation'])
                ->where('display', $display)->get(),
        ]);
    }

    public function public_show(Story $story)
    {
        if ($story->display === 'none') {
            return abort(404);
        }

        $hackathons = implode(', ', $story->user->projects->map(function($project) {
            return $project->initiative->hackathon . ' ' . $project->initiative->edition;
        })->toArray());

        $story->load(['user:id,name,picture,organization_name,designation']);

        $final_array = $story->toArray() + ['hackathons' => $hackathons];
        unset($final_array['user']['projects']);
        return response()->json($final_array);
    }

    public function index()
    {
        $total_count = Story::count();
        $unpublished_count = Story::where('display', 'none')->count();
        $archived_count = Story::where('display', 'archived')->count();
        $published_count = $total_count - ($unpublished_count + $archived_count);

        return response()->json([
            'counts' => [
                'total' => $total_count,
                'published' => $published_count,
                'unpublished' => $unpublished_count,
            ],
            'stories' => Story::with('user')->where('display', '!=', 'archived')->orderByDesc('display')->paginate(15)]);
    }

    public function archived_index()
    {
        $total_count = Story::count();
        $unpublished_count = Story::where('display', 'none')->count();
        $archived_count = Story::where('display', 'archived')->count();
        $published_count = $total_count - ($unpublished_count + $archived_count);

        return response()->json([
            'counts' => [
                'total' => $total_count,
                'published' => $published_count,
                'unpublished' => $unpublished_count,
            ],
            'stories' => Story::with('user')->where('display', '=', 'archived')->orderByDesc('display')->paginate(15)]);
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
                'problem'  => ['required', 'string'],
                'unique' => ['required', 'string'],
                'impact' => ['required', 'string'],
                'market_size' => ['required', 'string'],
                'category' => ['required', 'string', 'max:240'],
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
                'problem'  => ['required', 'string'],
                'unique' => ['required', 'string'],
                'impact' => ['required', 'string'],
                'market_size' => ['required', 'string'],
                'category' => ['required', 'string', 'max:240'],
            ]
        );

        $story->update($validated);

        $alumni_stories = Story::select(['id', 'title', 'description', 'user_id'])->with(['user:id,name,picture,organization_name,designation'])
            ->where('display', 'alumni')->get();
        $mentor_stories = Story::select(['id', 'title', 'description', 'user_id'])->with(['user:id,name,picture,organization_name,designation'])
            ->where('display', 'mentor')->get();

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
                'display' => ['required', 'in:none,alumni,mentor,archived']
            ]
        );

        if (($request->display === 'alumni' && $story->display !== 'mentor') ||
            ($request->display === 'mentor' && $story->display !== 'alumni')) {
            \Mail::to($story->user)->queue(new StoryPublishedMail(env('FRONTEND_DOMAIN') . "/stories/{$story->id}"));
        }

        $story->update([
            'display' => $request->display,
        ]);

        $alumni_stories = Story::select(['id', 'title', 'description', 'user_id'])->with(['user:id,name,picture,organization_name,designation',])
            ->where('display', 'alumni')->get();
        $mentor_stories = Story::select(['id', 'title', 'description', 'user_id'])->with(['user:id,name,picture,organization_name,designation', ])
            ->where('display', 'mentor')->get();

        \Cache::put('stories_public', [
            'alumni' => $alumni_stories,
            'mentor' => $mentor_stories,
        ]);

        return response()->json(Story::latest()->with('user')->orderBy('display')->get());
    }

    public function export()
    {
        return \Excel::download(new StoriesExport(), 'feedbacks.xlsx');
    }
}
