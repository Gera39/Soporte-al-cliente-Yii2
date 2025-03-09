<?php
namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\Services;
use app\models\ServicioForm; // Ensure that this class exists in the specified namespace
use yii\web\NotFoundHttpException;

class ServicioController extends Controller{

    public $layout = 'codetrail/main';

    public function actionIndex(){
        $servicioForm = new ServicioForm();
        $servicios = Services::find()->all();
        return $this->render('index',[
            'servicios' => $servicios,
            'servicioForm' => $servicioForm,
        ]);
    }

    public function actionGuardar(){
        $servicioForm = new ServicioForm();
        if($servicioForm->load(Yii::$app->request->post()) && $servicioForm->validate()){
            $servicio = new Services();
            $servicio->nombre_service = $servicioForm->nombre_service;
            $servicio->save();
            return $this->redirect(['servicio/index']);
        }
    }

    public function actionUpdate($id){
        
        $model = $this->findService($id);
        $servicioForm = new ServicioForm();
        $servicioForm->nombre_service = $model->nombre_service;
        if($servicioForm->load(Yii::$app->request->post()) && $servicioForm->validate()){
           if($model->save()){
            Yii::$app->session->setFlash('succes','Servicio actualizado correctamente');
            return $this->redirect(['index']);
           }else{
            Yii::$app->session->setFlash('error', 'Error al actualizar el servicio.');
           }
          
        }
        return $this->redirect(['index']);
        
    }

    public function findService($id){
        if(($model = Services::findOne(['id' => $id])) !== null){
            return $model;
        }
        throw new NotFoundHttpException("Servicio no existe");
    }


}
?>