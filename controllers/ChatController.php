<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Chat;
use app\models\Cliente;
use app\models\MensajesTicket;
use app\models\Operador;
use app\models\ReporteOperadores;
use app\models\Tickets;

class ChatController extends Controller
{
    public $layout = 'codetrail/main';

    public function actionMostrarChat($id,$rol,$idUser)
    {
        $ticket = '';
        if($id){
            $ticket = Tickets::findOne($id);
            $mensajes = MensajesTicket::find(['id_ticket' => $id])->all();
            foreach ($mensajes as $m) {
                if ($m->id_remitente !== Yii::$app->user->identity->id) {
                    $m->leido = '1';
                    $m->save();
                }
            }
        }

        $reporte = new ReporteOperadores();
        $tickets = $this->obtenerTickets($idUser,$rol);
        return $this->render('chat', ['ticket' => $ticket,'tickets' => $tickets,'reporteForm' => $reporte]);
    }

   public function obtenerTickets($id,$rol){
        if($rol === 'cliente'){
            $cliente = Cliente::findOne(['usuario_id' => $id]);
            $tickets = Tickets::find()->where(['id_cliente' => $cliente->id])->orderBy(['id' => SORT_DESC])->all();
        }else{
            $operador = Operador::findOne(['usuario_id' => $id]);
            $tickets = Tickets::find()->where(['id_operador' => $operador->id])->orderBy(['id' => SORT_DESC])->all();
        }
        return $tickets;
   }
    public function actionGuardar()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; // Forzar respuesta JSON

        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();

            // Validamos que existan los datos requeridos
            if (!isset($postData['ticket'], $postData['remitente'], $postData['tipo_remitente'], $postData['mensaje'])) {
                return ['status' => 'error', 'message' => 'Faltan datos obligatorios'];
            }

            $model = new MensajesTicket();
            $model->id_ticket = $postData['ticket'];
            $model->id_remitente = $postData['remitente'];
            $model->tipo_remitente = ucfirst($postData['tipo_remitente']);
            $model->mensaje = $postData['mensaje'];

            if ($model->save()) {
                return ['success' => true, 'message' => 'Mensaje guardado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al guardar mensaje', 'errors' => $model->getErrors()];
            }
        }

        return ['status' => 'error', 'message' => 'Petición inválida'];
    }

    public function actionActualizarMensajes($id)
    {
        $mensajes = MensajesTicket::find()->where(['id_ticket' => $id])->all();
        return $this->renderPartial('_mensajes', ['mensajes' => $mensajes, 'rol' => Yii::$app->user->identity->role]);
    }
}
