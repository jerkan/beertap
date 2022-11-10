<?php

declare(strict_types=1);

namespace App\Application;

class OpenDispenserCommand
{
    private string $id;
    private ?\DateTime $openedAt;

    public function __construct(string $id, ?\DateTime $openedAt = null)
    {
        $this->id = $id;
        $this->openedAt = $openedAt ?? new \DateTime();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function openedAt(): ?\DateTime
    {
        return $this->openedAt;
    }
}