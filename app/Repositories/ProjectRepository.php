<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements Repository {

  public function store($project, $attributes) {
    $created = $project->create([
      'title' => data_get($attributes, 'title'),
      'creator_id' => Auth::user()->id,
    ]);
    return $created;
  }

  public function update($project, $attributes) {
    $updated = $project->update([
      'title' => data_get($attributes, 'title', $project->title),
    ]);

    if (!$updated)
      throw new \Exception('Task update failed.');

    return $project;
  }

  public function delete($project) {
    $deleted = $project->delete();
    return $deleted;
  }
}
