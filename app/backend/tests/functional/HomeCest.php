<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('BankerBook test App');
        $I->seeLink('Add Kitchen');
        $I->click('Add Kitchen');
        $I->see('BankerBook test App | Add Kithcen');
        $I->seeLink('Kitchens List');
        $I->click('Kitchens List');
        $I->see('BankerBook test App');
    }
}