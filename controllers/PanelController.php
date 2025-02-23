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
   
   
  
}
