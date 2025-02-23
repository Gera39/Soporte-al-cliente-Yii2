<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\db\Command;
use app\models\RegisterForm;
class LoginController extends Controller{

    public function actionIndex(){
        
        $model = new LoginForm();
        $modelCreate = new RegisterForm();
        $this->layout = 'login/login';
        return $this->render('index',[
            'model' => $model,
            'modelCreate' => $modelCreate,
        ]);
    }   

    public function actionLoginCustom(){
        $datos = Yii::$app->request->post('LoginForm',[]);
        $sql = "CALL inicio_sesion (:username,:pass )";
        $result = Yii::$app->db->createCommand($sql, [
            ':username' => $datos['username'] ?? '',
            ':pass' => $datos['password'] ?? '',  
        ])->queryAll();
        if(!empty($result) && $result[0]["resultado"] == 1){
            $id = $result[0]['id'];
            // $user = Users::findOne($id);
            // if ($user) {
            //     Yii::$app->user->login($user);
            // }
            return $this->redirect(['login/entrar' , 'id' => $id]);
        }else{
            return $this->redirect(['index', 'mensaje' =>'error']);
         
        }
    }

    public function actionEntrar(){
        return $this->redirect(['panel/dashboard-admin']);
    }
}
?>