<?php

namespace App\Tests\Controller\Product;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function cataloguePageDisplaysCorrectTitleAndProductCount(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        ProductFactory::createMany(5, [
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/product');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeInTitle('Catalogue');
        $I->see('Notre catalogue de produits', 'h1');
        $I->seeNumberOfElements('.product-card a', 5);
    }

    public function ProductDisplaysCorrectDetails(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        $product = ProductFactory::createOne([
            'name' => 'Produit Test',
            'description' => 'Description test produit',
            'price' => 49.99,
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/product');
        $I->seeResponseCodeIsSuccessful(200);
        $I->see('Produit Test', '.product-card h5');
        $I->see('Description test produit', '.product-card p');
        $I->see('49,99 €', '.product-card .price');
    }
}
