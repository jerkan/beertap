<?php

declare(strict_types=1);

namespace App\Domain;

interface DispenserUsageRepository
{
    public function save(DispenserUsage $dispenserUsage): void;

    public function findLast(string $id): ?DispenserUsage;

    public function fetchById(string $id): array;
}