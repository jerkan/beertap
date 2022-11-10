<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Application\OpenDispenser;
use App\Application\OpenDispenserCommand;
use App\Domain\Dispenser;
use App\Domain\DispenserAlreadyOpenedException;
use App\Domain\DispenserUsageRepository;
use App\Domain\Service\DispenserFinder;
use App\Tests\Domain\DispenserCreator;
use App\Tests\Domain\DispenserUsageCreator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OpenDispenserTest extends TestCase
{
    private const DISPENSER_COST_PER_UNIT = 12.25;

    /** @var DispenserFinder|MockObject */
    private $finder;
    /** @var DispenserUsageRepository|MockObject */
    private $dispenserUsageRepository;
    private OpenDispenser $service;
    private float $dispenserCostPerUnit;

    protected function setUp(): void
    {
        $this->createScenario();
        $this->createSut();
    }

    /** @test */
    public function it_should_throw_when_dispenser_is_already_opened()
    {
        $this->expectException(DispenserAlreadyOpenedException::class);

        $dispenser = (new DispenserCreator())->build();
        $this->given_the_dispenser_is_already_open($dispenser);

        $this->dispenserUsageRepository
            ->expects($this->never())
            ->method('save');

        $command = new OpenDispenserCommand($dispenser->id());
        $this->service->__invoke($command);
    }

    /** @test */
    public function it_should_open_the_dispenser_for_the_first_time()
    {
        $dispenser = (new DispenserCreator())->build();

        $this->dispenserUsageRepository
            ->expects($this->once())
            ->method('save');

        $command = new OpenDispenserCommand($dispenser->id());
        $this->service->__invoke($command);
    }

    /** @test */
    public function it_should_open_the_dispenser_when_it_is_closed()
    {
        $dispenser = (new DispenserCreator())->build();
        $this->given_the_dispenser_is_closed($dispenser);

        $this->dispenserUsageRepository
            ->expects($this->once())
            ->method('save');

        $command = new OpenDispenserCommand($dispenser->id());
        $this->service->__invoke($command);
    }

    private function createScenario(): void
    {
        $this->finder = $this->createMock(DispenserFinder::class);
        $this->dispenserUsageRepository = $this->createMock(DispenserUsageRepository::class);
        $this->dispenserCostPerUnit = self::DISPENSER_COST_PER_UNIT;
    }

    private function createSut(): void
    {
        $this->service = new OpenDispenser(
            $this->finder,
            $this->dispenserUsageRepository,
            $this->dispenserCostPerUnit
        );
    }

    private function given_the_dispenser_is_already_open(Dispenser $dispenser): void
    {
        $dispenserUsage = (new DispenserUsageCreator())
            ->setId($dispenser->id())
            ->setFlowVolume($dispenser->flowVolume())
            ->setCostPerUnit($this->dispenserCostPerUnit)
            ->setOpenedAt(new \DateTime())
            ->setClosedAt(null)
            ->build();

        $this->dispenserUsageRepository
            ->method('findLast')
            ->willReturn($dispenserUsage);
    }

    private function given_the_dispenser_is_closed(Dispenser $dispenser): void
    {
        $dispenserUsage = (new DispenserUsageCreator())
            ->setId($dispenser->id())
            ->setFlowVolume($dispenser->flowVolume())
            ->setCostPerUnit($this->dispenserCostPerUnit)
            ->setOpenedAt(new \DateTime())
            ->setClosedAt(new \DateTime())
            ->build();

        $this->dispenserUsageRepository
            ->method('findLast')
            ->willReturn($dispenserUsage);
    }
}