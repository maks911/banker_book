<?php

namespace frontend\tests\functional;

use backend\tests\ApiTester;
use Codeception\Util\HttpCode;
use Faker\Factory;

class SearchCest
{
    public function checkSearchNotCorrect(ApiTester $I)
    {
        $faker = Factory::create();
        $I->sendPost(
            'admin/search',
            [
                'name' => $faker->name
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function checkSearchCorrect(ApiTester $I)
    {
        $I->sendPost(
            'admin/search',
            [
                'name'       => 'Азатская'
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => [
                    'kitchen_name' => ['type' => 'string']
                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }
}
