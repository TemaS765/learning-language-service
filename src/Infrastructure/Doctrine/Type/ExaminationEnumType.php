<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Enum\ExaminationType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ExaminationEnumType extends Type
{
    public const NAME = 'examination_type_enum';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return self::NAME;
    }

    /**
     * @param mixed|ExaminationType $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ExaminationType ? $value->value : null;
    }

    /**
     * @param mixed|string $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ExaminationType
    {
        return empty($value) ? null : ExaminationType::from($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
