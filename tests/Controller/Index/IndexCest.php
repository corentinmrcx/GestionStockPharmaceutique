<?php

namespace App\Tests\Controller\Index;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
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

    public function addToCartFromHomePage(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password']);
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();
        $product = ProductFactory::createOne(['isRecommended' => true, 'category' => $category, 'brand' => $brand]);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful(200);

        $I->click('//button[contains(., "Ajouter au panier")]');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/cart');
        $I->see($product->getName(), 'span');
    }

    public function recommendedProductRedirectsToDetailPage(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne(['nameCategory' => 'Beauté']);
        $brand = BrandFactory::createOne(['name' => 'Marque A']);

        $product = ProductFactory::createOne([
            'name' => 'Produit Test',
            'isRecommended' => true,
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful(200);
        $I->see('Produit Test', '.product-card h5');
        $I->click('Produit Test', '.product-card a');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeCurrentUrlEquals('/product/'.$product->getId());
        $I->see('Produit Test', 'h1.product-title');
    }
}
