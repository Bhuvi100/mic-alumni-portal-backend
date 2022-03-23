<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Http\Resources\AnnouncementsCollection;
use App\Models\Announcement;
use App\Policies\BasePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementsController extends Controller
{
    public function public_index()
    {
        $announcements = \Cache::rememberForever('announcements_public',
            fn() => Announcement::latest()->with('user:id,name')->where('status', 'live')->get());

        return response()->json(AnnouncementResource::collection($announcements));
    }

    public function index()
    {
        $announcements = Announcement::latest()->with('user:id,name')->get()->groupBy('status');

        return response()->json($announcements);
    }

    public function store(AnnouncementRequest $request)
    {
        $attachment = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')->store('images/announcements/', ['disk' => 'public']);
        }

        $announcement = Announcement::create($request->except('attachment') + ['user_id' => auth()->id(), 'attachment' => $attachment]);

        \Cache::put('announcements_public', Announcement::latest()->with('user:id,name')->where('status', 'live')->get());

        return response()->json(array_merge($announcement->toArray(), ['attachment' => $announcement->attachment ? asset('storage/' . ($announcement->attachment)) : '']));
    }

    public function show(Announcement $announcement)
    {
        return response()->json(new AnnouncementResource($announcement));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $update_array = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            if (Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }

            $update_array['attachment'] = $request->file('attachment')->store('images/announcements/', ['disk' => 'public']);
        }

        $announcement->update($update_array);

        \Cache::put('announcements_public', Announcement::latest()->with('user:id,name')->where('status', 'live')->get());

        return response()->json(array_merge($announcement->toArray(), ['attachment' => $announcement->attachment ? asset('storage/' . ($announcement->attachment)) : '']));
    }

    public function destroy(Announcement $announcement)
    {
        if (Storage::disk('public')->exists($announcement->attachment)) {
            Storage::disk('public')->delete($announcement->attachment);
        }

        $announcement->delete();

        \Cache::put('announcements_public', Announcement::latest()->with('user:id,name')->where('status', 'live')->get());

        return response()->json(['status' => 'success']);
    }
}