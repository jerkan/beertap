<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Application\ChangeDispenserStatus;
use App\Application\ChangeDispenserStatusCommand;
use App\Domain\Dispenser;
use App\Domain\DispenserNotFoundException;
use App\Domain\DispenserRepository;
use App\Tests\Domain\DispenserCreator;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ChangeDispenserStatusTest extends TestCase
{
    private ChangeDispenserStatus $service;
    /** @var DispenserRepository|MockObject */
    private $repository;

    protected function setUp(): void
    {
        $this->createScenario();
        $this->createSut();
    }

    /** @test */
    public function it_should_throw_when_dispenser_is_not_found()
    {
        $this->expectException(DispenserNotFoundException::class);

        $command = new ChangeDispenserStatusCommand('invalid', 'close', new DateTime());

        $this->service->__invoke($command);
    }

    /**
     * @test
     * @dataProvider it_should_change_dispenser_ok_data_provider
     */
    public function it_should_change_dispenser_ok(string $action)
    {
        $dispenser = $this->createMock(Dispenser::class);
        $this->given_the_dispenser_exists($dispenser);

        $command = new ChangeDispenserStatusCommand(
            'id',
            $action,
            new DateTime()
        );

        $dispenser->expects($this->once())->method($action);
        $this->repository->expects($this->once())->method('save');

        $this->service->__invoke($command);
    }

    public function it_should_change_dispenser_ok_data_provider(): array
    {
        return [
            ['open'], ['close']
        ];
    }

    private function createScenario(): void
    {
        $this->repository = $this->createMock(DispenserRepository::class);
    }

    private function createSut(): void
    {
        $this->service = new ChangeDispenserStatus($this->repository);
    }

    private function given_the_dispenser_exists(Dispenser $dispenser): void
    {
        $this->repository->method('findById')->willReturn($dispenser);
    }
}