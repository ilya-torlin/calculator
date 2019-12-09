<?php

namespace app\modules\v1\models\action;

use app\modules\v1\models\digit\LongDigit;

class CompareAction implements Action
{
    public function execute(LongDigit $first, LongDigit $second): LongDigit
    {
        // заглушка для метода
        return new LongDigit();
    }

    public function firstMore(LongDigit $first, LongDigit $second): bool
    {
        if ($first->sign !== $second->sign) {
            return $first->sign > $second->sign;
        }
        if ($first->exponent != $second->exponent) {
            return ($first->exponent > $second->exponent) ^ ($first->sign == -1);
        }

        $currentFirst = $first->digits;
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
                return ($currentFirst[$count] > $currentSecond[$count]) ^ ($first->sign == -1);
            }
        }
        return false;
    }
}
