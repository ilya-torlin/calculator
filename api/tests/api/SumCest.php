<?php

use Codeception\Util\HttpCode;

class SumCest
{
    public function urlBasicSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '3', 'second' => '1']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '4']);
    }

    public function urlZeroSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '0', 'second' => '0']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0']);
    }

    public function urlMiddleSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '12345654789723489823795283405', 'second' => '0.123172386178236182361823']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '12345654789723489823795283405.123172386178236182361823']);
    }

    public function urlThirdSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '12345654789723489823795283405', 'second' => '0.123172386178236182361823', 'third' => '10']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '12345654789723489823795283415.123172386178236182361823']);
    }

    public function urlBadParamSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '', 'second' => '0.123172386178236182361823', 'third' => '10']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(['name' => 'Unprocessable entity']);
    }

    public function urlBadParam2Sum(ApiTester $I)
    {
        $params = http_build_query(['first' => '0', 'second' => '']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(['name' => 'Unprocessable entity']);
    }

    public function urlDotParamsSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '.1', 'second' => '.12345678987654321']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0.22345678987654321']);
    }

    public function urlFirstNegativeDotParamsSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '-.1', 'second' => '.12345678987654321']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0.02345678987654321']);
    }

    public function urlSecondNegativeDotParamsSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '1.1', 'second' => '-0.1234567']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0.9765433']);
    }

    public function urlNegativeDotParamsSum(ApiTester $I)
    {
        $params = http_build_query(['first' => '-1.1', 'second' => '-0.1234567']);
        $I->sendGET('/sum?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '-1.2234567']);
    }
}
