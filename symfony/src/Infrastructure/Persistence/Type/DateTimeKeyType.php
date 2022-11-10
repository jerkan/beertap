<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Type;

use App\Domain\DateTimeKey;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class DateTimeKeyType extends DateTimeType
{
    private const NAME = 'datetime_key';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        if ($value !== null) {
            $value = DateTimeKey::fromDateTime($value);
        }
        return $value;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}