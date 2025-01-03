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
        $user = UserFactory::createOne(['email' => 'user@example.com', 'password' => 'password', 'roles' => ['ROLE_USER']]);

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
