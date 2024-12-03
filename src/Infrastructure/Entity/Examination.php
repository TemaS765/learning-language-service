<?php

namespace App\Infrastructure\Entity;

use App\Domain\Enum\ExaminationType;
use App\Infrastructure\Repository\ExaminationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExaminationRepository::class)]
#[ORM\Table(name: 'examinations')]
class Examination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = 0;

    #[ORM\Column(type: 'examination_type_enum')]
    private ExaminationType $type;

    #[ORM\Column(name: 'started_at', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(name: 'finished_at', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $finishedAt = null;

    #[ORM\OneToMany(targetEntity: Exercise::class, mappedBy: 'examination_plans')]
    private Collection $exercises;

    public function __construct()
    {
        $this->type = ExaminationType::TRAIN;
        $this->exercises = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function getType(): ExaminationType
    {
        return $this->type;
    }

    public function setType(ExaminationType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(\DateTimeInterface $finishedAt): static
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }
}
