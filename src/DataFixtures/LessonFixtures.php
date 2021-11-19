<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Factory\LessonFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LessonFixtures extends Fixture implements DependentFixtureInterface
{
    protected const NUMBER_OF_LESSONS = 3;

    public function load(ObjectManager $manager): void
    {
        $courses = $manager->getRepository(Course::class)->findAll();
        foreach ($courses as $course) {
            LessonFactory::createMany(
                self::NUMBER_OF_LESSONS,
                ['course' => $course]
            );
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CourseFixtures::class
        ];
    }
}
