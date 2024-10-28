<?php

declare(strict_types=1);

namespace App\Src\Appraisal\Application;

use App\Models\Appraisal;
use App\Src\Appraisal\Domain\AppraisalRepository;
use Illuminate\Support\Facades\Validator;

final class UpdateAppraisalUseCase
{
    public function __construct(
        private AppraisalRepository $repository,
        private Appraisal $model
    ) {
    }

    public function execute(array $params, int $id): array
    {
        $validator = Validator::make($params, $this->model->updateRules());
        $validatedData = $validator->validate();

        return $this->repository->update($params, $id);
    }
}