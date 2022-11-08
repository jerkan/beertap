<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Dispenser;
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
        $flowVolume = $faker->randomFloat;

        $beertap = new Dispenser($id, $name, $flowVolume);

        $this->assertSame($id, $beertap->id());
        $this->assertSame($name, $beertap->name());
        $this->assertSame($flowVolume, $beertap->flowVolume());
    }
}