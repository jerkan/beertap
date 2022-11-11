<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use PHPUnit\Framework\TestCase;

class DispenserUsageTest extends TestCase
{
    /**
     * @test
     * @dataProvider it_should_calculate_total_spent_properly_data_provider
     */
    public function it_should_calculate_total_spent_properly(
        float $flowVolume,
        float $costPerUnit,
        \DateTime $openedAt,
        ?\DateTime $closedAt,
        \DateTime $now,
        float $expectedTotalSpent
    ) {
        $dispenserUsage = (new DispenserUsageCreator())
            ->setFlowVolume($flowVolume)
            ->setCostPerUnit($costPerUnit)
            ->setOpenedAt($openedAt)
            ->setClosedAt($closedAt)
            ->build();

        $this->assertSame($expectedTotalSpent, $dispenserUsage->totalSpent($now));
    }

    public function it_should_calculate_total_spent_properly_data_provider(): array
    {
        return [
            [
                0.064,
                12.25,
                new \DateTime('2022-01-01T02:00:00Z'),
                new \DateTime('2022-01-01T02:00:50Z'),
                new \DateTime('2022-01-01T02:00:50Z'),
                39.2
            ],
            [
                0.064,
                12.25,
                new \DateTime('2022-01-01T02:50:58Z'),
                new \DateTime('2022-01-01T02:51:20Z'),
                new \DateTime('2022-01-01T02:51:20Z'),
                17.248
            ],
            [
                0.064,
                12.25,
                new \DateTime('2022-01-01T13:50:58Z'),
                null,
                new \DateTime('2022-01-01T13:51:03Z'),
                3.92
            ],
        ];
    }

}