<?php

declare(strict_types=1);

namespace App\Application;

class GetDispenserMoneySpentResultDto
{
    /** @var GetDispenserMoneySpentResultDtoEntry[] */
    private array $usages;
    private float $totalAmount = 0;

    public function addUsage(GetDispenserMoneySpentResultDtoEntry $entry): void
    {
        $this->usages[] = $entry;
        $this->totalAmount += $entry->totalSpent();
    }

    public function usages(): array
    {
        return $this->usages;
    }

    public function totalAmount(): float
    {
        return $this->totalAmount;
    }
}