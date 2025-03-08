<?php

namespace app\controllers;
use Yii;
use app\models\Cliente;
use app\models\User;
use yii\web\Controller;
use app\models\Tickets;
use app\models\Operador;
use yii\web\NotFoundHttpException;

class ClienteController extends Controller {

    public $layout = 'codetrail/main';

    public function actionView($id)
    {
        $model = $this->findModel($id);
        // var_dump($model);
        // return;
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id){
        $model = $this->findCliente($id);
        return $this->render('update' , ['model' => $model]);
    }

    protected function findCliente($id){
        if(($model = Cliente::findOne(['id' => $id])) !== null){
            return $model;
        }
        throw new NotFoundHttpException('no quiso salir');
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFiltrar($estado, $idOperador)
    {
   
    $tickets = Tickets::find()->where(['estado_ticket' => $estado, 'id_cliente' => $idOperador])->all();
    return $this->renderPartial('/cliente/_tickets', ['tickets' => $tickets]);
    }

    public function actionUpdateEstatus($id = null)
    {
        $model = $this->findModel($id);
        if (!$model) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['status' => 'error', 'message' => 'Empleado no encontrado'];
        }
        if ($this->request->isPost) {
            // Si la solicitud es AJAX, responde con JSON
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
                $nuevoEstado = Yii::$app->request->post('estado');
                $model->estado = $nuevoEstado;
                if ($id = Yii::$app->request->post('id')) {
                    $model->id = $id;
                }
                if ($model->save()) {
                    return ['status' => 'success', 'message' => 'Estado actualizado correctamente'];
                } else {
                    return ['status' => 'error', 'message' => 'No se pudo actualizar el estado'];
                }
            }
            // Si la solicitud es normal (formulario), procesar y redirigir
            if ($model->load($this->request->post()) && $model->save()) {
        return $this->redirect('panel/empleados');
                
            }
        }
    
        return $this->redirect('panel/empleados');
    }
}
