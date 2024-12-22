<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne(['firstname' => 'Louis', 'lastname' => 'Baudat', 'email' => 'louis@example.com', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['firstname' => 'Corentin', 'lastname' => 'Marcoux', 'email' => 'corentin@example.com', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['firstname' => 'Romain', 'lastname' => 'Lobreau', 'email' => 'romain@example.com', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['firstname' => 'Peter', 'lastname' => 'Parker', 'email' => 'user@example.com', 'roles' => ['ROLE_CUSTOMER']]);
        UserFactory::createOne(['firstname' => 'Tony', 'lastname' => 'Stark', 'email' => 'manager@example.com', 'roles' => ['ROLE_MANAGER']]);
        UserFactory::createMany(10);
        $manager->flush();
    }
}
