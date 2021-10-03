<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

/* @var $scenario \Codeception\Scenario */

class EditCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['admin/edit']);
    }

    public function checkEditSubmitNoData(FunctionalTester $I)
    {
        $I->submitForm('#edit-form', []);
        $I->see('BankerBook test App | Edit Kitchen', 'h1');
        $I->seeValidationError('Name cannot be blank');
    }

    public function checkEditSubmitCorrectData(FunctionalTester $I)
    {
        $I->submitForm('#add-form', [
            'Kitchen[kitchen_name]' => 'tester',
            'Tag[value]' => 'tag1,tag2,tag3'
        ]);
        $I->see('You have successfully updated the kitchen.');
    }
}
