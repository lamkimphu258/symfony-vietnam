<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne(['email' => 'admin@email.com', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['email' => 'test@email.com']);
        UserFactory::createOne(['email' => 'test2@email.com']);

        $manager->flush();
    }
}
