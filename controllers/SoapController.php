<?php

namespace app\controllers;

use app\models\BasicAuth;
use Yii;
use yii\web\Controller;

class SoapController extends Controller
{
    public $enableCsrfValidation = false;

    private $auth;

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        if (Yii::$app->params['needAuth']) {
            $this->auth = new BasicAuth();
            $this->auth->logIn();
        }

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'wsdl' => [
                'class' => 'subdee\soapserver\SoapAction',
            ],
        ];
    }

    /**
     * Returns hello and the name that you gave
     *
     * @param string $name Your name
     * @return string
     * @soap
     */
    public function getHello($name)
    {
        return 'Hello ' . $name;
    }

}