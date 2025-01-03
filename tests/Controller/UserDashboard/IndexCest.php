<?php

namespace App\Tests\Controller\UserDashboard;

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
}
