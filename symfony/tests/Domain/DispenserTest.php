<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Dispenser;
use App\Domain\DispenserAlreadyOpenedException;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class DispenserTest extends TestCase
{
    /** @test */
    public function it_should_instantiate_ok()
    {
        $faker = Factory::create();

        $id = $faker->uuid;
        $name = $faker->name;
        $flowVolume = $faker->randomFloat();

        $dispenser = new Dispenser($id, $name, $flowVolume);

        $this->assertSame($id, $dispenser->id());
        $this->assertSame($name, $dispenser->name());
        $this->assertSame($flowVolume, $dispenser->flowVolume());
    }
}