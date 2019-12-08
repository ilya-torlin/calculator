<?php

namespace app\modules\v1\models\calculator;

use app\modules\v1\models\action\DivAction;
use app\modules\v1\models\action\MultAction;
use app\modules\v1\models\action\SubAction;
use app\modules\v1\models\action\SumAction;
use app\modules\v1\models\digit\LongDigit;
use yii\web\BadRequestHttpException;

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
        return (new SumAction())->execute($this->terms[0], $this->terms[1]);
    }

    public function sub(): LongDigit
    {
        return (new SubAction())->execute($this->terms[0], $this->terms[1]);
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
