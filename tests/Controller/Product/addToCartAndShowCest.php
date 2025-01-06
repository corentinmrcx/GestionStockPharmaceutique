<?php

namespace App\Tests\Controller\Product;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Factory\StockFactory;
use App\Factory\UserFactory;
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

    public function showDisplaysNoSimilarProductsIfNoneExist(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne(['nameCategory' => 'Hygiène']);
        $brand = BrandFactory::createOne();

        $product = ProductFactory::createOne([
            'name' => 'Produit Principal',
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/product/'.$product->getId());
        $I->seeResponseCodeIsSuccessful(200);
        $I->dontSeeElement('.similar-product-card');
    }

    public function addToCartFromShowPageForAuthenticatedUser(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password']);
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();
        $stock = StockFactory::createOne(['quantity' => '30', 'alert' => 10]);
        $product = ProductFactory::createOne(['name' => 'Produit Test', 'category' => $category, 'brand' => $brand, 'stock' => $stock]);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/product/'.$product->getId());
        $I->fillField('input[name="cart_line[quantity]"]', 2);
        $I->click('//button[contains(., "Ajouter au panier")]');

        $I->amOnPage('/cart');
        $I->seeResponseCodeIsSuccessful(200);
        $I->see(' Produit Test', 'a');
        $I->see(' x2', '.cart_line_quantity');
    }

    public function similarProductButtonRedirectsToShowPage(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne(['nameCategory' => 'Beauté']);
        $brand = BrandFactory::createOne(['name' => 'Marque A']);

        $product = ProductFactory::createOne([
            'name' => 'Produit Principal',
            'category' => $category,
            'brand' => $brand,
        ]);
        $similarProduct = ProductFactory::createOne([
            'name' => 'Produit Similaire',
            'category' => $category,
            'brand' => $brand,
        ]);

        $I->amOnPage('/product/'.$product->getId());
        $I->seeResponseCodeIsSuccessful(200);

        $I->see('Produit Similaire', '.similar-product-card .card-title');
        $I->seeElement('.similar-product-card a.btn-custom');

        $I->click('Voir le produit', '.similar-product-card');
        $I->seeResponseCodeIsSuccessful(200);

        $I->seeCurrentUrlEquals('/product/'.$similarProduct->getId());
        $I->see('Produit Similaire', 'h1.product-title');
    }
}
