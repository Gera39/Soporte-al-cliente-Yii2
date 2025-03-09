<?php

namespace app\controllers;

use app\models\EmpleadoForm;
use app\models\ReporteOperadores;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Operador;
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelOperador = $this->findModelOperador($id);
        $model->grado = explode(' ', $modelOperador->departamento)[0]; // Asignar el valor temporal

        if ($this->request->isPost) {
            $modelM = $this->request->post()['User']['grado'];

            $model->load($this->request->post());
            $modelOperador->load($this->request->post());
            $modelOperador->departamento = $modelM . " " . $this->request->post()['Operador']['departamento'];

            if ($model->validate() && $modelOperador->validate()) {
                $model->save();
                $modelOperador->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelOperador' => $modelOperador,
        ]);
    }

    protected function findModelOperador($id)
    {
        if (($model = Operador::findOne(['usuario_id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('El operador no existe.');
    }

    public function actionView($id)
    {

        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function findModelTicket($id)
    {
        if (($model = ReporteOperadores::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
