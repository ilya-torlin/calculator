<?php

use Codeception\Util\HttpCode;

class MultCest
{
    public function urlBasicMult(ApiTester $I)
    {
        $params = http_build_query(['first' => '3', 'second' => '120']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '360']);
    }

    public function urlZeroMult(ApiTester $I)
    {
        $params = http_build_query(['first' => '0', 'second' => '0']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0']);
    }

    public function urlMiddleMult(ApiTester $I)
    {
        $params = http_build_query(['first' => '12345654789723489823795283405', 'second' => '0.123172386178236182361823']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '1520643759383012900320854147.431300652230240537447315']);
    }

    public function urlBadParamMult(ApiTester $I)
    {
        $params = http_build_query(['first' => '', 'second' => '0.123172386178236182361823']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(['name' => 'Unprocessable entity']);
    }

    public function urlBadParam2Mult(ApiTester $I)
    {
        $params = http_build_query(['first' => '0', 'second' => '']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(['name' => 'Unprocessable entity']);
    }

    public function urlDotParamsMult(ApiTester $I)
    {
        $params = http_build_query(['first' => '.1', 'second' => '.12345678987654321']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0.012345678987654321']);
    }

    public function urlNegativeParamsMult(ApiTester $I)
    {
        $params = http_build_query(['first' => '-.1', 'second' => '-.12345678987654321']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0.012345678987654321']);
    }

    public function urlFirstNegativeParamsMult(ApiTester $I)
    {
        $params = http_build_query(['first' => '.1', 'second' => '-.12345678987654321']);
        $I->sendGET('/mult?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '-0.012345678987654321']);
    }
}
