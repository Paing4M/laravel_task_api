<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model {
  use HasFactory;

  protected $fillable = ['title', 'creator_id'];

  protected $hidden = ['updated_at'];

  // protected static function booted() {
  //   static::addGlobalScope('creator', function (Builder $builder) {
  //     $builder->where('creator_id', Auth::user()->id);
  //   });
  // }

  protected static function booted() {
    static::addGlobalScope('members', function (Builder $builder) {
      $builder->whereRelation('members', 'user_id', Auth::user()->id);
    });
  }

  public function tasks() {
    return $this->hasMany(Task::class, 'project_id');
  }

  public function creator() {
    return $this->belongsTo(User::class, 'creator_id');
  }

  public function members() {
    return $this->belongsToMany(User::class, Member::class);
  }
}
