<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\DispenserNotFoundException;
use App\Domain\DispenserRepository;

class GetDispenserMoneySpent
{
    private DispenserRepository $repository;
    private float $dispenserCostPerUnit;

    public function __construct(
        DispenserRepository $repository,
        float $dispenserCostPerUnit
    ) {
        $this->repository = $repository;
        $this->dispenserCostPerUnit = $dispenserCostPerUnit;
    }

    /**
     * @throws DispenserNotFoundException
     */
    public function __invoke(GetDispenserMoneySpentCommand $command): GetDispenserMoneySpentResultDto
    {
        $dispenser = $this->repository->findById($command->id());

        if (is_null($dispenser)) {
            throw DispenserNotFoundException::ofId($command->id());
        }

        return new GetDispenserMoneySpentResultDto(
            $dispenser->flowVolume(),
            $this->dispenserCostPerUnit,
            $dispenser->totalSpent($this->dispenserCostPerUnit, $command->now()),
            $dispenser->openedAt(),
            $dispenser->closedAt()
        );
    }
}