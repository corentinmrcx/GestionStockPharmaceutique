<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductCrudControllerTest extends WebTestCase
{
    public function testIndexPageLoadsSuccessfully(): void
    {
        $client = static::createClient();

        $user = new User();
        $user->setEmail('managertest@example.com');
        $user->setRoles(['ROLE_MANAGER']);
        $client->loginUser($user);

        $client->request('GET', '/manager/?crudControllerFqcn=App\Controller\Manager\ProductCrudController');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('table');
        $this->assertSelectorTextContains('h1', 'Pharmacie - Gestion des produits');
    }

    public function testCreateProduct(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $manager = $userRepository->findOneBy(['roles' => ['ROLE_MANAGER']]);

        $client->loginUser($manager);

        $crawler = $client->request('GET', '/manager/?crudAction=new&crudControllerFqcn=App%5CController%5CManager%5CProductCrudController');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Créer', [
            'Product[name]' => 'Produit Test',
            'Product[description]' => 'Description du produit test',
            'Product[price]' => '25.50',
            'Product[expirationDate]' => '2025-12-31',
            'Product[category]' => '1',
            'Product[brand]' => '1',
            'Product[stock][quantity]' => '100',
            'Product[stock][alert]' => '10',
        ]);

        $this->assertResponseRedirects('manager/?crudAction=index&crudControllerFqcn=App%5CController%5CManager%5CProductCrudController');
        $client->followRedirect();
        $this->assertSelectorTextContains('.name', 'Produit Test');
    }

    public function testInvalidCreateProduct(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $manager = $userRepository->findOneBy(['roles' => ['ROLE_MANAGER']]);

        $client->loginUser($manager);

        $crawler = $client->request('GET', '/manager/?crudAction=new&crudControllerFqcn=App%5CController%5CManager%5CProductCrudController');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Créer', [
            'Product[name]' => 'Produit Test',
            'Product[description]' => 'Description du produit test',
            'Product[price]' => '-25.50',
            'Product[expirationDate]' => '2025-12-31',
            'Product[category]' => '1',
            'Product[brand]' => '1',
            'Product[stock][quantity]' => '100',
            'Product[stock][alert]' => '10',
        ]);

        $this->assertSelectorExists('.form-error-message');
        $this->assertSelectorTextContains('.form-error-message', 'Ce nombre doit être positif.');
    }

    public function testEditProduct(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/manager/?crudControllerFqcn=App\Controller\Manager\ProductCrudController&crudAction=edit&id=1');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form([
            'Product[name]' => 'Produit Modifié',
        ]);

        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertSelectorTextContains('.table', 'Produit Modifié');
    }

    public function testDeleteProduct(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/manager/?crudControllerFqcn=App\Controller\Manager\ProductCrudController&crudAction=delete&id=1');

        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertSelectorNotExists('.table tr:contains("Produit Test")');
    }
}
