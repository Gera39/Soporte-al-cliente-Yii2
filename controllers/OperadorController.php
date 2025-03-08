<?php

namespace app\controllers;

use app\models\EmpleadoForm;
use app\models\ReporteOperadores;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Tickets;
use yii\web\NotFoundHttpException;

class OperadorController extends Controller
{

    public $layout = 'codetrail/main';

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
                return $this->redirect(['panel/empleados']);
            }
        }
    
        return $this->redirect('panel/empleados');
    }
    
    public function actionGuardarOperador()
    {
        $request = Yii::$app->request;
        $model = new EmpleadoForm();
        $model->load($request->post());
        if ($model->validate()) {

            $departamento = $model->departamento . ' ' . $model->carrera;
            $sql = "CALL crear_empleado(:nombre,:username,:email,:password,:departamento)";
            $result = Yii::$app->db->createCommand($sql, [
                ':nombre' => $model->nombre ?? '',
                ':username' => $model->nombre . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4) ?? '',
                ':email' => $model->email ?? '',
                ':password' => $model->password ?? '',
                ':departamento' => $departamento ?? '',
            ])->queryAll();
            Yii::$app->session->setFlash('success', 'El registro se ha guardado con exito');
            return $this->redirect(['panel/empleados']);
        } else {
            Yii::$app->session->setFlash('error',  $model->email);
            return $this->redirect(['panel/empleados']);
        }
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
    
    $tickets = Tickets::find()->where(['estado_ticket' => $estado, 'id_operador' => $idOperador])->all();
    return $this->renderPartial('/tables/_tickets', ['tickets' => $tickets]);
    }



    
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    // public function actionUpdateEstatusReporte($id){
    
    //     $model= $this->findModelTicket($id);
    //     if ($model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['operador/view', 'id' => $model->getOperador()->one()->getUsuario()->one()->id]);
    //         // return $this->redirect(['panel/empleados']);
    //     }
    // }
    // public function actionUpdateEstatusReporte($id,$estado)
    // {
    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    //     $model = $this->findModelTicket($id);
    //     $model->estado_reporte = $estado;
    //     if ($model->save()) {
    //         return ['success' => true];
    //     }
    //     return ['success' => false];
    // }
    
    protected function findModelTicket($id)
    {
        if (($model = ReporteOperadores::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
