<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;

use app\models\EmpleadoForm;
use app\models\Logs;
use app\models\ReporteOperadores;
use app\models\Tickets;
use app\models\User;
use yii\filters\AccessControl;

class PanelController extends Controller
{
    public $layout = 'codetrail/main';

    public function behaviors()
    {
        return [
            'access' => [  // <-- Configuración de AccessControl
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],  // Solo usuarios logueados
                    ],
                    // Más reglas personalizadas si las necesitas...
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->session->setFlash('error', 'Debes de iniciar sesion, regresa al login');
                        Yii::$app->response->redirect(['panel/notfound']);
                    } else {
                        Yii::$app->session->setFlash('error', 'No tienes permisos para acceder');
                        Yii::$app->response->redirect(['panel/notfound']);
                    }
                }
            ],
        ];
    }
    public function actionDashboardAdmin()
    {
        $logs = Logs::find()->orderBy(['id' => SORT_DESC])->limit(5)->all();
        return $this->render('dashboardAdmin', ['logs' => $logs]);
    }

    public function actionDashboard()
    {
        $rol = Yii::$app->user->identity->role;
        $operador = User::findOne(Yii::$app->user->id);
        $operador->last_login = date('Y-m-d H:i:s');
        $operador->save();
        if ($rol == 'cliente') {
            return $this->redirect(['panel/dashboard-cliente']);
        } else if ($rol == 'admin') {
            return $this->redirect(['panel/dashboard-admin']);
        } else if ($rol == 'operador') {
            return $this->redirect(['panel/dashboard-operador']);
        }
    }

    public function actionDashboardOperador()
    {
        $operador = User::findOne(Yii::$app->user->id);

        return $this->render('dashboardOperador', ['model' => $operador]);
    }
    public function actionDashboardCliente()
    {
        return $this->render('dashboardCliente');
    }

    public function actionCambiarPass()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        $model->scenario = 'changePassword';

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $currentPassword = $post['current_password'] ?? '';
            $newPassword = $post['User']['password'] ?? '';

            $result = Yii::$app->db->createCommand('CALL cambiar_contra(:id,:contra_actual,:contra_nueva)', [
                ':id' => Yii::$app->user->identity->id,
                ':contra_actual' => $currentPassword,
                ':contra_nueva' => $newPassword,
            ])->queryAll();
            if ($result[0]['resultado'] === 201) {
                Yii::$app->session->setFlash('success', 'Se ha cambiado correctamente la contraseña');
            } else if($result[0]['resultado'] === 400){
                Yii::$app->session->setFlash('error', 'Contraseña actual no es la correcta');
            }else{
                Yii::$app->session->setFlash('error', 'Ocurrio un error intentelo nuevamente');
            }
        }
        return $this->render('cambiar', ['model' => $model]);
    }
    public function actionEmpleados()
    {
        if (Yii::$app->user->identity->role === 'admin') {
            $model = new EmpleadoForm();
            $sql = "CALL obtener_empleados();";
            $empleados = Yii::$app->db->createCommand($sql)->queryAll();
            return $this->render('empleados', ['empleados' => $empleados, 'model' => $model]);
        } else {
            return $this->redirect(['panel/notfound']);
        }
    }
    public function actionNotfound()
    {
        $this->layout = 'main';
        return $this->render('notfound');
    }
    public function actionServicios()
    {
        return $this->redirect(['servicio/index']);
    }

    public function actionReportes()
    {
        $user = Yii::$app->user->identity;
        if ($user->role === 'admin') {
            $reportes = ReporteOperadores::find()->orderBy(['id' => SORT_DESC])->all();
        } elseif ($user->role === 'operador' || $user->role === 'cliente') {
            $reportes = ReporteOperadores::find()->where(['id_remitente' => $user->id])->orderBy(['id' => SORT_DESC])->all();
        }
        return $this->render('reporte', ['reportes' => $reportes]);
    }

    public function actionServiciosCliente()
    {
        return $this->render('serviciosCliente');
    }

    public function actionPerfil()
    {
        $model =  User::findOne(Yii::$app->user->id);
        return $this->render('perfil', ['model' => $model]);
    }
    public function actionTicketsEmpleado()
    {
        $tickets = Tickets::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('ticketEmpleado', ['tickets' => $tickets]);
    }

    public function actionFiltrar($estado)
    {
        $tickets = Tickets::find()->where(['estado_ticket' => $estado])->all();
        return $this->renderPartial('/cliente/_tickets', ['tickets' => $tickets]);
    }

    public function actionClientes()
    {
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

    public function actionResoluciones()
    {
        $search = Yii::$app->request->get('search');
        $sql = "SELECT * FROM resoluciones";
        if (!empty($search)) {
            $sql .= " WHERE descripcion LIKE :search";
        }
        $command = Yii::$app->db->createCommand($sql);
        if (!empty($search)) {
            $command->bindValue(':search', "%$search%");
        }
        $resoluciones = $command->queryAll();
        return $this->render('resolucion', [
            'resoluciones' => $resoluciones,
            'search' => $search
        ]);
    }
}
