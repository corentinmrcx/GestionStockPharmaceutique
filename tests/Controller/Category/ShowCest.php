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
}
