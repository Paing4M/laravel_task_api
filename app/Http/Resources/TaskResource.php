<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    $data = parent::toArray($request);
    $data['status'] = $this->is_done ? 'finished' : 'open';
    return $data;

    // $data['title'] = $this->title;
    // $data['isDone'] = $this->is_done;
    // $data['status'] = $this->is_done ? 'finished' : 'open';
    // $data['createdAt'] = $this->created_at;
    // return $data;
  }
}
