<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EnrollCourseRepository;

/**
 * @ORM\Entity(repositoryClass=EnrollCourseRepository::class)
 * @ORM\Table(name="enroll_course" )
 */
class EnrollCourse
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="courses", cascade={"persist"})
     * @ORM\JoinColumn(name="trainee_id", referencedColumnName="id")
     */
    private User $trainee;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="trainees", cascade={"persist"})
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private Course $course;

    /**
     * @ORM\Column(name="finished_at", type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $finishedAt;

    public function __construct(
        User $trainee,
        Course $course
    ) {
        $this->trainee = $trainee;
        $this->course = $course;
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

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function getFinishedAt(): ?DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function finishCourse()
    {
        $this->finishedAt = new DateTimeImmutable();
    }
}
