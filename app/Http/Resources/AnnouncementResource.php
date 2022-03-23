<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/** @mixin \App\Models\Announcement */
class AnnouncementResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'attachment' => $this->attachment ? asset('storage/' . ($this->attachment)) : '',
            'created_month' => Carbon::create($this->getRawOriginal('created_at'))->monthName,
            'created_date' => Carbon::create($this->getRawOriginal('created_at'))->format('d'),
        ];
    }
}
