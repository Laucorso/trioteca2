<?php

declare(strict_types=1);

namespace App\Src\Client\Domain;

use App\Models\Client;

interface ClientRepository
{
    public function find(int $id): array;
    public function findAll(): Client;
    public function save(array $social_media): array;
    public function update(array $data, int $id): array;
    public function delete(int $id): void;
}