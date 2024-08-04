<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Model;

use App\Domain\Enum\ReminderChannelType;

class UpdateReminderFormModel
{
    private int $id = 0;
    private int $repeatPeriod = 0;
    private ReminderChannelType $channelType = ReminderChannelType::TELEGRAM;
    private string $channelId = '';
    private bool $isActive = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRepeatPeriod(): int
    {
        return $this->repeatPeriod;
    }

    public function setRepeatPeriod(int $repeatPeriod): void
    {
        $this->repeatPeriod = $repeatPeriod;
    }

    public function getChannelType(): ReminderChannelType
    {
        return $this->channelType;
    }

    public function setChannelType(ReminderChannelType $channelType): void
    {
        $this->channelType = $channelType;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }
}
