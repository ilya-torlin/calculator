<?php

namespace app\tests\unit;

use app\modules\v1\models\calculator\Calculator;
use app\modules\v1\models\digit\LongDigit;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class CalculatorTest extends Unit
{
    public function testBasicCalculatorActions()
    {
        $first = new StringLongDigit('6');
        $second = new StringLongDigit('3');
        $calculator = new Calculator([$first, $second]);
        $this->assertEquals(new LongDigit(1, 1, [9]), $calculator->add());
        $this->assertEquals(new LongDigit(1, 1, [3]), $calculator->sub());
        $this->assertEquals(new LongDigit(1, 2, [1, 8]), $calculator->mult());
    }
}
