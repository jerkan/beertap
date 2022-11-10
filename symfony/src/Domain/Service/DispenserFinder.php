<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Dispenser;
use App\Domain\DispenserNotFoundException;
use App\Domain\DispenserRepository;

class DispenserFinder
{
    private DispenserRepository $repository;

    public function __construct(DispenserRepository $repository)
    {
        $this->repository = $repository;
    }

    /** @throws DispenserNotFoundException */
    public function find(string $id): Dispenser
    {
        $dispenser = $this->repository->findById($id);

        if (is_null($dispenser)) {
            throw DispenserNotFoundException::ofId($id);
        }

        return $dispenser;
    }
}