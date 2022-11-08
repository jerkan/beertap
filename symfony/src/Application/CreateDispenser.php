<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Dispenser;
use App\Domain\DispenserRepository;

class CreateDispenser
{
    private DispenserRepository $repository;

    public function __construct(DispenserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateDispenserCommand $command): void
    {
        $dispenser = $this->createDispenserFromCommand($command);

        $this->repository->save($dispenser);
    }

    private function createDispenserFromCommand(CreateDispenserCommand $command): Dispenser
    {
        return new Dispenser(
            $command->id(),
            $command->name(),
            $command->flowVolume()
        );
    }
}