<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Tickets;
use app\models\Operador;

class TicketController extends Controller {


    public function actionFiltrar($estado, $idOperador)
    {
    $tickets = Tickets::find()->where(['estado_ticket' => $estado, 'id_operador' => $idOperador])->all();
    return $this->renderPartial('_tickets', ['tickets' => $tickets]);
    }
}
