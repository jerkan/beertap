<?php

declare(strict_types=1);

namespace App\Domain;

final class DispenserAlreadyOpenedException extends \Exception
{
    public static function ofId(string $id): self
    {
        return new self(sprintf('Dispenser with id "%s" is already opened.', $id));
    }
}