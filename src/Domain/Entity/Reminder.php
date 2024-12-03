<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\ReminderChannelType;

class Reminder
{
    private ?int $id;
    private int $repeatPeriod;
    private ReminderChannelType $channelType;
    private string $channelId;
    private bool $isActive;
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;
    private ?\DateTimeInterface $lastReminderAt = null;

    public function __construct(
        int $repeatPeriod,
        ReminderChannelType $channelType,
        string $channelId,
        bool $isActive,
    ) {
        $this->repeatPeriod = $repeatPeriod;
        $this->channelType = $channelType;
        $this->channelId = $channelId;
        $this->isActive = $isActive;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepeatPeriod(): int
    {
        return $this->repeatPeriod;
    }

    public function getChannelType(): ReminderChannelType
    {
        return $this->channelType;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getLastReminderAt(): ?\DateTimeInterface
    {
        return $this->lastReminderAt;
    }
}
