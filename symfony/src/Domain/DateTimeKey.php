<?php

declare(strict_types=1);

namespace App\Domain;

class DateTimeKey extends \DateTime
{
    public function __toString()
    {
        return $this->format('c');
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): self
    {
        return new static($dateTime->format('c'));
    }
}