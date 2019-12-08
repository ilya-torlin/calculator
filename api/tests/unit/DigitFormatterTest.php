<?php

namespace app\tests\unit;

use app\modules\v1\models\digit\StringLongDigit;
use app\modules\v1\models\formatter\DigitFormatter;
use Codeception\Test\Unit;

class DigitFormatterTest extends Unit
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

    public function testZeroFormatter()
    {
        $longDigit = new StringLongDigit('0');
        $formatter = new DigitFormatter($longDigit);
        $this->assertEquals('0', $formatter->result());
    }

    public function testBasicFormatter()
    {
        $longDigit = new StringLongDigit('134');
        $formatter = new DigitFormatter($longDigit);
        $this->assertEquals('134', $formatter->result());
    }

    public function testFloatFormatter()
    {
        $longDigit = new StringLongDigit('123382946261.3332');
        $formatter = new DigitFormatter($longDigit);
        $this->assertEquals('123382946261.3332', $formatter->result());
    }

    public function testNegativeFloatFormatter()
    {
        $longDigit = new StringLongDigit('-653.12');
        $formatter = new DigitFormatter($longDigit);
        $this->assertEquals('-653.12', $formatter->result());
    }

    public function testExtremelyNegativeFloatFormatter()
    {
        $longDigit = new StringLongDigit('-0.0000000000000000081200');
        $formatter = new DigitFormatter($longDigit);
        $this->assertEquals('-0.00000000000000000812', $formatter->result());
    }

    public function testExtremely2NegativeFloatFormatter()
    {
        $longDigit = new StringLongDigit('123154654.1234543245643245643456434565434567543234567876');
        $formatter = new DigitFormatter($longDigit);
        $this->assertEquals('123154654.1234543245643245643456434565434567543234567876', $formatter->result());
    }
}
