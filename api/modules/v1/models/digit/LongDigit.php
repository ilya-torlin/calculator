<?php

namespace app\modules\v1\models\digit;

class LongDigit
{
    /*
     * calculation accuracy
     */
    public const DIV_DIGIT = 1000;

    /*
     *  digit sign
     */
    public $sign;

    /*
     * array of digits
     */
    public $digits;

    /*
     * digit exponent
     */
    public $exponent;

    public function __construct(int $sign = 1, int $exponent = 1, array $digits = null)
    {
        $this->sign = $sign;
        $this->exponent = $exponent;
        $this->digits = $digits ?? array_fill(0, 1, 0);
        $this->removeZeros();
    }

    public function removeZeros()
    {
        // zero
        if (count($this->digits) == 1 && $this->digits[0] === 0) {
            $this->exponent = 1;
            $this->sign = 1;
            return null;
        }
        // delete zeros from right side
        while ($this->digits[count($this->digits) - 1] === 0) {
            array_pop($this->digits);
        }
        // delete zeros from left side
        while (count($this->digits) > 1 && $this->digits[0] === 0) {
            array_shift($this->digits);
            $this->exponent--;
        }
        // delete zeros from right side
        while (count($this->digits) > 1 && $this->digits[count($this->digits) - 1] === 0) {
            array_pop($this->digits);
        }
        // zero
        if (count($this->digits) == 1 && $this->digits[0] === 0) {
            $this->exponent = 1;
            $this->sign = 1;
        }
    }
}
