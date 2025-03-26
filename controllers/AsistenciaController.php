<?php 
namespace app\controllers;

use app\models\RegistroAsistencia;
use Yii;
class AsistenciaController extends BaseController{
    
    public $layout = 'codetrail/main'; 
    public function actionRegistroAsistencia(){
        $resultado = Yii::$app->db->createCommand('CALL registro_asistencia(:id)',[
            ':id' => Yii::$app->user->identity->operadores->id,
        ])->queryAll();
        if($resultado[0]['resultado'] === 1){
           Yii::$app->session->setFlash('mensaje','Buena asistencia');
        }else{
            Yii::$app->session->setFlash('mensaje-tarde','Llegas tarde te invitamos que nos cuentes el motivo');
        }
        Yii::$app->session->setFlash('id_asistencia', $resultado[0]['id_asistencia']);
        return $this->redirect(['panel/dashboard-operador']);
    }

    public function actionRegistrarSalida(){
        $id = Yii::$app->session->getFlash('id_asistencia');
        $resultado = Yii::$app->db->createCommand('CALL registro_salida(:id,:id_asistencia)',[
            ':id' => Yii::$app->user->identity->operadores->id,
            ':id_asistencia' => Yii::$app->session->getFlash('id_asistencia'),
        ])->queryAll();
        if($resultado[0]['resultado'] === 1){
            Yii::$app->session->setFlash('retirada','Te vas pronto ya quedo registrado');
         }else{
             Yii::$app->session->setFlash('retirada-cumplida','Gracias por cumplir con tu horario, Adios!');
         }
         Yii::$app->session->removeFlash('id_asistencia');
         return $this->redirect(['login/logout']);
    }


    public function actionMotivoAsistencia($id){
        $asistencia = RegistroAsistencia::findOne($id);
        if($asistencia->load(Yii::$app->request->post()) && $asistencia->save()){
            Yii::$app->session->setFlash('mensaje-salida','Ya se envio el motivo');
        }
        Yii::$app->session->setFlash('id_asistencia',$id);
        Yii::$app->session->setFlash('error','Error hubo');
            return $this->redirect(['panel/dashboard-operador','id' => $id]);
    }

    public function actionIndex(){
        $asistencias = RegistroAsistencia::find()->all();
        return $this->render('index', ['asistencias' => $asistencias]);
    }

    public function actionFiltrar($estado){
        $asistencias = RegistroAsistencia::find()->where(['estatus_trabajo' => $estado])->all();
        return $this->renderPartial('_tabla_asistencia', ['asistencias' => $asistencias]);
    }
}

?>