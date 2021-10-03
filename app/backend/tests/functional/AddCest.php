<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class AddCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['admin/add']);
    }

    public function checkEditSubmitNoData(FunctionalTester $I)
    {
        $I->submitForm('#add-form', []);
        $I->see('BankerBook test App | Add Kitchen', 'h1');
        $I->seeValidationError('Name cannot be blank');
    }

    public function checkEditSubmitCorrectData(FunctionalTester $I)
    {
        $I->submitForm('#add-form', [
            'Kitchen[kitchen_name]' => 'tester',
            'Tag[value]' => 'tag1,tag2,tag3'
        ]);
        $I->see('You have successfully added the kitchen.');
    }
}
