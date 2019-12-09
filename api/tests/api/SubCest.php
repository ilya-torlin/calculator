<?php

use Codeception\Util\HttpCode;

class SubCest
{
    public function urlBasicSub(ApiTester $I)
    {
        $params = http_build_query(['first' => '3', 'second' => '1']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '2']);
    }

    public function urlZeroSub(ApiTester $I)
    {
        $params = http_build_query(['first' => '0', 'second' => '0']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '0']);
    }

    public function urlMiddleSub(ApiTester $I)
    {
        $params = http_build_query([
            'first' => '12345654789723489823795283405',
            'second' => '0.123172386178236182361823'
        ]);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '12345654789723489823795283404.876827613821763817638177']);
    }

    public function urlBadParamSub(ApiTester $I)
    {
        $params = http_build_query(['first' => '', 'second' => '0.123172386178236182361823', 'third' => '10']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(['name' => 'Unprocessable entity']);
    }

    public function urlBadParam2Sub(ApiTester $I)
    {
        $params = http_build_query(['first' => '0', 'second' => '']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(['name' => 'Unprocessable entity']);
    }

    public function urlDotParamsSub(ApiTester $I)
    {
        $params = http_build_query(['first' => '123.1', 'second' => '.123456789']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '122.976543211']);
    }

    public function urlFirstNegativeDotParamsSub(ApiTester $I)
    {
        $params = http_build_query(['first' => '-.1', 'second' => '.12345678987654321']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '-0.22345678987654321']);
    }

    public function urlSecondNegativeDotParamsSub(ApiTester $I)
    {
        $params = http_build_query(['first' => '1.1', 'second' => '-0.1234567']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '1.2234567']);
    }

    public function urlNegativeDotParamsSub(ApiTester $I)
    {
        $params = http_build_query(['first' => '-1.1', 'second' => '-0.1234567']);
        $I->sendGET('/sub?' . $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['result' => '-0.9765433']);
    }
}
