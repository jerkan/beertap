<?php

declare(strict_types=1);

namespace App\Domain;
use Exception;

class DispenserNotFoundException extends Exception
{
    public static function ofId(string $id): self
    {
        return new self(sprintf('Dispenser of id "%s" not found', $id));
    }
}
