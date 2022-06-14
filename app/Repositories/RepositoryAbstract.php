<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Repositories\RepositoryInterface;

abstract class RepositoryAbstract implements RepositoryInterface
{
    protected $model;

    public function all($attributes = ['*']): Collection
    {
        $instance = $this->createModel();
        return $instance->get($attributes);
    }

    public function list(array $filters = [], string $order = null, $orderBy = 'ASC'): Builder
    {
        if ($order) {
            return $this->createModel()->select(['*'])->where($filters)->orderBy($order, $orderBy);
        }
        return $this->createModel()->select(['*'])->where($filters);
    }

    public function create(array $attributes = []): Model
    {
        $instance = $this->createModel();
        $instance->fill($attributes);
        $instance->save();
        return $instance;
    }

    public function createModel(): Model
    {
        $instance = (new $this->model());
        if (Session::has('database') && empty($instance->getConnectionName())) {
            $instance->setConnection(Session::get('database'));
        }
        return $instance;
    }

    public function findOneBy($key, $value): ?Model
    {
        return $this->createModel()->where($key, '=', $value)->first();
    }

    public function findBy($key, $values): Collection
    {
        if (is_array($values)) {
            return $this->createModel()->whereIn($key, $values)->get();
        }
        return $this->createModel()->where($key, '=', $values)->get();
    }

    public function findAll(array $filter, string $orderKey = null, string $orderType = 'ASC'): Collection
    {
        if ($orderKey) {
            return $this->createModel()->where($filter)->orderBy($orderKey, $orderType)->get();
        }
        return $this->createModel()->where($filter)->get();
    }

    public function update(Model $instance, array $attributes = []): Model
    {
        $instance->fill($attributes);
        $instance->save();
        return $instance;
    }

    public function delete(Model $instance): bool
    {
        return $instance->delete();
    }

    public function setModel(Model $instance): void
    {
        $this->model = $instance;
    }
}
