<?php

declare(strict_types=1);

namespace App\Src\Appraisal\Domain;

use App\Models\Appraisal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppraisalRepository
{
    public function find(int $id): array;
    public function findLogsByAppraisal(int $id);
    public function findAll(array $filters = []): LengthAwarePaginator;    
    public function save(array $data): array;
    public function update(array $data, int $id): array;
    public function delete(int $id): void;
}