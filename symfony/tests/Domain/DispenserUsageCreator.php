<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\DateTimeKey;
use App\Domain\DispenserUsage;
use Faker\Factory;

class DispenserUsageCreator
{
    private string $id;
    private \DateTime $openedAt;
    private float $costPerUnit;
    private float $flowVolume;
    private ?\DateTime $closedAt = null;

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setOpenedAt(\DateTime $openedAt): self
    {
        $this->openedAt = $openedAt;
        return $this;
    }

    public function setCostPerUnit(float $costPerUnit): self
    {
        $this->costPerUnit = $costPerUnit;
        return $this;
    }

    public function setFlowVolume(float $flowVolume): self
    {
        $this->flowVolume = $flowVolume;
        return $this;
    }

    public function setClosedAt(?\DateTime $closedAt): self
    {
        $this->closedAt = $closedAt;
        return $this;
    }

    public function build(): DispenserUsage
    {
        $faker = Factory::create();
        $id = $this->id ?? $faker->randomNumber();
        $openedAt = $this->openedAt ?? new \DateTime();
        $costPerUnit = $this->costPerUnit ?? $faker->randomFloat();
        $flowVolume = $this->flowVolume ?? $faker->randomFloat();
        $closedAt = $this->closedAt;

        return new DispenserUsage(
            (string)$id,
            DateTimeKey::fromDateTime($openedAt),
            $costPerUnit,
            $flowVolume,
            $closedAt
        );
    }
}