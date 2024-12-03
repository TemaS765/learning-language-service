<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class ReminderExercise
{
    private ?int $id;

    public function __construct(
        private int $reminderId,
        private string $question,
        private string $answer,
        private string $correctAnswer,
        private bool $isCompleted,
        private bool $isRight,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReminderId(): int
    {
        return $this->reminderId;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function isRight(): bool
    {
        return $this->isRight;
    }
}
