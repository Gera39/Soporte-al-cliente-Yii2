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
// use app\controllers\User;
use app\models\User;
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
        $sql = "CALL inicio_sesion(:username,:pass )";
        $result = Yii::$app->db->createCommand($sql, [
            ':username' => $datos['username'] ?? '',
            ':pass' => $datos['password'] ?? '',  
        ])->queryAll();
        if(!empty($result) && $result[0]["result"] == 200){
            $id = $result[0]['id'];
            $user = User::findOne($id);
            if ($user && $user->estado === 1 ) {
                Yii::$app->user->login($user);
                return $this->redirect(['login/entrar' , 'id' => $id]);
            }else{
                Yii::$app->session->setFlash('error' ,'Parece que estas bloqueado');
                return $this->redirect(['panel/notfound']);
            }
        }else{

            return $this->redirect(['index', 'mensaje' =>'error']);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }

    public function actionRegisterCliente(){
      
        $model = new RegisterForm();
        $model->load(Yii::$app->request->post());
        if(!$model->validate()){
            return $this->redirect(['index', 'mensaje' =>'error']);
        }
        $sql = "CALL crear_cliente(:nombre,:username,:password,:email,:telefono )";
        $result = Yii::$app->db->createCommand($sql, [
            ':nombre' => $model->nombre ?? '',
            ':username' => $model->nombre . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4) ?? '',
            ':password' => $model->password ?? '',
            ':email' => $model->email ?? '',
            ':telefono' => $model->telefono ?? '',  
        ])->queryAll();
        if(!empty($result) && $result[0]["result"] == 201){
            $id = $result[0]['id_usuario'];
            $user = User::findOne($id);
            if ($user) {
                Yii::$app->user->login($user);
            }
            return $this->redirect(['login/entrar' , 'id' => $id]);
        }else{
            return $this->redirect(['index', 'mensaje' =>'error']);
         
        }
    }

    public function actionEntrar(){
      return $this->redirect(['panel/dashboard']);
    }
}
?>