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

        $I->see('Produit Test', 'span');
        $I->see('3', 'span');

        $priceCartLine = $product->getPrice() * 3;
        $I->see(' : '.$priceCartLine.' €', 'span');
    }

}
