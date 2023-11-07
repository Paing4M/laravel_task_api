<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    // return parent::toArray($request);
    return [
      'id' => $this->id,
      'title' => $this->title,
      'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
      'members' => UserResource::collection($this->whenLoaded('members')),
      'creator_id' => $this->creator_id,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
