<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Application\CloseDispenser;
use App\Application\CloseDispenserCommand;
use App\Domain\Dispenser;
use App\Domain\DispenserAlreadyClosedException;
use App\Domain\DispenserAlreadyOpenedException;
use App\Domain\DispenserUsageRepository;
use App\Domain\Service\DispenserFinder;
use App\Tests\Domain\DispenserCreator;
use App\Tests\Domain\DispenserUsageCreator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CloseDispenserTest extends TestCase
{
    private const COST_PER_UNIT = 10;

    /** @var DispenserUsageRepository|MockObject */
    private $dispenserUsageRepository;
    private CloseDispenser $service;

    protected function setUp(): void
    {
        $this->createScenario();
        $this->createSut();
    }

    /** @test */
    public function it_should_throw_when_dispenser_is_already_closed()
    {
        $this->expectException(DispenserAlreadyClosedException::class);

        $dispenser = (new DispenserCreator())->build();
        $this->given_the_dispenser_is_already_closed($dispenser);

        $this->dispenserUsageRepository
            ->expects($this->never())
            ->method('save');

        $command = new CloseDispenserCommand($dispenser->id());
        $this->service->__invoke($command);
    }

    /** @test */
    public function it_should_close_the_dispenser_when_it_is_opened()
    {
        $dispenser = (new DispenserCreator())->build();
        $this->given_the_dispenser_is_opened($dispenser);

        $this->dispenserUsageRepository
            ->expects($this->once())
            ->method('save');

        $command = new CloseDispenserCommand($dispenser->id());
        $this->service->__invoke($command);
    }

    private function createScenario(): void
    {
        $this->dispenserUsageRepository = $this->createMock(DispenserUsageRepository::class);
    }

    private function createSut(): void
    {
        $this->service = new CloseDispenser($this->dispenserUsageRepository);
    }

    private function given_the_dispenser_is_already_closed(Dispenser $dispenser): void
    {
        $this->given_the_dispenser_usage_exists(
            $dispenser,
            new \DateTime('-10 seconds'),
            new \DateTime('now')
        );
    }

    private function given_the_dispenser_is_opened(Dispenser $dispenser): void
    {
        $this->given_the_dispenser_usage_exists(
            $dispenser,
            new \DateTime(),
            null
        );
    }

    private function given_the_dispenser_usage_exists(
        Dispenser $dispenser,
        \DateTime $openedAt,
        ?\DateTime $closedAt
    ): void {

        $dispenserUsage = (new DispenserUsageCreator())
            ->setId($dispenser->id())
            ->setFlowVolume($dispenser->flowVolume())
            ->setCostPerUnit(self::COST_PER_UNIT)
            ->setOpenedAt($openedAt)
            ->setClosedAt($closedAt)
            ->build();

        $this->dispenserUsageRepository
            ->method('findLast')
            ->willReturn($dispenserUsage);
    }
}