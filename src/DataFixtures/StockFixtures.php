<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Stock;
use App\Factory\StockFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StockFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = $manager->getRepository(Product::class)->findAll();

        foreach ($products as $product) {
            $stock = new Stock();
            $stock->setQuantity(random_int(10, 100));
            $stock->setAlert(random_int(5, 20));

            $product->setStock($stock);

            $manager->persist($stock);
        }

        $manager->flush();
    }
}
