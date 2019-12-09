<?php

namespace app\tests\unit;

use app\modules\v1\models\calculator\Calculator;
use app\modules\v1\models\digit\LongDigit;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class CalculatorTest extends Unit
{
    public function testCalculatorActions()
    {
        $first = new StringLongDigit('6');
        $second = new StringLongDigit('3');
        $calculator = new Calculator([$first, $second]);
        $this->assertEquals(new LongDigit(1, 1, [9]), $calculator->add());
        $this->assertEquals(new LongDigit(1, 1, [3]), $calculator->sub());
        $this->assertEquals(new LongDigit(1, 2, [1, 8]), $calculator->mult());
    }

    public function testBasicCalculatorActions()
    {
        $first = new StringLongDigit('3.1234567890');
        $second = new StringLongDigit('3');
        $calculator = new Calculator([$first, $second]);
        $this->assertEquals(new LongDigit(1, 1, [6, 1, 2, 3, 4, 5, 6, 7, 8, 9]), $calculator->add());
        $this->assertEquals(new LongDigit(1, 0, [1, 2, 3, 4, 5, 6, 7, 8, 9]), $calculator->sub());
        $this->assertEquals(new LongDigit(1, 1, [9, 3, 7, 0, 3, 7, 0, 3, 6, 7]), $calculator->mult());
    }
    public function testZeroCalculatorActions()
    {
        $first = new StringLongDigit('12345678987654321.98765432123456789');
        $second = new StringLongDigit('0');
        $calculator = new Calculator([$first, $second]);
        $this->assertEquals(new StringLongDigit('12345678987654321.98765432123456789'), $calculator->add());
        $this->assertEquals(new StringLongDigit('12345678987654321.98765432123456789'), $calculator->sub());
        $this->assertEquals(new LongDigit(1, 1, [0]), $calculator->mult());
    }
}
