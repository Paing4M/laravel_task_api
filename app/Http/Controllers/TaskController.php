<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller {
  protected $taskRepository;


  public function __construct(TaskRepository $taskRepository) {
    $this->taskRepository = $taskRepository;
    $this->authorizeResource(Task::class, 'task');
  }

  public function index() {
    $tasks = QueryBuilder::for(Task::class)
      ->allowedFilters(['is_done', 'creator_id'])
      ->defaultSort('-created_at')
      ->allowedSorts(['title', 'is_done', 'created_at'])
      ->paginate(5);

    // $tasks = Task::all();
    return new TaskCollection($tasks);
  }

  public function show(Task $task) {
    return new TaskResource($task);
  }

  public function store(StoreTaskRequest $request, Task $task) {
    $payload = $request->only(['title', 'is_done', 'project_id']);
    $created = $this->taskRepository->store($task, $payload);
    return new TaskResource($created);
  }

  public function update(UpdateTaskRequest $request, Task $task) {
    // dd($task->project);
    $payload = $request->only(['title', 'is_done', 'project_id']);
    $updated = $this->taskRepository->update($task, $payload);
    return new TaskResource($updated);
  }

  public function destroy(Task $task) {
    $this->taskRepository->delete($task);
    return response()->json(['success' => 'Task deleted successfully.']);
  }
}
