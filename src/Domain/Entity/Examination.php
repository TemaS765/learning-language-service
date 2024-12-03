<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\ExaminationType;

class Examination
{
    private ?int $id;
    private ExaminationType $type;
    private \DateTimeInterface $startedAt;
    private ?\DateTimeInterface $finishedAt = null;

    public function __construct(ExaminationType $type, \DateTimeInterface $startedAt)
    {
        $this->type = $type;
        $this->startedAt = $startedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ExaminationType
    {
        return $this->type;
    }

    public function getStartedAt(): \DateTimeInterface
    {
        return $this->startedAt;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeInterface $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }
}
