<?php

use app\modules\v1\models\action\CompareAction;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class CompareActionTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testMoreBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1');
        $longDigit2 = new StringLongDigit('12');
        $this->assertEquals(false, $longDigit1->more($longDigit2));
    }

    public function testMoreZeroBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('0');
        $this->assertEquals(false, $longDigit1->more($longDigit2));
    }

    public function testMoreStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1234567.1232123123');
        $longDigit2 = new StringLongDigit('-123123');
        $this->assertEquals(true, $longDigit1->more($longDigit2));
    }

    public function testMoreNegativeStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('-0.00000001232123123');
        $longDigit2 = new StringLongDigit('-0.123123');
        $this->assertEquals(true, $longDigit1->more($longDigit2));
    }

    public function testLessBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('23');
        $longDigit2 = new StringLongDigit('12');
        $this->assertEquals(false, $longDigit1->less($longDigit2));
    }

    public function testLessZeroBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('0');
        $this->assertEquals(false, $longDigit1->less($longDigit2));
    }

    public function testLessStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('-12312312345672342343243.1232123123');
        $longDigit2 = new StringLongDigit('123123123123223');
        $this->assertEquals(true, $longDigit1->less($longDigit2));
    }

    public function testLessNegativeStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('-0.00000000000001232123123');
        $longDigit2 = new StringLongDigit('-0.00000000123123');
        $this->assertEquals(false, $longDigit1->less($longDigit2));
    }

    public function testEqualNegativeStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('-0.000123123');
        $longDigit2 = new StringLongDigit('-0.000123123');
        $this->assertEquals(true, $longDigit1->equal($longDigit2));
    }

    public function testEqualStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('123123123123123123123123123123123123');
        $longDigit2 = new StringLongDigit('999999999999999999999999999999999999');
        $this->assertEquals(false, $longDigit1->equal($longDigit2));
    }

    public function testEqualZeroesStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('0');
        $this->assertEquals(true, $longDigit1->equal($longDigit2));
    }
}
