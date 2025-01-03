<?php

namespace App\Tests\Controller\UserDashboard;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class EditCest
{
    public function editProfileDisplaysForLoggedInUser(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password']);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/editprofile/profile/'.$user->getId());
        $I->seeResponseCodeIsSuccessful(200);

        $I->seeElement('form');
        $I->seeInCurrentUrl('/editprofile/profile/'.$user->getId());

        $I->fillField('Prénom *', 'Romain');
        $I->fillField('Nom *', 'Marcoux');
        $I->fillField('Adresse email *', 'romain.marcoux@example.com');
        $I->fillField('Numéro de téléphone *', '0123456789');
        $I->click('Modifier mes informations');

        $I->seeResponseCodeIsSuccessful(200);
        $I->seeCurrentRouteIs('app_user_dashboard');
    }
}
