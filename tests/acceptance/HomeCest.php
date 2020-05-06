<?php

use yii\helpers\Url;

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));        
        $I->see('Local Express Imports');
        
        $I->seeLink('Add Import');
        $I->click('Add Import');
        $I->wait(2); // wait for page to be opened
        
        $I->see('Import Products');
    }
}
