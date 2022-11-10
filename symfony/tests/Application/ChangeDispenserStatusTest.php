<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Application\ChangeDispenserStatus;
use App\Application\ChangeDispenserStatusCommand;
use App\Application\CloseDispenser;
use App\Application\OpenDispenser;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ChangeDispenserStatusTest extends TestCase
{
    private ChangeDispenserStatus $service;
    /** @var OpenDispenser|MockObject */
    private $openDispenser;
    /** @var CloseDispenser|MockObject */
    private $closeDispenser;

    protected function setUp(): void
    {
        $this->createScenario();
        $this->createSut();
    }

    /**
     * @test
     * @dataProvider it_should_change_dispenser_ok_data_provider
     */
    public function it_should_change_dispenser_ok(string $action)
    {
        $command = new ChangeDispenserStatusCommand(
            'id',
            $action,
            new DateTime()
        );

        if ($action === 'open') {
            $this->openDispenser->expects($this->once())->method('__invoke');
        } elseif ($action === 'close') {
            $this->closeDispenser->expects($this->once())->method('__invoke');
        }

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
        $this->openDispenser = $this->createMock(OpenDispenser::class);
        $this->closeDispenser = $this->createMock(CloseDispenser::class);
    }

    private function createSut(): void
    {
        $this->service = new ChangeDispenserStatus($this->openDispenser, $this->closeDispenser);
    }
}