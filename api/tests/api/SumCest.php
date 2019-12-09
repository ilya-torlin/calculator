<?php

use Codeception\Util\HttpCode;

class SumCest
{
    public function _before(ApiTester $I)
    {
    }

    public function urlSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '3', 'second' => '1']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
