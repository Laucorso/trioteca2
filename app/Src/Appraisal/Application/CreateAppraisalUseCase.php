<?php

declare(strict_types=1);

namespace App\Src\Appraisal\Application;

use App\Models\Appraisal;
use App\Src\Appraisal\Domain\AppraisalRepository;
use Illuminate\Support\Facades\Validator;

final class CreateAppraisalUseCase
{
    public function __construct(
        private AppraisalRepository $repository,
        private Appraisal $model
    ) {
    }

    public function execute(array $params): array
    {
        $validator = Validator::make($params, $this->model->createRules());
        $validatedData = $validator->validate();

        return $this->repository->save($params);
    }
}