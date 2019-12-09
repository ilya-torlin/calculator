<?php

namespace app\modules\v1\models\action;

use app\modules\v1\models\digit\LongDigit;

class InverseAction implements Action
{
    public function execute(LongDigit $first, LongDigit $second = null): LongDigit
    {
        if (count($first->digits) == 1 && $first->digits[0] === 0) {
            return $first;
        }
        $first->sign = -$first->sign;
        return $first;
    }
}
