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

    public function __construct(
        string $id,
        string $name,
        float $flowVolume,
        ?DateTime $closedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->flowVolume = $flowVolume;

        $this->openedAt = null;
        $this->closedAt = $closedAt ?? new DateTime();
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

    /** @throws DispenserAlreadyOpenedException */
    public function open(DateTime $now): void
    {
        if (!is_null($this->openedAt)) {
            throw DispenserAlreadyOpenedException::ofId($this->id);
        }

        $this->openedAt = $now;
        $this->closedAt = null;
    }
 
    public function close(DateTime $now): void
    {
        $this->openedAt = null;
        $this->closedAt = $now;
    }   
}