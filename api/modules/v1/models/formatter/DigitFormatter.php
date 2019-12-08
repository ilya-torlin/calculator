<?php

namespace app\modules\v1\models\formatter;

use app\modules\v1\models\digit\LongDigit;

class DigitFormatter
{
    private $digit;
    public function __construct(LongDigit $digit)
    {
        $this->digit = $digit;
    }

    public function result(): string
    {
        // логика перевода LongDigit в string
        return '';
    }
}
