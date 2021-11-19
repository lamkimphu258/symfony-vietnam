<?php

namespace App\DataFixtures;

use App\Factory\CourseFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    protected const NUMBER_OF_COURSES = 3;

    public function load(ObjectManager $manager): void
    {
        CourseFactory::createMany(self::NUMBER_OF_COURSES);

        $manager->flush();
    }
}
