<?php

declare(strict_types=1);

namespace App\Src\Appraisal\Application;

use App\Models\Appraisal;
use App\Src\Appraisal\Domain\AppraisalRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ShowAppraisalsUseCase
{
    public function __construct(
        private AppraisalRepository $repository,
        private Appraisal $model
    ) {
    }

    public function execute(?array $filters = []): LengthAwarePaginator
    {
        return $this->repository->findAll($filters);
    }
}