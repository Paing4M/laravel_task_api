<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller {

  protected $repository;

  public function __construct(ProjectRepository $repository) {
    $this->repository = $repository;
    $this->authorizeResource(Project::class, 'project');
  }

  /**
   * Display a listing of the resource.
   */
  public function index() {
    $projects = QueryBuilder::for(Project::class)
      ->allowedIncludes('tasks')
      ->paginate();
    return new ProjectCollection($projects);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Project $project, StoreProjectRequest $request) {
    $payload = $request->only(['title']);
    $created =  $this->repository->store($project, $payload);
    return new ProjectResource($created);
  }

  /**
   * Display the specified resource.
   */
  public function show(Project $project) {
    return (new ProjectResource($project))->load(['tasks', 'members']);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateProjectRequest $request, Project $project) {
    $payload = $request->only(['title']);
    $updated =  $this->repository->update($project, $payload);
    return new ProjectResource($updated);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Project $project) {
    $deleted = $this->repository->delete($project);
    if ($deleted) {
      return response()->json([
        'success' => 'Project deleted successfully.'
      ]);
    }
  }
}
