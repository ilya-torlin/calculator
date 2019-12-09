<?php

use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class StringLongDigitTest extends Unit
{
    public function testCreateZeroStringLongDigit()
    {
        $longDigit = new StringLongDigit('0');
        $this->assertEquals(1, $longDigit->sign);
        $this->assertEquals(1, $longDigit->exponent);
        $this->assertEquals([0], $longDigit->digits);
    }

    public function testCreateBasicStringLongDigit()
    {
        $longDigit = new StringLongDigit('134');
        $this->assertEquals(1, $longDigit->sign);
        $this->assertEquals(3, $longDigit->exponent);
        $this->assertEquals([1, 3, 4], $longDigit->digits);
    }

    public function testCreateFloatStringLongDigit()
    {
        $longDigit = new StringLongDigit('123382946261.3332');
        $this->assertEquals(1, $longDigit->sign);
        $this->assertEquals(12, $longDigit->exponent);
        $this->assertEquals([1, 2, 3, 3, 8, 2, 9, 4, 6, 2, 6, 1, 3, 3, 3, 2], $longDigit->digits);
    }

    public function testCreateNegativeFloatStringLongDigit()
    {
        $longDigit = new StringLongDigit('-653.12');
        $this->assertEquals(-1, $longDigit->sign);
        $this->assertEquals(3, $longDigit->exponent);
        $this->assertEquals([6, 5, 3, 1, 2], $longDigit->digits);
    }

    public function testCreateExtremelyNegativeFloatStringLongDigit()
    {
        $longDigit = new StringLongDigit('-0.0000000000000000081200');
        $this->assertEquals(-1, $longDigit->sign);
        $this->assertEquals(-17, $longDigit->exponent);
        $this->assertEquals([8, 1, 2], $longDigit->digits);
    }
}
