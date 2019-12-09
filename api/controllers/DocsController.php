<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

define('DEV_URL', 'http://localhost:8081/v1');

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Calculator",
 *   description="Описание работы с API калькулятора длинных чисел"
 * ),
 * @OA\Server(
 *   url=DEV_URL,
 *   description="Dev server"
 * )
 */
class DocsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'index' => [
                'class' => 'genxoft\swagger\ViewAction',
                'apiJsonUrl' => Url::to(['docs/json']),
            ],
            'json' => [
                'class' => 'genxoft\swagger\JsonAction',
                'dirs' => [
                    Yii::getAlias('@app/controllers'),
                    Yii::getAlias('@app/modules/v1/controllers'),
                    Yii::getAlias('@app/modules/v1/models'),
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!YII_ENV_DEV) {
            throw new NotFoundHttpException();
        }
        return parent::beforeAction($action);
    }
}
