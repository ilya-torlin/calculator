<?php

namespace app\modules\v1\models\action;

use app\modules\v1\models\digit\LongDigit;

class SubAction implements Action
{
    public function execute(LongDigit $first, LongDigit $second): LongDigit
    {
        if ($first->zeroCheck()) {
            return $second;
        }
        if ($second->zeroCheck()) {
            return $first;
        }
        $compare = $first->more($second);

        $firstExponent = $compare ? $first->exponent : $second->exponent;
        $secondExponent = $compare ? $second->exponent : $first->exponent;
        $maxExponent = max($firstExponent, $secondExponent);
        $currentFirst = $compare ? $first->digits : $second->digits;
        $currentSecond = $compare ? $second->digits : $first->digits;

        $currentFirst = $this->fillBeginZeroes($firstExponent, $maxExponent, $currentFirst);
        $currentSecond = $this->fillBeginZeroes($secondExponent, $maxExponent, $currentSecond);

        $length = max(count($currentFirst), count($currentSecond));
        $currentFirst = $this->fillEndZeroes($currentFirst, $length);
        $currentSecond = $this->fillEndZeroes($currentSecond, $length);

        $currentLength = 1 + $length;
        $result = new LongDigit();
        $result->sign = $compare ? 1 : -1;

        for ($count = 0; $count < $length; $count++) {
            $result->digits[$count + 1] = $currentFirst[$count] - $currentSecond[$count];
        }
        for ($count = $currentLength - 1; $count > 0; $count--) {
            if ($result->digits[$count] < 0) {
                $result->digits[$count] += 10;
                $result->digits[$count - 1]--;
            }
        }
        $result->exponent = $maxExponent + 1;
        $result->removeZeroes();
        return $result;
    }

    /**
     * @param $firstExponent
     * @param $maxExponent
     * @param $currentFirst
     * @return mixed
     */
    private function fillBeginZeroes($firstExponent, $maxExponent, $currentFirst)
    {
        while ($firstExponent !== $maxExponent) {
            array_unshift($currentFirst, 0);
            $firstExponent++;
        }
        return $currentFirst;
    }

    /**
     * @param $currentFirst
     * @param $length
     * @return mixed
     */
    private function fillEndZeroes($currentFirst, $length)
    {
        while (count($currentFirst) != $length) {
            array_push($currentFirst, 0);
        }
        return $currentFirst;
    }
}
