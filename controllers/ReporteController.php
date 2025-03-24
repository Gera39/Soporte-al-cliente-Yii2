<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ReporteOperadores;




class ReporteController extends Controller
{

    public function actionGuardar()
    {
        $reporte = new ReporteOperadores();
        if ($reporte->load(Yii::$app->request->post())) {
            $reporte->id_remitente = Yii::$app->user->identity->id;
            if ($reporte->save()) {
                return $this->redirect(['chat/mostrar-chat', 'id' => $reporte->id_ticket, 'rol' => Yii::$app->user->identity->role, 'idUser' => Yii::$app->user->identity->id]);
            }
        }
    }
}
