<?php

namespace app\modules\v1\models\digit;

use app\modules\v1\models\action\SubAction;
use yii\web\UnprocessableEntityHttpException;

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
        $this->removeZeroes();
    }

    public function removeZeroes()
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

    public function zeroCheck(): bool
    {
        if (count($this->digits) == 1 && $this->digits[0] === 0) {
            return true;
        }
        return false;
    }

    public function inverseSign(): LongDigit
    {
        if (count($this->digits) == 1 && $this->digits[0] === 0) {
            return $this;
        }
        $this->sign = -$this->sign;
        return $this;
    }

    public function more(LongDigit $second): bool
    {
        if ($this->sign !== $second->sign) {
            return $this->sign > $second->sign;
        }
        if ($this->exponent != $second->exponent) {
            return ($this->exponent > $second->exponent) ^ ($this->sign == -1);
        }

        $currentFirst = $this->digits;
        $currentSecond = $second->digits;
        $length = max(count($currentFirst), count($currentSecond));
        while (count($currentFirst) !== $length) {
            array_push($currentSecond, 0);
        }
        while (count($currentSecond) !== $length) {
            array_push($currentSecond, 0);
        }

        // проходим по всем цифрам числа
        for ($count = 0; $count < $length; $count++) {
            if ($currentFirst[$count] != $currentSecond[$count]) {
                return ($currentFirst[$count] > $currentSecond[$count]) ^ ($this->sign == -1);
            }
        }
        return false;
    }

    public function less(LongDigit $second): bool
    {
        return !($this->more($second) || $this->equal($second));
    }

    public function equal(LongDigit $second): bool
    {
        if ($this->sign !== $second->sign) {
            return false;
        }
        if ($this->exponent !== $second->exponent) {
            return false;
        }
        if (count($this->digits) !== count($second->digits)) {
            return false;
        }
        for ($count = 0; $count < count($this->digits); $count++) {
            if ($this->digits[$count] !== $second->digits[$count]) {
                return false;
            }
        }
	    return true;
    }

    public function inverseLongDigit(): LongDigit
    {
        if ($this->zeroCheck()) {
            throw new UnprocessableEntityHttpException('LongDigit::inverseLongDigit() - division by zero');
        }
        $clone = new LongDigit($this->sign, $this->exponent, $this->digits);
        $clone->sign = 1;
        $unit = new LongDigit(1, 1, [1]);

        $result = new LongDigit();
        $result->sign = $this->sign;
        $result->exponent = 1;
        $result->digits = [];

        while ($clone->less($unit)) {
            $clone->exponent++;
            $result->exponent++;
        }
        while ($unit->less($clone)) {
            $unit->exponent++;
        }
        $result->exponent -= $unit->exponent - 1;
        $count = 0;
        $totalCount = max(0, $result->exponent);
        $maxCount = self::DIV_DIGIT + $totalCount;

        do {
            $digit = 0;
            while ($unit->more($clone) || $unit->equal($clone)) {
                $digit++;
                $unit = (new SubAction())->execute($unit, $clone);
            }
            $unit->exponent++;
            $unit->removeZeroes();
            array_push($result->digits, $digit);
            $count++;
        } while (!$unit->zeroCheck() && $count < $maxCount);
        return $result;
    }
}
