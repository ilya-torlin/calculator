<?php

namespace app\modules\v1\models\action;

use app\modules\v1\models\digit\LongDigit;

interface Action
{
    public function execute(LongDigit $first, LongDigit $second): LongDigit;
}
