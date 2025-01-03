<?php

namespace App\Tests\Controller\UserDashboard;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function userNotLoggedInIsRedirectedToLogin(ControllerTester $I): void
    {
        $I->amOnPage('/logout');
        $I->amOnPage('/dashboard');
        $I->see('Connexion', 'h1');
        $I->seeInCurrentUrl('/login');
    }

    public function dashboardDisplaysForRoleUser(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password', 'roles' => ['ROLE_USER'],]);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/dashboard');
        $I->seeResponseCodeIsSuccessful(200);

        $I->see('Éditer mon Profil', '.dashboard-card h5');
        $I->see('Éditer mon Mot de passe', '.dashboard-card h5');
        $I->see('Déconnexion', '.dashboard-card h5');

        $I->click('Éditer mon Profil');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeCurrentRouteIs('app_user_edit', ['id' => $user->getId()]);

        $I->amOnPage('/dashboard');
        $I->click('Éditer mon Mot de passe');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeCurrentRouteIs('app_user_edit_password', ['id' => $user->getId()]);

        $I->amOnPage('/dashboard');
        $I->click('Déconnexion');
        $I->seeResponseCodeIsSuccessful(200);
        $I->see('Se déconnecter', 'a');
    }


    public function dashboardDisplaysForRoleManager(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password', 'roles' => ['ROLE_MANAGER']]);

        $I->amOnPage('/login');
        $I->fillField('email', $user->getEmail());
        $I->fillField('password', 'password');
        $I->click('Connexion');
        $I->seeResponseCodeIsSuccessful(200);

        $I->amOnPage('/dashboard');
        $I->seeResponseCodeIsSuccessful(200);

        $I->see('Éditer mon Profil', '.dashboard-card h5');
        $I->see('Éditer mon Mot de passe', '.dashboard-card h5');
        $I->see('Déconnexion', '.dashboard-card h5');
    }

}
