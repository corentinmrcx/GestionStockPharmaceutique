<?php

namespace App\Tests\Controller\Security;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class LogoutCest
{
    public function UserCanLogoutSuccessfully(ControllerTester $I): void
    {
        $userTest = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'test']);
        $user = $userTest->_real();

        $I->amLoggedInAs($user);
        $I->amOnPage('/dashboard');
        $I->seeResponseCodeIsSuccessful(200);
        $I->click('Déconnexion');
        $I->seeResponseCodeIsSuccessful(200);
        $I->click('Se déconnecter', 'a');

        $I->amOnPage('/dashboard');
        $I->seeCurrentUrlEquals('/login');
    }
}
