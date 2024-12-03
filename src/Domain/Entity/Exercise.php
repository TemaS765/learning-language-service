<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ObjectValue\Text;

class Exercise
{
    private ?int $id = null;
    private Text $question;
    private Text $answer;
    private Text $correctAnswer;
    private bool $isCompleted;
    private bool $isRight;

    public function __construct(
        Text $question,
        Text $answer,
        Text $correctAnswer,
        bool $isCompleted,
        bool $isRight,
    ) {
        $this->question = $question;
        $this->answer = $answer;
        $this->correctAnswer = $correctAnswer;
        $this->isCompleted = $isCompleted;
        $this->isRight = $isRight;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): Text
    {
        return $this->question;
    }

    public function getAnswer(): Text
    {
        return $this->answer;
    }

    public function getCorrectAnswer(): Text
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
