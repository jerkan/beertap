<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\DispenserNotFoundException;
use App\Domain\DispenserUsage;
use App\Domain\DispenserUsageRepository;
use App\Domain\Service\DispenserFinder;

class GetDispenserMoneySpent
{
    private DispenserFinder $dispenserFinder;
    private DispenserUsageRepository $dispenserUsageRepository;

    public function __construct(
        DispenserFinder $dispenserFinder,
        DispenserUsageRepository $dispenserUsageRepository
    ) {
        $this->dispenserFinder = $dispenserFinder;
        $this->dispenserUsageRepository = $dispenserUsageRepository;
    }

    /** @throws DispenserNotFoundException */
    public function __invoke(GetDispenserMoneySpentCommand $command): GetDispenserMoneySpentResultDto
    {
        $this->ensureDispenserExists($command);

        $dispenserUsages = $this->dispenserUsageRepository->fetchById($command->id());

        $resultDto = new GetDispenserMoneySpentResultDto();

        /** @var DispenserUsage $dispenserUsage */
        foreach ($dispenserUsages as $dispenserUsage) {
            $resultDto->addUsage(new GetDispenserMoneySpentResultDtoEntry(
                $dispenserUsage->flowVolume(),
                $dispenserUsage->costPerUnit(),
                $dispenserUsage->totalSpent($command->now()),
                $dispenserUsage->openedAt(),
                $dispenserUsage->closedAt()
            ));
        }

        return $resultDto;
    }

    /** @throws DispenserNotFoundException */
    protected function ensureDispenserExists(GetDispenserMoneySpentCommand $command): void
    {
        $this->dispenserFinder->find($command->id());
    }
}