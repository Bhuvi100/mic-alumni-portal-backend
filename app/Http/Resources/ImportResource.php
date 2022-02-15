<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Import */
class ImportResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'hackathon' => $this->hackathon,
            'projects' => $this->projects,
            'users' => $this->users,
            'status' => $this->status,
            'file' => $this->file,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'imported_by' => $this->importer->name,
            'download' => route('imports.download', $this)
        ];
    }
}
