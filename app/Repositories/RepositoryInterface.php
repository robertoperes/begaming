<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    public function create(array $attributes = []): Model;

    public function createModel(): Model;

    public function findOneBy($key, $value): ?Model;

    public function findBy($key, $values): Collection;

    public function update(Model $instance, array $attributes = []): Model;

    public function delete(Model $instance): bool;

    public function setModel(Model $instance): void;
}
