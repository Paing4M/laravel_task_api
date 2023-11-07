<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model {
  use HasFactory;
  protected $fillable = ['title', 'is_done', 'creator_id', 'project_id'];

  protected $casts = ['is_done' => 'boolean'];

  protected $hidden = ['updated_at'];

  public function creator() {
    return $this->belongsTo(User::class, 'creator_id');
  }

  // only user tasks are show
  protected static function booted() {
    static::addGlobalScope('member', function (Builder $builder) {
      $builder->where('creator_id', Auth::user()->id)
        ->orWhereIn('project_id', Auth::user()->memberships->pluck('id'));
    });
  }

  public function project() {
    return $this->belongsTo(Project::class, 'project_id');
  }
}
