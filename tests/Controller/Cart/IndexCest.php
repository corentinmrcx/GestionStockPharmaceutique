<?php

namespace App\Tests\Controller\Cart;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function ProductDetailsInCartAreCorrect(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password']);
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();
        $product = ProductFactory::createOne([
            'name' => 'Produit Test',
            'price' => 100,
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amLoggedInAs($user->_real());
        $I->amOnPage('/product/'.$product->getId());
        $I->fillField('input[name="cart_line[quantity]"]', 3);
        $I->click('//button[contains(., "Ajouter au panier")]');
        $I->amOnPage('/cart');

        $I->see('Produit Test', 'a.product_name');
        $I->see('x3', '.cart_line_quantity');
        $I->see('300,00 €', '.price_cartLine');

        $I->see('1', '.recap p .fw-bold');
        $I->see('300,00 €', '.recap p.mb-4 .fw-bold');
    }
}
