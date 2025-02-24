<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class PanelController extends Controller
{
    
   public function actionDashboardAdmin(){
        
        $this->layout = 'codetrail/main';
        return $this->render('dashboardAdmin');
    }

    public function actionDashboardCliente(){
        
        $this->layout = 'codetrail/main';
        return $this->render('dashboardUser');
    }

    public function actionDashboardOperador(){
        
        $this->layout = 'codetrail/main';
        return $this->render('dashboardEmployee');
    }

    public function actionEmpleados(){
       // Si es PJAX, renderiza sin layout
     
        return $this->render('emp'); // Usar renderPartial para omitir el layout
    }   
   
   
  
}
