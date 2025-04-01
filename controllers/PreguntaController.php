<?php

namespace app\controllers;

use Yii;
use app\models\User;

class PreguntaController extends BaseController
{
    public function actionPreguntas($id)
    {
        $model = new \app\models\PreguntaForm();
        return $this->render('preguntas', ['model' => $model, 'id' => $id]);
    }

    public function actionCrearPreguntas()
    {
        if (Yii::$app->request->post()) {
            $pregunta = Yii::$app->request->post('PreguntaForm')['pregunta1'];
            $pregunta .= ',';
            $pregunta .= Yii::$app->request->post('PreguntaForm')['pregunta2'];
            $pregunta .= ',';
            $pregunta .= Yii::$app->request->post('PreguntaForm')['pregunta3'];

            $respuesta = Yii::$app->request->post('PreguntaForm')['respuesta1'];
            $respuesta .= ',';
            $respuesta .= Yii::$app->request->post('PreguntaForm')['respuesta2'];
            $respuesta .= ',';
            $respuesta .= Yii::$app->request->post('PreguntaForm')['respuesta3'];
            $id = Yii::$app->session->get('id_usuario');
            $model = User::findOne($id);
            $model->pregunta = $pregunta;
            $model->respuesta = $respuesta;
            if ($model->save()) {
                return $this->redirect(['panel/dashboard']);
            }
        }
    }

    public function actionRecoverPassword($id = null)
    {
        $this->layout = 'main';
        $model = User::findOne($id);
        if (Yii::$app->request->isPost) {
            $model = User::findOne(Yii::$app->session->get('id'));
            $respuestaEnviada = Yii::$app->request->post('PreguntaForm')['respuesta1'];
            $respuestaEnviada .= ',';
            $respuestaEnviada .= Yii::$app->request->post('PreguntaForm')['respuesta2'];
            $respuestaEnviada .= ',';
            $respuestaEnviada .= Yii::$app->request->post('PreguntaForm')['respuesta3'];
            if ((Yii::$app->request->post('PreguntaForm')) && strtoupper($model->respuesta) === strtoupper($respuestaEnviada)) {
                $sql = "CALL resetear_pass(:id)";
                $command = Yii::$app->db->createCommand($sql);
                $command->bindValue(':id', $model->id);
                $command->execute();
                Yii::$app->session->setFlash('success', 'Respuestas correctas, su codigo contraseña nueva es: 12345678');
                return $this->redirect(['panel/reset-password']);
            } else {
                $model->updated_at= new \yii\db\Expression('NOW()');
                $model->save();
                Yii::$app->session->setFlash('error', 'Intentelo mas tarde, las respuestas no coinciden');
                Yii::$app->session->remove('id');
                return $this->redirect(['panel/reset-password']);
            }
        }
        $recover = new \app\models\RecoverForm();
        return $this->render('recover', ['id' => $model->id, 'pregunta' => $model->pregunta, 'model' => $recover]);
    }
}
