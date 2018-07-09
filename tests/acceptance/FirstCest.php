<?php


class FirstCest
{
    public function homePage(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
    }

    public function loginPage(AcceptanceTester $I)
    {
        $I->amOnPage('/auth');
        $I->fillField('email', 'arliansyah_azhary@yahoo.com');
        $I->fillField('password', '12345');
        $I->click(['name' => 'login']);
        $I->see('Dashboard');
    }
}
