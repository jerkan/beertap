<?php

declare(strict_types=1);

namespace App\Application;

use DateTime;

class ChangeDispenserStatusCommand
{
    private string $id;
    private string $status;
    private DateTime $updatedAt;

    public function __construct(
        string $id,
        string $status,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->updatedAt = $updatedAt;
    }

    public function id(): string 
    {
        return $this->id;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function isStatusOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isStatusClose(): bool
    {
        return $this->status === 'close';
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}