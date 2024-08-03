<?php

namespace App\Infrastructure\Entity;

use App\Domain\Enum\ReminderChannelType;
use App\Infrastructure\Repository\ReminderRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReminderRepository::class)]
class Reminder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $period = 0;

    #[ORM\Column(name: 'channel_type', type: 'reminder_channel_type_enum')]
    private ReminderChannelType $channelType = ReminderChannelType::TELEGRAM;

    #[ORM\Column(name: 'channel_id', length: 255)]
    private string $channelId = '';

    #[ORM\Column(name: 'is_active')]
    private bool $isActive = false;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriod(): int
    {
        return $this->period;
    }

    public function setPeriod(int $period): static
    {
        $this->period = $period;

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
}
