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

    public function ClickOnProductRedirectsToDetailsPage(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        $product = ProductFactory::createOne([
            'name' => 'Produit Test',
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/product');
        $I->click('Produit Test');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeCurrentRouteIs('cart_add_show', ['id' => $product->getId()]);
    }

    public function clickOnNextAndPreviousPaginationLinksWorkCorrectly(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        ProductFactory::createMany(20, [
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/product?page=1');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeNumberOfElements('.product-card', 12);

        $I->click('a[rel="next"]');
        $I->seeInCurrentUrl('page=2');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeNumberOfElements('.product-card', 8);

        $I->click('a[rel="prev"]');
        $I->seeInCurrentUrl('page=1');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeNumberOfElements('.product-card', 12);
    }

    public function searchDisplaysCorrectProducts(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        ProductFactory::createOne(['name' => 'Produit A', 'description' => 'Produit pour les cheveux', 'category' => $category, 'brand' => $brand]);
        ProductFactory::createOne(['name' => 'Produit B', 'description' => 'Produit pour la peau', 'category' => $category, 'brand' => $brand]);

        $I->amOnPage('/product');
        $I->fillField('.search-input', 'cheveux');
        $I->click('.search-bar-icon');

        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(1, $I->grabMultiple('.product-card'));
        $I->see('Produit A', '.product-card h5');
    }

}
