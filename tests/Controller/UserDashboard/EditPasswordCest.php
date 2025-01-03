<?php

namespace App\Tests\Controller\UserDashboard;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class EditPasswordCest
{
    public function editPasswordWithValidData(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password']);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/editprofile/password/'.$user->getId());
        $I->seeResponseCodeIsSuccessful(200);

        $I->fillField('Ancien mot de passe *', 'password');
        $I->fillField('Nouveau mot de passe *', 'newpassword123');
        $I->fillField('Comfirmation du nouveau mot de passe *', 'newpassword123');
        $I->click('Modifier mon mot de passe');
        $I->seeResponseCodeIsSuccessful(200);
    }

    public function editPasswordWithInvalidData(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password']);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/editprofile/password/'.$user->getId());
        $I->seeResponseCodeIsSuccessful(200);

        $I->fillField('Ancien mot de passe *', 'password');
        $I->fillField('Nouveau mot de passe *', 'newpassword123');
        $I->fillField('Comfirmation du nouveau mot de passe *', 'differentpassword');
        $I->click('Modifier mon mot de passe');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeElement('//div[contains(., "Les mots de passe ne correspondent pas.")]');

        $I->fillField('Ancien mot de passe *', 'wrongpassword');
        $I->fillField('Nouveau mot de passe *', 'newpassword123');
        $I->fillField('Comfirmation du nouveau mot de passe *', 'newpassword123');
        $I->click('Modifier mon mot de passe');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeElement('//div[contains(., "Le mot de passe renseigné est incorrect.")]');
    }
}
