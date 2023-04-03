<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/** @mixin \App\Models\Announcement */
class ChangeMakerResource extends JsonResource
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
            'url' => $this->url,
            'created_month' => Carbon::create($this->getRawOriginal('created_at'))->monthName,
            'created_date' => Carbon::create($this->getRawOriginal('created_at'))->format('d'),
            'created_year' => Carbon::create($this->getRawOriginal('created_at'))->year,
            'created_at' => $this->created_at
        ];
    }
}
