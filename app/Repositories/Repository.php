<?php

namespace App\Repositories;

interface Repository {
  public function store($model, $attributes);
  public function update($model, $attributes);
  public function delete($model);
}
