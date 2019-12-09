<?php

use app\modules\v1\models\action\MultAction;
use app\modules\v1\models\digit\LongDigit;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class MultActionTest extends Unit
{
    public function testLightStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('3');
        $longDigit2 = new StringLongDigit('4');
        $result = new MultAction();
        $this->assertEquals(new LongDigit(1, 2, [1, 2]), $result->execute($longDigit1, $longDigit2));
    }

    public function testZeroStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('0');
        $longDigit2 = new StringLongDigit('1');
        $result = new MultAction();
        $this->assertEquals(new LongDigit(1, 1, [0]), $result->execute($longDigit1, $longDigit2));
    }

    public function testSecondZeroStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('1234567890.123456789');
        $longDigit2 = new StringLongDigit('0');
        $result = new MultAction();
        $this->assertEquals(new LongDigit(1, 1, [0]), $result->execute($longDigit1, $longDigit2));
    }

    public function testStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('12.001');
        $longDigit2 = new StringLongDigit('123.999');
        $result = new MultAction();
        $this->assertEquals(new LongDigit(1, 4, [1, 4, 8, 8, 1, 1, 1, 9, 9, 9]),
            $result->execute($longDigit1, $longDigit2));
    }

    public function testNegativeStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('-12.001');
        $longDigit2 = new StringLongDigit('123.999');
        $result = new MultAction();
        $this->assertEquals(new LongDigit(-1, 4, [1, 4, 8, 8, 1, 1, 1, 9, 9, 9]),
            $result->execute($longDigit1, $longDigit2));
    }

    public function testSecondNegativeStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('-123456789.0001');
        $longDigit2 = new StringLongDigit('-1.999');
        $result = new MultAction();
        $this->assertEquals(new LongDigit(1, 9, [2, 4, 6, 7, 9, 0, 1, 2, 1, 2, 1, 1, 1, 9, 9, 9]),
            $result->execute($longDigit1, $longDigit2));
    }

    public function testThirdNegativeStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('12.001');
        $longDigit2 = new StringLongDigit('-1.999');
        $result = new MultAction();
        $this->assertEquals(new LongDigit(-1, 2, [2, 3, 9, 8, 9, 9, 9, 9]), $result->execute($longDigit1, $longDigit2));
    }
}
