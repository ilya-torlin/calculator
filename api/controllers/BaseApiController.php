<?php

namespace app\controllers;

use app\modules\v1\models\digit\StringLongDigit;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class BaseApiController extends Controller
{
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

    /**
     * @OA\Schema(
     *      schema="CalculationResult",
     *      @OA\Property(property="status", type="string", example="success"),
     *      @OA\Property(property="data", type="object",
     *         @OA\Property(property="input", type="object",
     *              @OA\Property(property="first", type="string", example="1 | 0 | -.1234 | -123456789.123456789"),
     *              @OA\Property(property="second", type="string", example="1 | 0 | -.1234 | -123456789.123456789"),
     *         ),
     *         @OA\Property(property="result", type="string", example="1 | 0 | -.1234 | -123456789.123456789"),
     *      )
     * )
     */
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

    /**
     * @OA\Schema(
     *      schema="UnprocessableEntity",
     *      @OA\Property(property="name", type="string", example="Unprocessable entity"),
     *      @OA\Property(property="message", type="string", example="parameter has invalid characters, only [0-9.-]"),
     *      @OA\Property(property="code", type="integer", example="0"),
     *      @OA\Property(property="status", type="integer", example="422"),
     *      @OA\Property(property="type", type="string", example="yii\web\UnprocessableEntityHttpException")
     * )
     */
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
