<?php

declare(strict_types=1);

namespace App\Src\Client\Application;

use App\Models\Client;
use App\Src\Client\Domain\ClientRepository;

final class ShowClientsUseCase
{
    public function __construct(
        private ClientRepository $repository,
        private Client $model
    ) {
    }

    public function execute(): Client
    {
        return $this->repository->findAll();
    }
}