<?php

use app\modules\v1\models\action\SumAction;
use app\modules\v1\models\digit\LongDigit;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class SumActionTest extends Unit
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

    public function testSumBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1');
        $longDigit2 = new StringLongDigit('12');
        $result = new SumAction();
        $this->assertEquals(new LongDigit(1, 2, [1, 3]), $result->execute($longDigit1, $longDigit2));
    }

    public function testSumFirstZeroStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('12');
        $result = new SumAction();
        $this->assertEquals(new StringLongDigit('12'), $result->execute($longDigit1, $longDigit2));
    }

    public function testSumSecondZeroStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1234567890.0987654321');
        $longDigit2 = new StringLongDigit('0');
        $result = new SumAction();
        $this->assertEquals(new StringLongDigit('1234567890.0987654321'), $result->execute($longDigit1, $longDigit2));
    }

    public function testSumZeroesStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('0');
        $result = new SumAction();
        $this->assertEquals(new StringLongDigit('0'), $result->execute($longDigit1, $longDigit2));
    }

    public function testSumStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0.9876543210');
        $longDigit2 = new StringLongDigit('0.123456789');
        $result = new SumAction();
        $this->assertEquals(new LongDigit(1,1,[1, 1, 1, 1, 1, 1, 1, 1, 1]), $result->execute($longDigit1, $longDigit2));
    }
}