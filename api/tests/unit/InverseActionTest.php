<?php

use app\modules\v1\models\action\InverseAction;
use app\modules\v1\models\digit\LongDigit;
use app\modules\v1\models\digit\StringLongDigit;
use Codeception\Test\Unit;

class InverseActionTest extends Unit
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

    public function testLightLongDigitMultiplication()
    {
        $longDigit1 = new LongDigit(1, 2, [1, 2]);
        $result = new InverseAction();
        $this->assertEquals(new LongDigit(-1, 2, [1, 2]), $result->execute($longDigit1));
    }

    public function testLightStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('-123.44');
        $result = new InverseAction();
        $this->assertEquals(new StringLongDigit('123.44'), $result->execute($longDigit1));
    }

    public function testZeroStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('0');
        $result = new InverseAction();
        $this->assertEquals(new StringLongDigit('0'), $result->execute($longDigit1));
    }

    public function testExtremelyStringLongDigitMultiplication()
    {
        $longDigit1 = new StringLongDigit('12345567890123456.1234567890');
        $result = new InverseAction();
        $this->assertEquals(new StringLongDigit('-12345567890123456.1234567890'), $result->execute($longDigit1));
    }
}
