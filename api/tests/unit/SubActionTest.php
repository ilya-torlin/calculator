<?php

use app\modules\v1\models\action\SubAction;
use app\modules\v1\models\digit\LongDigit;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class SubActionTest extends Unit
{
    public function testSubBasicStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1');
        $longDigit2 = new StringLongDigit('12');
        $result = new SubAction();
        $this->assertEquals(new LongDigit(-1, 2, [1, 1]), $result->execute($longDigit1, $longDigit2));
    }

    public function testSubFirstZeroStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('12');
        $result = new SubAction();
        $this->assertEquals(new StringLongDigit('12'), $result->execute($longDigit1, $longDigit2));
    }

    public function testSubSecondZeroStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1234567890.0987654321');
        $longDigit2 = new StringLongDigit('0');
        $result = new SubAction();
        $this->assertEquals(new StringLongDigit('1234567890.0987654321'), $result->execute($longDigit1, $longDigit2));
    }

    public function testSubZeroesStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('0');
        $result = new SubAction();
        $this->assertEquals(new StringLongDigit('0'), $result->execute($longDigit1, $longDigit2));
    }

    public function testSubStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1');
        $longDigit2 = new StringLongDigit('0.0000000000000001');
        $result = new SubAction();
        $this->assertEquals(new LongDigit(1, 0, [9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9]),
            $result->execute($longDigit1, $longDigit2));
    }

    public function testSubSecondStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('1000000000.000000000000000000000000000001');
        $longDigit2 = new StringLongDigit('999999999.000000000000000000000000000001');
        $result = new SubAction();
        $this->assertEquals(new LongDigit(1, 1, [1]), $result->execute($longDigit1, $longDigit2));
    }

    public function testSubSecondNegativeStringLongDigits()
    {
        $longDigit1 = new StringLongDigit('999999999.000000000000000000000000000001');
        $longDigit2 = new StringLongDigit('1000000000.000000000000000000000000000001');
        $result = new SubAction();
        $this->assertEquals(new LongDigit(-1, 1, [1]), $result->execute($longDigit1, $longDigit2));
    }
}
