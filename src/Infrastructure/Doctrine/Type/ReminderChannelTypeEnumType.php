<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Enum\ReminderChannelType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ReminderChannelTypeEnumType extends Type
{
    public const NAME = 'reminder_channel_type_enum';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return self::NAME;
    }

    /**
     * @param mixed|ReminderChannelType $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ReminderChannelType ? $value->value : null;
    }

    /**
     * @param mixed|string $value
     * @param AbstractPlatform $platform
     * @return ReminderChannelType|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ReminderChannelType
    {
        return empty($value) ? null : ReminderChannelType::from($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
