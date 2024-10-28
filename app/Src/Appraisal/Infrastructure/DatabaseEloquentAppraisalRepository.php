<?php

declare(strict_types=1);

namespace App\Src\Address\Infrastructure;

use App\Models\Appraisal;
use App\Src\Appraisal\Domain\AppraisalRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DatabaseEloquentAppraisalRepository implements AppraisalRepository
{

    private $model;

    public function __construct()
    {
        $this->model = new Appraisal();
    }

    public function find(int $id): array
    {
        return $this->model->findOrFail($id)->toArray();
    }

    public function findLogsByAppraisal(int $id): array
    {
        $appraisal = $this->model->findOrFail($id);
        return $appraisal->audits->toArray();
    }

    public function findAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            if (!empty($filters['client_name'])) {
                $query->whereHas('client', function ($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['client_name'] . '%');
                });
            } elseif (!empty($filters['date_from'])) {
                $query->where('created_at', '>=', $filters['date_from']);
            } elseif (!empty($filters['date_to'])) {
                $query->where('created_at', '<=', $filters['date_to']);
            }
        }


        return $query->paginate(10);
    }

    public function save(array $params) : array
    {
        $params['managed_by_user'] = auth()->user()->id;
        $this->model->fill($params);
        $this->model->save();
        return $this->model->toArray();
    }

    public function update(array $params, int $id): array
    {
        $appraisal = $this->model->findOrFail($id);
        $appraisal->update($params);
        return $appraisal->toArray();
    }

    public function delete(int $id): void
    {
        $this->model->findOrFail($id)->delete();    
    }
}