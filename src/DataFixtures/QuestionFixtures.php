<?php

namespace App\DataFixtures;

use App\Entity\Lesson;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    protected const NUMBER_OF_LESSON = 3;

    public function load(ObjectManager $manager): void
    {
        $lessons = $manager->getRepository(Lesson::class)->findAll();
        foreach ($lessons as $lesson) {
            QuestionFactory::createMany(
                self::NUMBER_OF_LESSON,
                ['lesson' => $lesson]
            );
        }
    }

    public function getDependencies()
    {
        return [
            LessonFixtures::class
        ];
    }
}
