<?php

namespace App\Repositories;

use App\Repositories\Repository;


class TaskRepository implements Repository {

  public function store($task, $attributes) {
    $created = $task->create([
      'title' => data_get($attributes, 'title'),
      'creator_id' => Auth()->user()->id,
      'project_id' => data_get($attributes, 'project_id'),
    ]);
    return $created;
  }

  public function update($task, $attributes) {
    $updated = $task->update([
      'title' => data_get($attributes, 'title', $task->title),
      'is_done' => data_get($attributes, 'is_done', $task->is_done),
      'project_id' => data_get($attributes, 'project_id', $task->project->id),
    ]);

    if (!$updated)
      throw new \Exception('Task update failed.');

    return $task;
  }

  public function delete($task) {
    $deleted = $task->delete();
    return $deleted;
  }
}
