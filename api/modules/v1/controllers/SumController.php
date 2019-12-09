<?php

namespace app\modules\v1\controllers;

use app\controllers\BaseApiController;
use app\modules\v1\models\calculator\Calculator;
use app\modules\v1\models\formatter\DigitFormatter;
use yii\filters\VerbFilter;

class SumController extends BaseApiController
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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     * @OA\Get(
     *     path="/sum",
     *     tags={"addition"},
     *     summary="Метод сложение нескольких длинных чисел",
     *     description="Складываем 2 и 3 слагаемых",
     *     @OA\Parameter(
     *         in="query",
     *         name="first",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="1 | 0 | -.1234 | -123456789.123456789"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="second",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="1 | 0 | -.1234 | -123456789.123456789"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="third",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="1 | 0 | -.1234 | -123456789.123456789"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Результат успешно посчитан",
     *         @OA\JsonContent(ref="#/components/schemas/CalculationResult")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Неверно задан параметр",
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableEntity")
     *     ),
     * )
     */
    public function actionIndex()
    {
        list($params, $rawParams) = $this->parseParamsFromQuery();
        $calculator = new Calculator($params);
        if (count($params) > 2) {
            $result = $calculator->add();
            $calculator = new Calculator([$result, $params[2]]);
        }
        $formatter = new DigitFormatter($calculator->add());
        return $this->prepareParams($rawParams, $formatter->result());
    }
}
