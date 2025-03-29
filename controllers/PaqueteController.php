<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\PaqueteForm;
use app\models\Paquete;
use app\models\PaqueteServicios;
use app\models\SolicitudesCancelacion;
use yii\web\NotFoundHttpException;

class PaqueteController extends Controller
{
    public $layout = 'codetrail/main';
    public function actionGuardarPaquete()
    {   
        $paqueteForm = new PaqueteForm();
        if ($paqueteForm->load(Yii::$app->request->post()) && $paqueteForm->validate()) {
            $paquete = new Paquete();
            $paquete->nombre_paquete = $paqueteForm->nombre_paquete;
            $paquete->descripcion = $paqueteForm->descripcion;
            $paquete->precio = $paqueteForm->precio;
            $paquete->save();
            if ($paquete->save()) {
                foreach ($paqueteForm->servicios as $id) {
                    $paqueteServicio = new PaqueteServicios();
                    $paqueteServicio->paquete_id = $paquete->id;
                    $paqueteServicio->servicio_id = $id;
                    $paqueteServicio->save();
                }
                Yii::$app->session->setFlash('success', 'Paquete creado correctamente.');
                return $this->redirect(['servicio/index', 'id' => $id]);
            }
            return $this->redirect(['servicio/index']);
        }
    }

    public function actionUpdatePaquete($id){
        $model = $this->findPaquete($id);
        $paqueteForm = new PaqueteForm();
        if ($paqueteForm->load(Yii::$app->request->post()) && $paqueteForm->validate()) {
            $model->nombre_paquete = $paqueteForm->nombre_paquete;
            $model->descripcion = $paqueteForm->descripcion;
            $model->precio = $paqueteForm->precio;
            if ($model->save()) {
                PaqueteServicios::deleteAll(['paquete_id' => $model->id]);
                foreach ($paqueteForm->servicios as $id) {
                    $paqueteServicio = new PaqueteServicios();
                    $paqueteServicio->paquete_id = $model->id;
                    $paqueteServicio->servicio_id = $id;
                    $paqueteServicio->save();
                }
                Yii::$app->session->setFlash('success', 'Paquete actualizado correctamente.');
                return $this->redirect(['servicio/index']);
            }
            Yii::$app->session->setFlash('error','Error el paquete no se pudo actualizar.');    
            return $this->redirect(['servicio/index']);
        }   
    }

    public function actionCancelarPaquete()
    {
       if(Yii::$app->request->isGet){

        $solicitud = Yii::$app->request->get();
        $model = new SolicitudesCancelacion();
        $model->id_usuario  = $solicitud['idUser'];
        $model->id_paquete = $solicitud['id'];
        $model->razon_cancelacion =$solicitud['descripcion'] ?? 'Sin razón especifica';
        $model->fecha_solicitud = new \yii\db\Expression('NOW()');
        if($model->save()){
            return $this->redirect(['cliente/servicios-cliente']);
        }
        return 'no entro al save';
       }
    }

    public function actionUpdateEstatus($id = null){
        $model = $this->findPaquete($id);
        if (!$model) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['status' => 'error', 'message' => 'Paquete no encontrado'];
        }
        if ($this->request->isPost) {
            // Si la solicitud es AJAX, responde con JSON
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $nuevoEstado = Yii::$app->request->post('estado');
                $model->estado = ($nuevoEstado == 1) ? 'activo' : 'inactivo';   
                if ($model->save()) {
                    return ['status' => 'success', 'message' => 'Estado actualizado correctamente'];
                } else {
                    return ['status' => 'error', 'message' => 'No se pudo actualizar el estado'];
                }
            }
        }
    
        return $this->redirect('servicio/index');
    }

    public function actionFiltrar($estado)
    {
        $paquetes = Paquete::find()->where(['estado' => $estado])->all();
        return $this->renderPartial('/servicio/_paquetes', ['paquetes' => $paquetes]);
    }

    public function findPaquete($id)
    {
        if (($model  = Paquete::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('El paquete solicitada no existe.');
    }
}
