<?php

namespace app\modules\v1\models\digit;

class StringLongDigit extends LongDigit
{
    public function __construct(string $number)
    {
        list($sign, $digits, $exponent) = $this->parseStringNumber($number);
        parent::__construct($sign, $exponent, $digits);
    }

    private function parseStringNumber(string $number): array
    {
        $index = 0;
        $sign = 1;
        $digits = [];

        if ($number[0] == '-') {
            $sign = -1;
            $index = 1;
        }
        $exponent = strlen($number) - $index;
        while ($index < strlen($number)) {
            if ($number[$index] === '.') {
                $exponent = $sign === 1 ? $index : $index - 1;
            } else {
                array_push($digits, intval($number[$index]));
            }
            $index++;
        }
        return [$sign, $digits, $exponent];
    }
}
