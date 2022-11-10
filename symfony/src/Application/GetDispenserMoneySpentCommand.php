<?php

declare(strict_types=1);

namespace App\Application;

class GetDispenserMoneySpentCommand
{
    private string $id;
    private ?\DateTime $now;

    public function __construct(
        string $id,
        ?\DateTime $now = null
    ) {
        $this->id = $id;
        $this->now = $now ?? new \DateTime();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function now(): ?\DateTime
    {
        return $this->now;
    }
}