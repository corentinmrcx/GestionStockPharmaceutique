<?php

namespace App\Tests\Controller\Product;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Tests\Support\ControllerTester;

class addToCartAndShowCest
{
    public function showDisplaysCorrectProductDetails(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne(['nameCategory' => 'Beauté']);
        $brand = BrandFactory::createOne(['name' => 'Marque A']);

        $product = ProductFactory::createOne([
            'name' => 'Produit Test',
            'description' => 'Description du produit test',
            'price' => 49.99,
            'reference' => 'REF123',
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/product/'.$product->getId());
        $I->seeResponseCodeIsSuccessful(200);

        $I->see('Produit Test', 'h1.product-title');
        $I->see('49.99€', '.price');
        $I->see('Description du produit test', 'p.product-description');
        $I->see('REF123', '.small p');
        $I->see('Marque A', '.brand p:first-of-type');
        $I->see('Beauté', '.brand p:last-of-type');
    }

    public function showDisplaysSimilarProducts(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne(['nameCategory' => 'Hygiène']);
        $brand = BrandFactory::createOne();

        $product = ProductFactory::createOne([
            'name' => 'Produit Principal',
            'category' => $category,
            'brand' => $brand,
        ]);

        ProductFactory::createMany(4, ['category' => $category]);

        $I->amOnPage('/product/'.$product->getId());
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeNumberOfElements('.similar-product-card', 4);
    }
}
