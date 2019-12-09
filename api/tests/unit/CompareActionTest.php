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

    public function testCompareBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1');
        $longDigit2 = new StringLongDigit('12');
        $this->assertEquals(false, $longDigit1->more($longDigit2));
    }

    public function testCompareZeroBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('0');
        $this->assertEquals(false, $longDigit1->more($longDigit2));
    }

    public function testCompareStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1234567.1232123123');
        $longDigit2 = new StringLongDigit('-123123');
        $this->assertEquals(true, $longDigit1->more($longDigit2));
    }

    public function testCompareNegativeStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('-0.00000001232123123');
        $longDigit2 = new StringLongDigit('-0.123123');
        $this->assertEquals(true, $longDigit1->more($longDigit2));
    }
}
