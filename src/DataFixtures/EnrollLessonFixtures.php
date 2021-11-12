<?php

namespace App\DataFixtures;

use App\Entity\EnrollLesson;
use App\Entity\Lesson;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EnrollLessonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $lessons = $manager->getRepository(Lesson::class)->findAll();

        foreach ($users as $user) {
            foreach ($lessons as $lesson) {
                $enrollLesson = new EnrollLesson($user, $lesson);
                if (rand(min: 0, max: 1)) {
                    $enrollLesson->finishLesson();
                }
                $manager->persist($enrollLesson);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            LessonFixtures::class
        ];
    }
}
