<?php

declare(strict_types=1);

namespace App\Application;

class GetDispenserMoneySpentResultDtoEntry
{
    private float $flowVolume;
    private float $costPerUnit;
    private float $totalSpent;
    private \DateTime $openedAt;
    private ?\DateTime $closedAt;

    public function __construct(
        float $flowVolume,
        float $costPerUnit,
        float $totalSpent,
        \DateTime $openedAt,
        ?\DateTime $closedAt = null
    ) {
        $this->flowVolume = $flowVolume;
        $this->costPerUnit = $costPerUnit;
        $this->totalSpent = $totalSpent;
        $this->openedAt = $openedAt;
        $this->closedAt = $closedAt;
    }

    public function flowVolume(): float
    {
        return $this->flowVolume;
    }

    public function costPerUnit(): float
    {
        return $this->costPerUnit;
    }

    public function totalSpent(): float
    {
        return $this->totalSpent;
    }

    public function openedAt(): \DateTime
    {
        return $this->openedAt;
    }

    public function closedAt(): ?\DateTime
    {
        return $this->closedAt;
    }
}