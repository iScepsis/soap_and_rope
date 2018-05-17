<?php

namespace app\models;

use yii\web\ForbiddenHttpException;

class BasicAuth {

    private $_user;

    /**
     * @throws \yii\web\ForbiddenHttpException
     */
    public function logIn(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Unauthorized';
            exit;
        } else {
            $this->_user = User::findByUsername($_SERVER['PHP_AUTH_USER']);
            if (!$this->_user || !$this->_user->validatePassword($_SERVER['PHP_AUTH_PW'])) {
                throw new ForbiddenHttpException();
            }
        }
    }

}