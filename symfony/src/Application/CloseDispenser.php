<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\DispenserAlreadyClosedException;
use App\Domain\DispenserUsage;
use App\Domain\DispenserUsageRepository;

class CloseDispenser
{
    private DispenserUsageRepository $dispenserUsageRepository;

    public function __construct(
        DispenserUsageRepository $dispenserUsageRepository
    ) {
        $this->dispenserUsageRepository = $dispenserUsageRepository;
    }

    /**
     * @throws DispenserAlreadyClosedException
     */
    public function __invoke(CloseDispenserCommand $command): void
    {
        $lastDispenserUsage = $this->dispenserUsageRepository->findLast($command->id());

        if (is_null($lastDispenserUsage)) {
            return;
        }

        $this->ensureDispenserIsNotClosed($lastDispenserUsage);

        $lastDispenserUsage->setClosedAt($command->closedAt());
        $this->dispenserUsageRepository->save($lastDispenserUsage);
    }

    /** @throws DispenserAlreadyClosedException */
    private function ensureDispenserIsNotClosed(?DispenserUsage $dispenserUsage): void
    {
        if (is_null($dispenserUsage->closedAt())) {
            return;
        }

        throw DispenserAlreadyClosedException::ofId($dispenserUsage->id());
    }
}