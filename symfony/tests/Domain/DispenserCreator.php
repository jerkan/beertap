<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Dispenser;
use Faker\Factory;

class DispenserCreator
{
    private string $id;
    private string $name;
    private float $flowVolume;

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setFlowVolume(float $flowVolume): self
    {
        $this->flowVolume = $flowVolume;
        return $this;
    }

    public function build(): Dispenser
    {
        $faker = Factory::create();
        $id = $this->id ?? $faker->uuid;
        $name = $this->name ?? (string)$faker->randomNumber();
        $flowVolume = $this->flowVolume ?? $faker->randomFloat();

        return new Dispenser($id, $name, $flowVolume);
    }
}