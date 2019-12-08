<?php

namespace app\modules\v1\models\action;

use app\modules\v1\models\digit\LongDigit;

class MultAction implements Action
{
    public function execute(LongDigit $first, LongDigit $second): LongDigit
    {
        $length = count($first->digits) + count($second->digits);
        $result = new LongDigit();

        $result->sign = $first->sign * $second->sign;
        $result->digits = array_fill(0, $length, 0);
        $result->exponent = $first->exponent + $second->exponent;
        for ($count = 0; $count < count($first->digits); $count++) {
            for ($secondCount = 0; $secondCount < count($second->digits); $secondCount++) {
                $result->digits[$count + $secondCount + 1] += $first->digits[$count] * $second->digits[$secondCount];
            }
        }
        for ($count = $length - 1; $count > 0; $count--) {
            $result->digits[$count - 1] += intdiv($result->digits[$count], 10);
            $result->digits[$count] %= 10;
        }
        $result->removeZeros();

        return $result;
    }
}
