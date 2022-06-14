<?php

namespace App\Services;

use App\Repositories\BadgeRepository;
use Illuminate\Database\Eloquent\Model;

class BadgeService
{
    /* @var BadgeRepository */
    protected $badgeRepository;

    public function __construct()
    {
        $this->badgeRepository = app(BadgeRepository::class);
    }

    public function list(array $filters = [], string $order = 'id', string $orderType = 'ASC')
    {
        $itemsPerPage = $filters['per_page'] ?? 10;
        $page         = $filters['page'] ?? 1;

        unset($filters['per_page']);
        unset($filters['page']);
        return $this->badgeRepository->list($filters)->paginateWithLimit($itemsPerPage, $page);
    }

    public function get(int $id)
    {
        return $this->badgeRepository->findOneBy('id', $id);
    }

    public function create(array $data)
    {
        return $this->badgeRepository->create($data);
    }

    public function update(Model $model, array $data)
    {
        return $this->badgeRepository->update($model, $data);
    }
}