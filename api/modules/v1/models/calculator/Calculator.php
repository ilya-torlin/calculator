<?php

namespace app\modules\v1\models\calculator;

use app\modules\v1\models\action\DivAction;
use app\modules\v1\models\action\MultAction;
use app\modules\v1\models\action\SubAction;
use app\modules\v1\models\action\SumAction;
use app\modules\v1\models\digit\LongDigit;

class Calculator
{
    /*
     * List of terms for actions
     */
    private $terms;

    public function __construct(array $params)
    {
        $this->terms = $params;
    }

    public function add(): LongDigit
    {
        if ($this->terms[0]->sign === $this->terms[1]->sign) {
            return (new SumAction())->execute($this->terms[0], $this->terms[1]);
        }
        if ($this->terms[0]->sign === -1) {
            return (new SubAction())->execute($this->terms[1], $this->terms[0]->inverseSign());
        }
        return (new SubAction())->execute($this->terms[0], $this->terms[1]->inverseSign());
    }

    public function sub(): LongDigit
    {
        if ($this->terms[0]->sign === 1 && $this->terms[1]->sign === 1) {
            return (new SubAction())->execute($this->terms[0], $this->terms[1]);
        }
        if ($this->terms[0]->sign === -1 && $this->terms[1]->sign == -1) {
            return (new SubAction())->execute($this->terms[1]->inverseSign(), $this->terms[0]->inverseSign());
        }
        return (new SumAction())->execute($this->terms[0], $this->terms[1]->inverseSign());
    }

    public function mult(): LongDigit
    {
        return (new MultAction())->execute($this->terms[0], $this->terms[1]);
    }

    public function div(): LongDigit
    {
        return (new DivAction())->execute($this->terms[0], $this->terms[1]);
    }
}
