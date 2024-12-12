<?php

namespace App\DataFixtures;

use App\Factory\BrandFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       BrandFactory::createMany(10);
       $manager->flush();
    }
}
