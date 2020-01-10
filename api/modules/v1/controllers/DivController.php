<?php

namespace app\modules\v1\controllers;

use app\controllers\BaseApiController;
use app\modules\v1\models\calculator\Calculator;
use app\modules\v1\models\formatter\DigitFormatter;
use yii\filters\VerbFilter;

class DivController extends BaseApiController
{
    public function actionIndex()
    {
        $params = $this->parseParamsFromQuery();
        $calculator = new Calculator($params);
        $formatter = new DigitFormatter($calculator->div());
        return $this->prepareParams($params, $formatter->result());
    }
}
