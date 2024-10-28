<?php

declare(strict_types=1);

namespace App\Src\Address\Infrastructure;

use App\Models\Client;
use App\Src\Client\Domain\ClientRepository;

class DatabaseEloquentClientRepository implements ClientRepository
{

    private $model;

    public function __construct()
    {
        $this->model = new Client();
    }

    public function find(int $id): array
    {
        return $this->model->findOrFail($id)->toArray();
    }

    public function findAll(): Client
    {
        return $this->model->get();
    }

    public function save(array $params) : array
    {
        $this->model->fill($params);
        $this->model->save();
        return $this->model->toArray();
    }

    public function update(array $params, int $id): array
    {
        $Client = $this->model->findOrFail($id);
        $Client->update($params);
        return $Client->toArray();
    }

    public function delete(int $id): void
    {
        $this->model->findOrFail($id)->delete();    
    }
}