<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique="true")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EnrollCourse", mappedBy="course")
     */
    private Collection $trainees;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
