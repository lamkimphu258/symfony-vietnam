<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\EnrollCourse;
use App\Entity\User;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EnrollCourseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $courses = $manager->getRepository(Course::class)->findAll();

        foreach($users as $user) {
            foreach ($courses as $course) {
                $enrollCourse = new EnrollCourse($user, $course);
                if (rand(min:0, max:1)) {
                    $enrollCourse->finishCourse();
                }
                $manager->persist($enrollCourse);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CourseFixtures::class
        ];
    }
}
