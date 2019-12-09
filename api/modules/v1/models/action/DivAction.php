<?php

namespace app\modules\v1\models\action;

use app\modules\v1\models\digit\LongDigit;

class DivAction implements Action
{
    public function execute(LongDigit $first, LongDigit $second): LongDigit
    {
        $result = (new MultAction())->execute($first,  $second->inverseLongDigit());
        $count = count($result->digits) - 1 - max(0, $first->exponent);
        $totalExponent = max(0, $result->exponent);
        if ($count > $totalExponent && $result->digits[$count] === 9) {
            while ($count > $totalExponent && $result->digits[$count] === 9) {
                $count--;
            }
            if ($result->digits[$count] === 9) {
                array_splice($result->digits, $totalExponent);
                $addition = new LongDigit($result->sign, 1, [1]);
                $result = (new SumAction())->execute($result, $addition);
            } else {
                array_splice($result->digits, $count + 1);
                $result->digits[$count]++;
            }
        }
        return $result;
    }
}
