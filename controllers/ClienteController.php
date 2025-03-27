<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use app\models\User;
use app\models\Tickets;
use app\models\Paquete;
use app\models\Categories;
use app\models\PaquetesClientes;
use app\models\TicketForm;
use yii\web\NotFoundHttpException;


// if(Yii::$app->user->isGuest){
//     Yii::$app->session->setFlash('error', 'Debes de iniciar sesion, regresa al login');
//     Yii::$app->response->redirect(['panel/notfound'])->send();
//     Yii::$app->end();
// }
class ClienteController extends BaseController
{

    public $layout = 'codetrail/main';

    public function actionView($id)
    {
        $model = $this->findModel($id);
        // var_dump($model);
        // return;
        return $this->render('view', [
            'model' => $model,
        ]);
    }


    public function actionPaquetesComprados()
    {
        $cliente = $this->findCliente(Yii::$app->user->identity->cliente->id);
        if (!$cliente) {
            throw new \yii\web\NotFoundHttpException('Cliente no encontrado.');
        }
        $paquetes = $this->enlazarPaquetes($cliente->id);
        return $this->renderPartial('/servicio/_paquetes', ['paquetes' => $paquetes, 'permiso' => 'no']);
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

    public function actionDashboard()
    {
        $cliente = $this->findCliente(Yii::$app->user->identity->cliente->id);
       
        $paquetes = $this->enlazarPaquetes($cliente->id);
        return $this->render('dashboard', ['paquetes' => $paquetes]);
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


    public function actionServiciosCliente()
    {
        if (User::getPermitidoSeccion(7)) {
            Yii::$app->session->setFlash('error', 'Pagina bloqueada');
            return $this->redirect(['panel/notfound']);
        }
        $cliente = $this->findCliente(Yii::$app->user->identity->cliente->id);
        if (!$cliente) {
            throw new \yii\web\NotFoundHttpException('Cliente no encontrado.');
        }
        // Obtener los IDs de los paquetes comprados por el cliente
        $paquetesComprados = $this->paquetesComprado($cliente->id);
        // Obtener los paquetes que NO están en la lista de paquetes comprados
        $paquetes = Paquete::find()
            ->where(['not in', 'id', $paquetesComprados])
            ->andWhere(['estado' => 'activo']) // Solo paquetes activos
            ->all();

        $permiso = 'comprados';
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderPartial('/servicio/_paquetes', ['paquetes' => $paquetes, 'permiso' => $permiso]);
        }
        return $this->render('servicio', ['paquetes' => $paquetes, 'permiso' => $permiso]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findCliente($id);
        return $this->render('update', ['model' => $model]);
    }

    protected function findCliente($id)
    {
        if (($model = Cliente::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('no quiso salir');
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFiltrar($estado, $idOperador)
    {
        $tickets = Tickets::find()->where(['estado_ticket' => $estado, 'id_cliente' => $idOperador])->orderBy(['id' => SORT_DESC])->all();
        return $this->renderPartial('/cliente/_tickets', ['tickets' => $tickets]);
    }

    public function actionUpdateEstatus($id = null)
    {

        $model = $this->findModel($id);
        if (!$model) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['status' => 'error', 'message' => 'Empleado no encontrado'];
        }
        if ($this->request->isPost) {
            // Si la solicitud es AJAX, responde con JSON
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                $nuevoEstado = Yii::$app->request->post('estado');
                $model->estado = $nuevoEstado;
                if ($id = Yii::$app->request->post('id')) {
                    $model->id = $id;
                }
                if ($model->save()) {
                    return ['status' => 'success', 'message' => 'Estado actualizado correctamente'];
                } else {
                    return ['status' => 'error', 'message' => 'No se pudo actualizar el estado'];
                }
            }
            // Si la solicitud es normal (formulario), procesar y redirigir
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['cliente/index']);
            }
        }
        return $this->redirect('panel/empleados');
    }


    public function actionComprar($id, $cliente)
    {
        $model = new PaquetesClientes();
        $model->id_paquetes_servicios = $id;
        $model->id_cliente = $cliente;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Paquete comprado correctamente');
            return $this->redirect(['cliente/servicios-cliente']);
        }
    }

    public function actionTicketCliente()
    {
        if (User::getPermitidoSeccion(2)) {
            Yii::$app->session->setFlash('error', 'Pagina bloqueada');
            return $this->redirect(['panel/notfound']);
        }
        $ticketForm = new TicketForm();
        $paquetes = $this->enlazarPaquetes(Yii::$app->user->identity->cliente->id);
        $categoria = Categories::find()->all();
        $cliente = $this->findCliente(Yii::$app->user->identity->cliente->id);
        $tickets = Tickets::find()->where(['id_cliente' => $cliente->id])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('ticket', ['tickets' => $tickets, 'ticketForm' => $ticketForm, 'categoria' => $categoria, 'paquetes' => $paquetes,'cliente' => $cliente]);
    }

    public function actionChatCliente($id, $rol)
    {
        return $this->redirect(['chat/mostrar-chat', 'id' => $id, 'rol' => $rol]);
    }

    public function actionIndex()
    {   
        $search = $this->request->get('search');
        $query = Cliente::find()->orderBy(['id' => SORT_DESC]);
        if (!empty($search)) {
            $query->joinWith([
            'usuario' => function($q) use ($search) {
                $q->andWhere(['or', 
                ['like', 'users.username', $search],
                ['like', 'users.email', $search]
                ]);
            }
            ]);
        }
        $clientes = $query->all();
        return $this->render('index', ['clientes' => $clientes,'search' => $search]);
    }

    public function actionFiltrarCliente($estado)
    {
        $clientes = Cliente::find()->joinWith('usuario')->where(['users.estado' => $estado])->andWhere(['users.role' => 'cliente'])->all();
        return $this->renderPartial('_clientes', ['clientes' => $clientes]);
    }
}
