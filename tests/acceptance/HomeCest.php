<?php

use yii\helpers\Url;

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/'));
        $I->seeLink('Home');
    }


    public function ensureTheFormIsPresent(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/'));

        $I->see('Company Symbol');
        $I->see('Start Date');
        $I->see('End Date');
        $I->see('Email');
    }


    public function ensureGridAndChartArePresent(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/'));
        $I->see('Grid');
        $I->see('Chart');
    }
}
