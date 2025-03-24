<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Tickets;
use yii\web\Response;

class NotificacionController extends Controller
{
    public function actionNuevosTickets()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findOne(Yii::$app->user->id);
        $operador = $user->operadores;
        
        // 1. Usar campo dedicado para última revisión
        $ultimaRevision = $user->last_login; 
        
        // 2. Usar condición > en lugar de >=
        $nuevosTickets = Tickets::find()
            ->where(['id_operador' => $operador->id])
            ->andWhere(['estado_ticket' => 'Pendiente'])
            ->andWhere(['>', 'fecha_ticket', $ultimaRevision])
            ->count();
        
        // 3. Actualizar solo si hay nuevos tickets
        if($nuevosTickets > 0) {
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
        }
        
        return ['nuevos_tickets' => $nuevosTickets];
    }
}

?>