<?php

declare(strict_types=1);

namespace App\Application;

class CloseDispenserCommand
{
    private string $id;
    private ?\DateTime $closedAt;

    public function __construct(string $id, ?\DateTime $closedAt = null)
    {
        $this->id = $id;
        $this->closedAt = $closedAt ?? new \DateTime();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function closedAt(): ?\DateTime
    {
        return $this->closedAt;
    }
}