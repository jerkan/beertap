<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\DateTimeKey;
use App\Domain\Dispenser;
use App\Domain\DispenserAlreadyOpenedException;
use App\Domain\DispenserNotFoundException;
use App\Domain\DispenserUsage;
use App\Domain\DispenserUsageRepository;
use App\Domain\Service\DispenserFinder;

class OpenDispenser
{
    private DispenserFinder $finder;
    private DispenserUsageRepository $dispenserUsageRepository;
    private float $dispenserCostPerUnit;

    public function __construct(
        DispenserFinder $finder,
        DispenserUsageRepository $dispenserUsageRepository,
        float $dispenserCostPerUnit
    ) {
        $this->finder = $finder;
        $this->dispenserUsageRepository = $dispenserUsageRepository;
        $this->dispenserCostPerUnit = $dispenserCostPerUnit;
    }

    /**
     * @throws DispenserNotFoundException
     * @throws DispenserAlreadyOpenedException
     */
    public function __invoke(OpenDispenserCommand $command): void
    {
        $dispenser = $this->finder->find($command->id());

        $this->ensureDispenserIsNotOpen($dispenser);

        $dispenserUsage = new DispenserUsage(
            $dispenser->id(),
            DateTimeKey::fromDateTime($command->openedAt()),
            $this->dispenserCostPerUnit,
            $dispenser->flowVolume()
        );

        $this->dispenserUsageRepository->save($dispenserUsage);
    }

    /** @throws DispenserAlreadyOpenedException */
    private function ensureDispenserIsNotOpen(Dispenser $dispenser): void
    {
        $lastDispenserUsage = $this->dispenserUsageRepository->findLast($dispenser->id());

        if (is_null($lastDispenserUsage)) {
            return;
        }

        if (!is_null($lastDispenserUsage->closedAt())) {
            return;
        }

        throw DispenserAlreadyOpenedException::ofId($dispenser->id());
    }
}