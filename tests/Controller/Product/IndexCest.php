<?php

namespace App\Tests\Controller\Product;

use App\Factory\BrandFactory;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
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

    public function searchWithMultipleCriteriaDisplaysMatchingProducts(ControllerTester $I): void
    {
        $category1 = CategoryFactory::createOne(['nameCategory' => 'Parapharmacie']);
        $category2 = CategoryFactory::createOne();
        $brand1 = BrandFactory::createOne(['name' => 'Marque A']);
        $brand2 = BrandFactory::createOne();

        ProductFactory::createOne(['name' => 'Produit A', 'description' => 'Produit pour les cheveux', 'category' => $category2, 'brand' => $brand2]);
        ProductFactory::createOne(['name' => 'Produit B', 'description' => 'Produit pour la peau', 'category' => $category1, 'brand' => $brand1]);

        // Recherche par nom
        $I->amOnPage('/product');
        $I->fillField('.search-input', 'Produit A');
        $I->click('.search-bar-icon');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(1, $I->grabMultiple('.product-card'));
        $I->see('Produit A', '.product-card h5');

        // Recherche par description
        $I->amOnPage('/product');
        $I->fillField('.search-input', 'cheveux');
        $I->click('.search-bar-icon');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(1, $I->grabMultiple('.product-card'));
        $I->see('Produit A', '.product-card h5');

        // Recherche par catégorie
        $I->amOnPage('/product');
        $I->fillField('.search-input', 'Parap');
        $I->click('.search-bar-icon');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(1, $I->grabMultiple('.product-card'));
        $I->see('Produit B', '.product-card h5');

        // Recherche par marque
        $I->amOnPage('/product');
        $I->fillField('.search-input', 'Marq');
        $I->click('.search-bar-icon');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(1, $I->grabMultiple('.product-card'));
        $I->see('Produit B', '.product-card h5');
    }

    public function searchReturnsNoResultsWhenNoProductsMatch(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();

        ProductFactory::createOne(['name' => 'Produit A', 'description' => 'Produit pour les cheveux', 'category' => $category, 'brand' => $brand]);
        ProductFactory::createOne(['name' => 'Produit B', 'description' => 'Produit pour la peau', 'category' => $category, 'brand' => $brand]);

        $I->amOnPage('/product');
        $I->fillField('.search-input', 'Produit C');
        $I->click('.search-bar-icon');
        $I->see('Désolé, aucun produit ne correspond à votre recherche.');
    }

    public function FiltersDisplayCorrectProducts(ControllerTester $I): void
    {
        $category1 = CategoryFactory::createOne(['nameCategory' => 'Beauté']);
        $category2 = CategoryFactory::createOne(['nameCategory' => 'Hygiène']);
        $brand1 = BrandFactory::createOne(['name' => 'Marque A']);
        $brand2 = BrandFactory::createOne(['name' => 'Marque B']);

        ProductFactory::createOne(['name' => 'Produit Beauté A', 'price' => 30, 'category' => $category1, 'brand' => $brand1]);
        ProductFactory::createOne(['name' => 'Produit Beauté B', 'price' => 70, 'category' => $category1, 'brand' => $brand2]);
        ProductFactory::createOne(['name' => 'Produit Hygiène A', 'price' => 50, 'category' => $category2, 'brand' => $brand1]);

        // Filtres par catégorie
        $I->amOnPage('/product');
        $I->click('//button[contains(., "Filtrer")]');
        $I->selectOption('select[name="product_filters[category]"]', 'Beauté');
        $I->click('//button[contains(., "Valider")]');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(2, $I->grabMultiple('.product-card'));
        $I->see('Produit Beauté A', '.product-card h5');
        $I->see('Produit Beauté B', '.product-card h5');

        // Filtres par marque
        $I->amOnPage('/product');
        $I->click('//button[contains(., "Filtrer")]');
        $I->selectOption('select[name="product_filters[brand]"]', 'Marque A');
        $I->click('//button[contains(., "Valider")]');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(2, $I->grabMultiple('.product-card'));
        $I->see('Produit Beauté A', '.product-card h5');
        $I->see('Produit Hygiène A', '.product-card h5');

        // Filtres par prix
        $I->amOnPage('/product');
        $I->click('//button[contains(., "Filtrer")]');
        $I->fillField('input[name="product_filters[priceMin]"]', '30');
        $I->fillField('input[name="product_filters[priceMax]"]', '50');
        $I->click('//button[contains(., "Valider")]');
        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(2, $I->grabMultiple('.product-card'));
        $I->see('Produit Beauté A', '.product-card h5');
        $I->see('Produit Hygiène A', '.product-card h5');
    }

    public function combinedFiltersDisplayCorrectProducts(ControllerTester $I): void
    {
        $category1 = CategoryFactory::createOne(['nameCategory' => 'Beauté']);
        $brand1 = BrandFactory::createOne(['name' => 'Marque A']);
        $brand2 = BrandFactory::createOne(['name' => 'Marque B']);

        ProductFactory::createOne(['name' => 'Produit Beauté A', 'price' => 30, 'category' => $category1, 'brand' => $brand1]);
        ProductFactory::createOne(['name' => 'Produit Beauté B', 'price' => 70, 'category' => $category1, 'brand' => $brand2]);
        ProductFactory::createOne(['name' => 'Produit Beauté C', 'price' => 60, 'category' => $category1, 'brand' => $brand1]);

        $I->amOnPage('/product');
        $I->click('//button[contains(., "Filtrer")]');
        $I->selectOption('select[name="product_filters[category]"]', 'Beauté');
        $I->selectOption('select[name="product_filters[brand]"]', 'Marque A');
        $I->fillField('input[name="product_filters[priceMin]"]', '30');
        $I->fillField('input[name="product_filters[priceMax]"]', '50');
        $I->click('//button[contains(., "Valider")]');

        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(1, $I->grabMultiple('.product-card'));
        $I->see('Produit Beauté A', '.product-card h5');
    }

    public function searchWithFiltersDisplaysCorrectProducts(ControllerTester $I): void
    {
        $category = CategoryFactory::createOne(['nameCategory' => 'Beauté']);
        $brand = BrandFactory::createOne(['name' => 'Marque A']);

        ProductFactory::createOne(['name' => 'Produit Cheveux', 'category' => $category, 'brand' => $brand]);
        ProductFactory::createOne(['name' => 'Produit Peau', 'category' => $category, 'brand' => $brand]);

        $I->amOnPage('/product');
        $I->fillField('.search-input', 'Cheveux');
        $I->click('.search-bar-icon');

        $I->click('//button[contains(., "Filtrer")]');
        $I->selectOption('select[name="product_filters[category]"]', 'Beauté');
        $I->click('//button[contains(., "Valider")]');

        $I->seeResponseCodeIsSuccessful(200);
        $I->assertCount(1, $I->grabMultiple('.product-card'));
        $I->see('Produit Cheveux', '.product-card h5');
    }

    public function addToCartWorksForAuthenticatedUser(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'test']);

        $category = CategoryFactory::createOne();
        $brand = BrandFactory::createOne();
        ProductFactory::createOne(['name' => 'Produit Test', 'category' => $category, 'brand' => $brand]);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'test');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/product');
        $I->click('//button[contains(., "Ajouter au panier")]');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/cart');
        $I->seeResponseCodeIsSuccessful(200);
        $I->see(' Produit Test', 'span');
    }
}
