<?php

declare(strict_types=1);

namespace App\Application;

class CreateDispenserCommand
{
    private string $id;
    private string $name;
    private float $flowVolume;

    public function __construct(
        string $id,
        string $name,
        float $flowVolume
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->flowVolume = $flowVolume;
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
}