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
        $result = '';
        if ($this->digit->sign === -1) {
            $result .= '-';
        }
        if ($this->digit->exponent > 0) {
            $count = 0;
            $exponent = $this->digit->exponent;
            while ($count < count($this->digit->digits) && $count < $exponent) {
                $result .= $this->digit->digits[$count++];
            }
            while ($count < $exponent) {
                $result .= '0';
                $count++;
            }
            if ($count < count($this->digit->digits)) {
                $result .= '.';
                while ($count < count($this->digit->digits)) {
                    $result .= $this->digit->digits[$count++];
                }
            }
        } else {
            $result .= '0.';
            for ($count = 0; $count < -$this->digit->exponent; $count++) {
                $result .= '0';
            }
            for ($count = 0; $count < count($this->digit->digits); $count++) {
                $result .= $this->digit->digits[$count];
            }
        }

        return $result;
    }
}
