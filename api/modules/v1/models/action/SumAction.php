<?php

namespace app\modules\v1\models\action;

use app\modules\v1\models\digit\LongDigit;

class SumAction implements Action
{
    public function execute(LongDigit $first, LongDigit $second): LongDigit
    {
        // TODO: Implement execute() method. Выполняем сложение длинных чисел
    }
}
