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

class LoginController extends Controller{

    public function actionIndex(){
        
        $model = new LoginForm();
        $this->layout = 'login/login';
        return $this->render('index',[
            'model' => $model,
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
            $this->layout = 'login/login';
            return $this->redirect(['login/entrar' , 'id' => $id]);
        }else{
            return $this->redirect(['site/index', 'mensaje' =>'error']);
         
        }
    }

    public function actionEntrar(){
        $this->layout = 'login/login';
        return $this->render('entrar');
    }
}
?>