<?php

namespace App\Infrastructure\Entity;

use App\Domain\Enum\ReminderChannelType;
use App\Infrastructure\Repository\ReminderRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReminderRepository::class)]
#[ORM\Table(name: 'reminders')]
class Reminder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'repeat_period')]
    private int $repeatPeriod = 0;

    #[ORM\Column(name: 'channel_type', type: 'reminder_channel_type_enum')]
    private ReminderChannelType $channelType = ReminderChannelType::TELEGRAM;

    #[ORM\Column(name: 'channel_id', length: 255)]
    private string $channelId = '';

    #[ORM\Column(name: 'is_active')]
    private bool $isActive = false;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: true)]
    private DateTimeInterface $updatedAt;

    #[ORM\Column(name: 'last_reminder_at', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $lastReminderAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepeatPeriod(): int
    {
        return $this->repeatPeriod;
    }

    public function setRepeatPeriod(int $repeatPeriod): static
    {
        $this->repeatPeriod = $repeatPeriod;

        return $this;
    }

    public function getChannelType(): ReminderChannelType
    {
        return $this->channelType;
    }

    public function setChannelType(ReminderChannelType $channelType): static
    {
        $this->channelType = $channelType;

        return $this;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): static
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setLastReminderAt(?DateTimeInterface $lastReminderAt): static
    {
        $this->lastReminderAt = $lastReminderAt;

        return $this;
    }

    public function getLastReminderAt(): ?DateTimeInterface
    {
        return $this->lastReminderAt;
    }
}
