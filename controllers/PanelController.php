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
        return $this->render('empleados'); 
    }  
    
    public function actionServicios(){
        return $this->render('servicios'); 
    }  
   
   
  
}
