<?php

namespace App\Tests\Controller\Category;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function categoryPageDisplaysProducts(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();
        $products = ProductFactory::createMany(10, ['category' => $category, 'brand' => $brand]);

        $I->amOnPage('/category/'.$category->getId());
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(10, $I->grabMultiple('.product-card'));
        $I->see($category->getNameCategory());
    }

    public function clickOnNextAndPreviousPaginationLinksForCategoriesWorkCorrectly(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        ProductFactory::createMany(20, ['category' => $category, 'brand' => $brand]);

        $I->amOnPage('/category/'.$category->getId().'?page=1');
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

    public function ClickOnCategoryProductRedirectsToDetailsPage(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        $product = ProductFactory::createOne([
            'name' => 'Produit Test',
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/category/'.$category->getId());
        $I->click('Produit Test');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeCurrentRouteIs('cart_add_show', ['id' => $product->getId()]);
    }

}
