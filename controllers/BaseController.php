<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class BaseController extends Controller{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['notfound'], // Excluye esta acción
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                   
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->session->setFlash('error', 'Debes de iniciar sesión, regresa al login');
                        Yii::$app->response->redirect(['panel/notfound'])->send();
                        Yii::$app->end();
                    } else {
                        Yii::$app->session->setFlash('error', 'Acceso denegado.');
                        return $this->redirect(['panel/notfound']);
                    }
                }
            ],
        ];
    }
    
    
}
?>