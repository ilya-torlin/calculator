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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     * @OA\Get(
     *     path="/sub",
     *     tags={"subtraction"},
     *     summary="Метод вычитания нескольких длинных чисел",
     *     description="Вычитаем из первого слагаемого второе",
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
        $formatter = new DigitFormatter($calculator->sub());
        return $this->prepareParams($rawParams, $formatter->result());
    }
}
