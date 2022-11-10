<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\DispenserAlreadyOpenedException;
use App\Domain\DispenserNotFoundException;
use App\Domain\DispenserRepository;

class ChangeDispenserStatus
{
    private DispenserRepository $repository;

    public function __construct(DispenserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws DispenserNotFoundException
     * @throws DispenserAlreadyOpenedException
     */
    public function __invoke(ChangeDispenserStatusCommand $command): void
    {
        $dispenser = $this->repository->findById($command->id());

        if (is_null($dispenser)) {
            throw DispenserNotFoundException::ofId($command->id());
        }

        if ($command->isStatusOpen()) {
            $dispenser->open($command->updatedAt());
        }

        if ($command->isStatusClose()) {
            $dispenser->close($command->updatedAt());
        }

        $this->repository->save($dispenser);
    }
}