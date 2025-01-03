<?php

namespace App\Tests\Controller\Security;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class LoginCest
{
    public function UserCanLoginSuccessfully(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'test']);

        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful(200);
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);
    }

    public function UserCannotLoginWithInvalidCredentials(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'test']);

        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful(200);
        $I->fillField('email', 'wrong@example.com');
        $I->fillField('password', 'wrongpassword');
        $I->click('Connexion');
        $I->see('Identifiants invalides');
    }
}
