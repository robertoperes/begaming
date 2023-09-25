<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Model;

class TeamService
{
    /* @var TeamRepository */
    protected $teamRepository;

    public function __construct()
    {
        $this->teamRepository = app(TeamRepository::class);
    }

    public function list(array $filters = [], string $order = 'id', string $orderType = 'ASC')
    {
        $itemsPerPage = $filters['per_page'] ?? 10;
        $page         = $filters['page'] ?? 1;

        unset($filters['per_page']);
        unset($filters['page']);
        return $this->teamRepository->list($filters)->paginateWithLimit($itemsPerPage, $page);
    }

    public function get(int $id)
    {
        return $this->teamRepository->findOneBy('id', $id);
    }

    public function create(array $data)
    {
        return $this->teamRepository->create($data);
    }

    public function update(Model $model, array $data)
    {
        return $this->teamRepository->update($model, $data);
    }

    public function findBy($filter): Team
    {
        $team = $this->teamRepository->findUserBy($filter)->first();

        if (!($team instanceof Team)) {
            throw new \Exception('Time não encontrado');
        }

        return $team;
    }
}