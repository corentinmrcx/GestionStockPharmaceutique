<?php

namespace App\Tests\Controller\Index;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function homePageDisplaysRecommendedProducts(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();
        ProductFactory::createMany(10, [
            'isRecommended' => true,
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful(200);
        $I->see('Nos produits conseils du mois', 'h1');
        $I->seeNumberOfElements('.product-card', 6);

        $recommendedProduct = ProductFactory::last();
        $I->see($recommendedProduct->getName(), '.product-card h5');
        $I->see(number_format($recommendedProduct->getPrice(), 2, ',', ' ').' €', '.product-card .price');
    }
}
