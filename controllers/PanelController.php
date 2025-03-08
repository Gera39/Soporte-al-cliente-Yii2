<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\EmpleadoForm;


class PanelController extends Controller
{
    public $layout = 'codetrail/main';

    public function actionDashboardAdmin(){
        return $this->render('dashboardAdmin');
    }

    public function actionDashboardCliente(){
        return $this->render('dashboardCliente');
    }

    public function actionDashboardOperador(){
        return $this->render('dashboardOperador');
    }

    public function actionEmpleados(){
        $model = new EmpleadoForm();
        $sql = "CALL obtener_empleados();";
        $empleados = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('empleados',['empleados'=>$empleados, 'model' => $model]); 
    }  
    
    public function actionServicios(){
        return $this->render('servicios'); 
    } 

    public function actionReportes(){
        return $this->render('reporte'); 
    }  

    public function actionServiciosCliente(){
        return $this->render('serviciosCliente'); 
    }
    public function actionGraficas(){
        return $this->render('graficas'); 
    }
    public function actionPerfil(){
        return $this->render('perfil'); 
    }
    public function actionTicketsEmpleado(){
        return $this->render('ticketEmpleado'); 
    }
    public function actionTicketsCliente(){
        return $this->render('ticketCliente'); 
    }
    
    public function actionChat(){
        return $this->render('chat'); 
    }
   
   
  
}
