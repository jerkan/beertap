<?php

declare(strict_types=1);

namespace App\Domain;

interface DispenserRepository
{
    public function save(Dispenser $dispenser): void;

    public function findById(string $id): ?Dispenser;
}