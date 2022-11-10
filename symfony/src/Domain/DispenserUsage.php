<?php

declare(strict_types=1);

namespace App\Domain;

class DispenserUsage
{
    private string $id;
    private DateTimeKey $openedAt;
    private float $costPerUnit;
    private float $flowVolume;
    private ?\DateTime $closedAt;

    public function __construct(
        string $id,
        DateTimeKey $openedAt,
        float $costPerUnit,
        float $flowVolume,
        ?\DateTime $closedAt = null
    ) {
        $this->id = $id;
        $this->openedAt = $openedAt;
        $this->costPerUnit = $costPerUnit;
        $this->flowVolume = $flowVolume;
        $this->closedAt = $closedAt;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function openedAt(): DateTimeKey
    {
        return $this->openedAt;
    }

    public function costPerUnit(): float
    {
        return $this->costPerUnit;
    }

    public function flowVolume(): float
    {
        return $this->flowVolume;
    }

    public function closedAt(): ?\DateTime
    {
        return $this->closedAt;
    }

    public function setClosedAt(?\DateTime $closedAt): self
    {
        $this->closedAt = $closedAt;
        return $this;
    }
}