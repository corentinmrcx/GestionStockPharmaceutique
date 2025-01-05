<?php

namespace App\Tests\Controller\Security;

use App\Tests\Support\ControllerTester;

class RegistrationCest
{
    public function UserCanRegisterSuccessfully(ControllerTester $I): void
    {
        $I->amOnPage('/');
        $I->click('Se connecter');
        $I->click('Pas encore inscrit ? Créez votre compte ici !');
        $I->seeCurrentUrlEquals('/registration');
        $I->seeResponseCodeIsSuccessful(200);

        $I->fillField('Prénom *', 'Romain');
        $I->fillField('Nom *', 'Marcoux');
        $I->fillField('Adresse email *', 'romain.marcoux@example.com');
        $I->fillField('Mot de passe *', 'password123');
        $I->fillField('Confirmer mot de passe *', 'password123');
        $I->fillField('Numéro de téléphone *', '0123456789');
        $I->click('S\'inscrire');
        $I->seeResponseCodeIsSuccessful(200);
    }

    public function UserCannotRegisterWithInvalidData(ControllerTester $I): void
    {
        $I->amOnPage('/');
        $I->click('Se connecter');
        $I->click('Pas encore inscrit ? Créez votre compte ici !');
        $I->seeCurrentUrlEquals('/registration');
        $I->seeResponseCodeIsSuccessful(200);

        $I->fillField('Prénom *', 'A');
        $I->fillField('Nom *', 'B');
        $I->fillField('Adresse email *', 'invalid-email');
        $I->fillField('Mot de passe *', 'pass');
        $I->fillField('Confirmer mot de passe *', 'passw');
        $I->fillField('Numéro de téléphone *', '0123');
        $I->click('S\'inscrire');

        $I->seeElement('//div[contains(., "Le prénom ne doit pas être inférieur à 2 caractères.")]');
        $I->seeElement('//div[contains(., "Le nom ne doit pas être inférieur à 2 caractères.")]');
        $I->seeElement('//div[contains(., "Les mots de passe ne correspondent pas.")]');
        $I->seeElement('//div[contains(., "Le numéro de téléphone doit contenir 10 chiffres.")]');
    }

}
