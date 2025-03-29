<?php

namespace app\controllers;

use app\models\SolicitudesCancelacion;
use Yii;

class SolicitudesController extends BaseController{

    public $layout = 'codetrail/main';


    public function actionIndex(){
        $search = Yii::$app->request->get('search');
        $user = Yii::$app->user->identity;
        $solicitudes = SolicitudesCancelacion::find()->orderBy(['fecha_solicitud' => SORT_DESC]);
        
        if($user->role !== 'admin'){
            $solicitudes = $solicitudes->where(['id_usuario' => $user->id]);
        }
        
        if(!empty($search)){
            $solicitudes = $solicitudes->joinWith(['paquete'])->andWhere(['like', 'packages.nombre_paquete', $search]);
        }
        $query = $solicitudes->all();

        return $this->render('index',['solicitudes' => $query, 'search' => $search]);
    }

    public function actionFiltrar($estado){
        $user = Yii::$app->user->identity;
        $solicitudes = SolicitudesCancelacion::find()->orderBy(['fecha_solicitud' => SORT_DESC])->where(['estado_solicitud' => $estado]);
        if($user->role !== 'admin'){
            $solicitudes = $solicitudes->andWhere(['id_usuario' => $user->id]);
        }
            $solicitudes = $solicitudes->all();
        return $this->renderPartial('_cancelaciones', ['solicitudes' => $solicitudes]);
    }

    public function actionDelete($id){
        $model = SolicitudesCancelacion::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success','Solicitud eliminada correctamente.');
        }else{
            Yii::$app->session->setFlash('error','Error al eliminar la solicitud.');
        }
        return $this->redirect(['index']);
    }
}


?>