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

        $beertap = new Dispenser($id, $name, $flowVolume);

        $this->assertSame($id, $beertap->id());
        $this->assertSame($name, $beertap->name());
        $this->assertSame($flowVolume, $beertap->flowVolume());
    }

    /** @test */
    public function it_should_open_properly()
    {
        $dispenser = (new DispenserCreator())->build();

        $openedAt = new \DateTime();
        $dispenser->open($openedAt);

        $this->assertEquals($openedAt, $dispenser->openedAt());
        $this->assertNull($dispenser->closedAt());
    }

    /** @test */
    public function it_should_close_properly()
    {
        $dispenser = (new DispenserCreator())->build();

        $openedAt = new \DateTime('-10 seconds');
        $dispenser->open($openedAt);

        $closedAt = new \DateTime('now');
        $dispenser->close($closedAt);

        $this->assertNull($dispenser->openedAt());
        $this->assertEquals($closedAt, $dispenser->closedAt());
    }

    /** @test */
    public function it_should_throw_attempting_to_open_an_opened_dispenser()
    {
        $this->expectException(DispenserAlreadyOpenedException::class);

        $dispenser = (new DispenserCreator())->build();
        $dispenser->open(new \DateTime());
        $dispenser->open(new \DateTime());
    }

}