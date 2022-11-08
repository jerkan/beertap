<?php

declare(strict_types=1);

namespace App\Domain;
use DateTime;

class Dispenser
{
    private string $id;
    private string $name;
    private float $flowVolume;
    private ?DateTime $openedAt = null;
    private ?DateTime $closedAt = null;

    public function __construct(string $id, string $name, float $flowVolume) {
        $this->id = $id;
        $this->name = $name;
        $this->flowVolume = $flowVolume;

        $this->openedAt = null;
        $this->closedAt = null;
    }

    public function id(): string {
        return $this->id;
    }

    public function name(): string {
        return $this->name;
    }

    public function flowVolume(): float {
        return $this->flowVolume;
    }

    public function openedAt(): ?DateTime {
        return $this->openedAt;
    }

    public function closedAt(): ?DateTime {
        return $this->closedAt;
    }
}