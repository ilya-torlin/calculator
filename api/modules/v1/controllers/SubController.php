<?php

namespace app\modules\v1\controllers;

use app\controllers\BaseApiController;
use app\modules\v1\models\calculator\Calculator;
use app\modules\v1\models\formatter\DigitFormatter;
use yii\filters\VerbFilter;

class SubController extends BaseApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $params = $this->parseParamsFromQuery();
        $calculator =  new Calculator($params);
        $formatter = new DigitFormatter($calculator->sub());
        return $this->prepareParams($params, $formatter->result());
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }
}
