<?php

namespace App\Tests\Controller\Cart;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function UserCanDeleteProductFromCart(ControllerTester $I): void
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
        $I->seeResponseCodeIsSuccessful();

        $I->fillField('input[name="cart_line[quantity]"]', 2);
        $I->click('//button[contains(., "Ajouter au panier")]');

        $I->amOnPage('/cart');
        $I->see(' Produit Test', 'a');
        $I->see(' 2', 'span');
        $I->see('200,00 €', 'span');

        $I->click('form[action^="/cart/delete"] button');
        $I->amOnPage('/cart');
        $I->dontSee(' Produit Test', 'span');
    }
}
