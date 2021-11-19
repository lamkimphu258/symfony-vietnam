<?php

namespace App\Entity;

use App\Repository\EnrollLessonRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnrollLessonRepository::class)
 * @ORM\Table(name="enroll_lesson" )
 */
class EnrollLesson
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lessons", cascade={"persist"})
     * @ORM\JoinColumn(name="trainee_id", referencedColumnName="id")
     */
    private User $trainee;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="trainees", cascade={"persist"})
     * @ORM\JoinColumn(name="lesson_id", referencedColumnName="id")
     */
    private Lesson $lesson;

    /**
     * @ORM\Column(name="finished_at", type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $finishedAt;

    public function __construct(
        User $trainee,
        Lesson $lesson
    ) {
        $this->trainee = $trainee;
        $this->lesson = $lesson;
        $this->finishedAt = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainee(): User
    {
        return $this->trainee;
    }

    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    public function getFinishedAt(): ?DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function finishLesson()
    {
        $this->finishedAt = new DateTimeImmutable();
    }
}
