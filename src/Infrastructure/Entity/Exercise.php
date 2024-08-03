<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Repository\ExerciseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
#[ORM\Table(name: 'exercises')]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = 0;

    #[ORM\Column]
    private int $examinationId = 0;

    #[ORM\Column(length: 255)]
    private string $question = '';

    #[ORM\Column(length: 255)]
    private string $answer = '';

    #[ORM\Column(length: 255)]
    private string $correctAnswer = '';

    #[ORM\Column]
    private bool $isCompleted = false;

    #[ORM\Column]
    private bool $isRight = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getExaminationId(): int
    {
        return $this->examinationId;
    }

    public function setExaminationId(int $examinationId): static
    {
        $this->examinationId = $examinationId;

        return $this;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(string $correctAnswer): static
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function setCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function isRight(): bool
    {
        return $this->isRight;
    }

    public function setRight(bool $isRight): static
    {
        $this->isRight = $isRight;

        return $this;
    }
}
