<?php

namespace App\Tests\Controller\Category;

use App\Factory\CategoryFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function categoriesDisplayedCorrectly(ControllerTester $I): void
    {
        $categories = CategoryFactory::createMany(10);

        $I->amOnPage('/category');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(10, $I->grabMultiple('.category-card'));
        $I->see('Nos catégories de produits');
    }


}
