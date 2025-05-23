<?php

namespace app\controllers;

use Yii;

use app\models\EmpleadoForm;
use app\models\Logs;
use app\models\Paquete;
use app\models\RegistroAsistencia;
use app\models\ReporteOperadores;
use app\models\Tickets;
use app\models\User;


class PanelController extends BaseController
{
    public $layout = 'codetrail/main';


    public function actionDashboardAdmin()
    {
        $logs = Logs::find()->orderBy(['id' => SORT_DESC])->limit(5)->all();
        return $this->render('dashboardAdmin', ['logs' => $logs]);
    }

    public function actionDashboard()
    {
        $rol = Yii::$app->user->identity->role;
        $usuario = User::findOne(Yii::$app->user->id);
        $usuario->last_login = date('Y-m-d H:i:s');
        $usuario->save();
        if ($usuario->pregunta == null) {
            return $this->redirect(['pregunta/preguntas', 'id' => Yii::$app->user->identity->id]);
        }
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
        date_default_timezone_set('America/Mexico_City'); // Ajusta la zona

        $operador = User::findOne(Yii::$app->user->id);
        $ultimoRegistro = $operador->operadores->getRegistroAsistencias()
            ->orderBy(['fecha' => SORT_DESC])
            ->one();


        if ($ultimoRegistro) {
            $fechaRegistro = Yii::$app->formatter->asDate($ultimoRegistro->fecha, 'php:Y-m-d');
            $fechaHoy = date('Y-m-d');
            if ($fechaRegistro === $fechaHoy) {
                Yii::$app->session->setFlash('mensaje-salida', 'Ya tienes un registro de asistencia hoy. Solo marca salida y saldras del sistema');
            } else {
                Yii::$app->session->setFlash('info', 'No hay un registro de asistencia hoy.');
            }
        }
        $registroAsistencia = new RegistroAsistencia();
        return $this->render('dashboardOperador', ['model' => $operador, 'asistencia' => $registroAsistencia]);
    }
    public function actionDashboardCliente()
    {
        $paquetes = $this->enlazarPaquetes();
        return $this->render('dashboardCliente', ['paquetes' => $paquetes]);
    }

    public function paquetesComprado($id)
    {
        // Obtener los IDs de los paquetes comprados por el cliente
        $paquetesComprados = (new \yii\db\Query())
            ->select('id_paquetes_servicios')
            ->from('paquetes_clientes')
            ->where(['id_cliente' => $id])
            ->column();
        return $paquetesComprados;
    }


    public function enlazarPaquetes()
    {
        $paquetesComprados = $this->paquetesComprado(Yii::$app->user->identity->cliente->id);
        $paquetes = Paquete::find()
            ->where(['id' => $paquetesComprados])
            ->andWhere(['estado' => 'activo'])
            ->all();
        return $paquetes;
    }

    public function actionCambiarPass()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        $model->scenario = 'changePassword';

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $currentPassword = $post['current_password'] ?? '';
            $newPassword = $post['User']['password'] ?? '';
            if ($newPassword == $currentPassword) {
                Yii::$app->session->setFlash('success', 'Contraseña es la misma que la actual ');
                return $this->render('cambiar', ['model' => $model]);
            }
            $result = Yii::$app->db->createCommand('CALL cambiar_contra(:id,:contra_actual,:contra_nueva)', [
                ':id' => Yii::$app->user->identity->id,
                ':contra_actual' => $currentPassword,
                ':contra_nueva' => $newPassword,
            ])->queryAll();

            if ($result && $result[0]['resultado'] === 201) {
                Yii::$app->session->setFlash('success', 'Se ha cambiado correctamente la contraseña');
            } else if ($result && $result[0]['resultado'] === 400) {
                Yii::$app->session->setFlash('error', 'Contraseña actual no es la correcta');
            } else {
                Yii::$app->session->setFlash('error', 'Ocurrio un error intentelo nuevamente');
            }
        }
        return $this->render('cambiar', ['model' => $model]);
    }
    public function actionEmpleados()
    {
        $search = Yii::$app->request->get('search');

        if (Yii::$app->user->identity->role === 'admin') {
            $model = new EmpleadoForm();
            $sql = "SELECT * FROM obtener_operadores;";
            $empleados = Yii::$app->db->createCommand($sql)->queryAll();

            if (!empty($search)) {
                $sql = "SELECT * FROM obtener_operadores WHERE username LIKE :search";
                $command = Yii::$app->db->createCommand($sql);
                $command->bindValue(':search', "%$search%");
                $empleados = $command->queryAll();
            }

            return $this->render('empleados', [
                'empleados' => $empleados,
                'model' => $model,
                'search' => $search
            ]);
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
        if (User::getPermitidoSeccion(3)) {
            Yii::$app->session->setFlash('error', 'Página bloqueada');
            return $this->redirect(['panel/notfound']);
        }

        $searchOperador = Yii::$app->request->get('search');
        $searchCliente = Yii::$app->request->get('searchCliente');

        $query = ReporteOperadores::find()->orderBy(['id' => SORT_DESC]);

        if (!empty($searchOperador)) {
            $query->joinWith([
                'operador.usuario' => function ($q) use ($searchOperador) {
                    $q->andWhere(['like', 'users.nombre', $searchOperador]);
                }
            ]);
        }

        if (!empty($searchCliente)) {
            $query->joinWith([
                'cliente.usuario' => function ($q) use ($searchCliente) {
                    $q->andWhere(['like', 'users.nombre', $searchCliente]);
                }
            ]);
        }

        $user = Yii::$app->user->identity;

        if ($user->role === 'admin') {
            $reportes = $query->all();
        } elseif (in_array($user->role, ['operador', 'cliente'])) {
            $reportes = $query->where(['id_remitente' => $user->id])->all();
        } else {
            $reportes = [];
        }

        return $this->render('reporte', [
            'reportes' => $reportes,
            'search' => $searchOperador,
            'searchCliente' => $searchCliente
        ]);
    }
    public function actionResetPassword()
    {
        $this->layout = 'main';
        $reset = new \app\models\RegisterForm();
        if (Yii::$app->request->isPost) {
            $email = Yii::$app->request->post('RegisterForm')['email'];

            $model = User::find()->where(['email' => $email])->one();
            // var_dump($model);die;
            if ($model) {
                return $this->redirect(['panel/recover-password', 'id' => $model->id]);
            }
            Yii::$app->session->setFlash('error', 'El correo no existe');
        }
        return $this->render('reset', ['model' => $reset]);
    }

    public function actionRecoverPassword($id = null)
    {
        $this->layout = 'main';
        $model = User::findOne($id);
        $recover = new \app\models\PreguntaForm();
        $preguntas = explode(',', $model->pregunta);
        $recover->pregunta1 = $preguntas[0];
        $recover->pregunta2 = $preguntas[1];
        $recover->pregunta3 = $preguntas[2];

        $fechaHoy = new \DateTime();
        $fechaHoy->setTimezone(new \DateTimeZone('America/Mexico_City'));
        $fechaHoy->setTime(0, 0, 0); // Establecer la hora a 00:00:00 para comparar solo la fecha

        $fechaActualizacion = new \DateTime($model->updated_at);
        $diferencia = $fechaHoy->diff($fechaActualizacion)->days;
        if ($diferencia >= 1) {
            return $this->render('recover', ['id' => $model->id, 'pregunta' => $model->pregunta, 'model' => $recover]);
        }else{
        Yii::$app->session->setFlash('error', 'Ya has entrado, intenta mas tarde o contacta al administrador(Whatsapp:227-106-2767)');
        return $this->redirect(['panel/reset-password']);
        }
    }

    public function actionServiciosCliente()
    {
        return $this->render('serviciosCliente');
    }

    public function actionPerfil()
    {
        if (User::getPermitidoSeccion(1)) {
            Yii::$app->session->setFlash('error', 'Pagina bloqueada');
            return $this->redirect(['panel/notfound']);
        }
        $model =  User::findOne(Yii::$app->user->id);
        return $this->render('perfil', ['model' => $model]);
    }
    public function actionTicketsEmpleado()
    {
        $searchOperador = Yii::$app->request->get('search');
        $searchCliente = Yii::$app->request->get('searchCliente');
        $query = Tickets::find()->orderBy(['id' => SORT_DESC]);
        if (!empty($searchOperador)) {
            $query->joinWith([
                'operador.usuario' => function ($q) use ($searchOperador) {
                    $q->andWhere(['like', 'users.username', $searchOperador]);
                }
            ]);
        }
        if (!empty($searchCliente)) {
            $query->joinWith([
                'cliente.usuario' => function ($q) use ($searchCliente) {
                    $q->andWhere(['like', 'users.username', $searchCliente]);
                }
            ]);
        }
        $tickets = $query->all();
        return $this->render('ticketEmpleado', [
            'tickets' => $tickets,
            'search' => $searchOperador,
            'searchCliente' => $searchCliente,
        ]);
    }

    public function actionFiltrar($estado)
    {
        $tickets = Tickets::find()->where(['estado_ticket' => $estado])->all();
        return $this->renderPartial('/cliente/_tickets', ['tickets' => $tickets]);
    }

    public function actionFiltrarOperadores($estado)
    {
        $sql = "SELECT * FROM obtener_operadores WHERE estado = :estado";
        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(':estado', $estado);
        $empleados = $command->queryAll();
        return $this->renderPartial('_empleados', ['empleados' => $empleados]);
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
        if (User::getPermitidoSeccion(6)) {
            Yii::$app->session->setFlash('error', 'Pagina bloqueada');
            return $this->redirect(['panel/notfound']);
        }
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
