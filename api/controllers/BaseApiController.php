<?php

namespace app\controllers;

use app\modules\v1\models\digit\StringLongDigit;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\web\Controller;
use yii\rest\OptionsAction;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class BaseApiController extends Controller
{
    protected $collectionOptions = ['GET', 'POST', 'OPTIONS'];
    protected $resourceOptions = ['GET', 'POST', 'OPTIONS'];

    const DIGIT_PATTERN = '/^-?[0-9]*[.]?[0-9]+$/';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),

                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ],
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    'Access-Control-Allow-Origin' => [
                        '*'
                    ],
                    'Origin' => [
                        '*'
                    ],
                    'Access-Control-Request-Method' => [
                        'GET',
                        'OPTIONS',
                    ],
                    'Access-Control-Request-Headers' => [
                        'Origin',
                        'X-Requested-With',
                        'Content-Type',
                    ],
                    'Access-Control-Allow-Headers' => [
                        'Content-Type',
                    ],
                ],
            ],
        ]);
    }

    public function prepareParams(array $inputParams, string $result): array
    {
        return [
            'status' => 'success',
            'data' => [
                'input' => $inputParams,
                'result' => $result,
            ]
        ];
    }

    public function parseParamsFromQuery(): array
    {
        $requestParams = Yii::$app->request->getQueryParams();
        $params = [];
        foreach ($requestParams as $key => $param) {
            preg_match(self::DIGIT_PATTERN, $param, $matches);
            if (empty($matches)) {
                throw new UnprocessableEntityHttpException("${key} - parameter has invalid characters, only [0-9.-]");
            }
            array_push($params, new StringLongDigit($param));
        }
        if (!isset($param)) {
            throw new UnprocessableEntityHttpException('Empty params');
        }
        return [$params, $requestParams];
    }
}
