<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;

use app\models\EmpleadoForm;
use app\models\Logs;
use app\models\ReporteOperadores;
use app\models\Tickets;



class PanelController extends Controller
{
    public $layout = 'codetrail/main';

    public function actionDashboardAdmin()
    {
        $logs = Logs::find()->orderBy(['id' => SORT_DESC])->limit(5)->all();
        return $this->render('dashboardAdmin', ['logs' => $logs]);
    }

    public function actionDashboardCliente()
    {
        return $this->render('dashboardCliente');
    }

    public function actionDashboardOperador()
    {
        return $this->render('dashboardOperador');
    }

    public function actionEmpleados()
    {
        $model = new EmpleadoForm();
        $sql = "CALL obtener_empleados();";
        $empleados = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('empleados', ['empleados' => $empleados, 'model' => $model]);
    }

    public function actionServicios()
    {
        return $this->redirect(['servicio/index']);
    }

    public function actionReportes()
    {
        $reportes = ReporteOperadores::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('reporte' , ['reportes' => $reportes]);
    }

    public function actionServiciosCliente()
    {
        return $this->render('serviciosCliente');
    }
  
    public function actionPerfil()
    {
        return $this->render('perfil');
    }
    public function actionTicketsEmpleado()
    {
        $tickets = Tickets::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('ticketEmpleado', ['tickets' => $tickets]);
    }
    public function actionTicketsCliente()
    {
        return $this->render('ticketCliente');
    }

    public function actionClientes(){
        return $this->redirect(['cliente/index']);
    }

    public function actionDeleteReporte($id)
    {
        $reporte = ReporteOperadores::findOne($id);
        if ($reporte) {
            $reporte->delete();
        }
        return $this->redirect(['panel/reportes']);
    }
}
