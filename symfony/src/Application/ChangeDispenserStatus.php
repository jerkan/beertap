<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\DispenserAlreadyClosedException;
use App\Domain\DispenserAlreadyOpenedException;
use App\Domain\DispenserNotFoundException;

class ChangeDispenserStatus
{
    private OpenDispenser $openDispenser;
    private CloseDispenser $closeDispenser;

    public function __construct(
        OpenDispenser $openDispenser,
        CloseDispenser $closeDispenser
    ) {
        $this->openDispenser = $openDispenser;
        $this->closeDispenser = $closeDispenser;
    }

    /**
     * @throws DispenserNotFoundException
     * @throws DispenserAlreadyOpenedException
     * @throws DispenserAlreadyClosedException
     */
    public function __invoke(ChangeDispenserStatusCommand $command): void
    {
        if ($command->isStatusOpen()) {
            $this->openDispenser->__invoke(
                new OpenDispenserCommand($command->id(), $command->updatedAt())
            );
        } elseif ($command->isStatusClose()) {
            $this->closeDispenser->__invoke(
                new CloseDispenserCommand($command->id(), $command->updatedAt())
            );
        }
    }
}