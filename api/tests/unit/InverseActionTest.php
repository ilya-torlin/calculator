<?php

use app\modules\v1\models\action\InverseAction;
use app\modules\v1\models\digit\LongDigit;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class InverseActionTest extends Unit
{
    public function testLightLongDigit()
    {
        $longDigit1 = new LongDigit(1, 2, [1, 2]);
        $this->assertEquals(new LongDigit(-1, 2, [1, 2]), $longDigit1->inverseSign());
    }

    public function testLightStringLongDigit()
    {
        $longDigit1 = new StringLongDigit('-123.44');
        $this->assertEquals(new StringLongDigit('123.44'),  $longDigit1->inverseSign());
    }

    public function testZeroStringLongDigit()
    {
        $longDigit1 = new StringLongDigit('0');
        $this->assertEquals(new StringLongDigit('0'),  $longDigit1->inverseSign());
    }

    public function testExtremelyStringLongDigit()
    {
        $longDigit1 = new StringLongDigit('12345567890123456.1234567890');
        $this->assertEquals(new StringLongDigit('-12345567890123456.123456789'), $longDigit1->inverseSign());
    }

    public function testInverseStringLongDigit()
    {
        //$longDigit1 = new StringLongDigit('10');
        //$this->assertEquals(new LongDigit(1, -1, [1, 0]), $longDigit1->inverseLongDigit());
    }


}
