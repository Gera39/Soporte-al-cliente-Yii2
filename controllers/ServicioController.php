<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\Services;
use app\models\Paquete;
use app\models\ServicioForm; // Ensure that this class exists in the specified namespace
use app\models\PaqueteForm; // Ensure that this class exists in the specified namespace
use app\models\PaqueteServicios;
use yii\web\NotFoundHttpException;

class ServicioController extends BaseController
{

    public $layout = 'codetrail/main';

    public function actionIndex()
    {
        $paqueteForm = new PaqueteForm();
        $paquetes = Paquete::find()->all();
        $servicios = Services::find()->all();
        return $this->render('index_paquetes', [
            'paquetes' => $paquetes,
            'paqueteForm' => $paqueteForm,
            'servicios' => $servicios,
        ]);
    }
    public function actionServicios()
    {
        $servicioForm = new ServicioForm();
        $servicios = Services::find()->all();
        return $this->render('index_servicios', [
            'servicios' => $servicios,
            'servicioForm' => $servicioForm,
        ]);
    }

    public function actionGuardar()
    {
        $servicioForm = new ServicioForm();
        if ($servicioForm->load(Yii::$app->request->post()) && $servicioForm->validate()) {
            $servicio = new Services();
            $servicio->nombre_service = $servicioForm->nombre_service;
            $servicio->save();
            return $this->redirect(['servicio/servicios']);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findService($id);
        $servicioForm = new ServicioForm();

        if ($servicioForm->load(Yii::$app->request->post(), 'Services') && $model->load(Yii::$app->request->post())) {

            if ($servicioForm->validate()) {
                try {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Servicio actualizado correctamente');
                    } else {
                        Yii::$app->session->setFlash('error', 'No se pudo actualizar el servicio.');
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', 'Error en la base de datos: ' . $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', 'Datos del formulario no válidos.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'No se pudieron cargar los datos del formulario.');
        }
        return $this->redirect(['servicios']);
    }


    public function actionDelete($id){
        $model = $this->findService($id);
        if($model->delete()){
            PaqueteServicios::deleteAll(['servicio_id' => $id]);
            Yii::$app->session->setFlash('success', 'Servicio eliminado correctamente.');
            return $this->redirect(['servicio/servicios']);
        }
        Yii::$app->session->setFlash('success', 'Error no se ha eliminado correctamente.');
        return $this->redirect(['servicio/index']);
    }


    public function actionView($id)
    {
        $model = $this->findService($id);
        return $this->redirect(['view', [
            'model' => $model,
        ]]);
    }


    public function findService($id)
    {
        if (($model = Services::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException("Servicio no existe");
    }

   

    
}
