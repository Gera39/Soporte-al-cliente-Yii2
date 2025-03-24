<?php

namespace app\controllers;

use app\models\User;
use yii\web\Controller;
use Yii;
use app\models\SeccionesAcciones;
use app\models\SeccionForm;
use app\models\Secciones;
use yii\web\NotFoundHttpException;

class PermisosController extends Controller
{

    public $layout = 'codetrail/main';

    public function actionIndex()
    {
        $usuario = User::find()->where(['!=', 'role', 'admin'])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['usuarios' => $usuario]);
    }

    public function actionView($id)
    {
        $model = User::findOne($id);

        $seccionesAcciones = SeccionesAcciones::find()
            ->where(['id_usuario' => $id])
            ->all();
        // Agrupar acciones por sección
        $seccionesData = [];
        foreach ($seccionesAcciones as $sa) {
            $seccion = $sa->secciones;
            $accion = $sa->acciones;
            if ($seccion && $accion) {
                $seccionId = $seccion->id;
                if (!isset($seccionesData[$seccionId])) {
                    $seccionesData[$seccionId] = [
                        'seccion' => $seccion,
                        'acciones' => [],
                    ];
                }
                $seccionesData[$seccionId]['acciones'][] = $accion;
            }
        }

        $seccionesFaltantes = Secciones::find()
            ->where(['not in', 'id', array_keys($seccionesData)])
            ->all();

        $seccionForm = new SeccionForm();
        return $this->render('view', [
            'model' => $model,
            'seccionesFaltantes' => $seccionesFaltantes,
            'seccionesData' => $seccionesData,
            'seccionForm' => $seccionForm,
        ]);
    }
    public function actionUpdateEstatus($id = null)
    {
        $model = $this->findModel($id);
        if (!$model) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['status' => 'error', 'message' => 'Empleado no encontrado'];
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['permisos/index']);
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionAgregarSeccion()
    {
        $seccionForm = new SeccionForm();
        $seccionesAcciones  = new SeccionesAcciones();

        if ($seccionForm->load(Yii::$app->request->post()) && $seccionForm->validate()) {
            $seccionesAcciones->id_secciones = $seccionForm->nombre;
            $seccionesAcciones->id_usuario = $seccionForm->usuario_id;
            $seccionesAcciones->id_acciones = 2;
            $seccionesAcciones->save();
            return $this->redirect(['permisos/view', 'id' => $seccionForm->usuario_id]);
        }
    }

    public function actionEliminar($id, $idUsuario)
    {
        SeccionesAcciones::deleteAll(['id_secciones' => $id, 'id_usuario' => $idUsuario]);
        return $this->redirect(['permisos/view', 'id' => $idUsuario]);
    }

    public function actionActualizar()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $idUsuario = (int) $request->post('idUsuario');
            $accionesPorSeccion = $request->post('Secciones')['acciones'] ?? [];
            try {
                // Iterar por cada sección para eliminar solo los permisos específicos de cada sección
                foreach ($accionesPorSeccion as $idSeccion => $accionesIds) {
                    $idSeccion = (int) $idSeccion; // Asegurar que es un entero
                    // Eliminar permisos existentes de esta sección para este usuario
                    SeccionesAcciones::deleteAll([
                        'id_usuario' => $idUsuario,
                        'id_secciones' => $idSeccion
                    ]);
                    // Insertar nuevos permisos
                    foreach ($accionesIds as $idAccion) {
                        $idAccion = (int) $idAccion; // Asegurar que es un entero
                        // Evitar insertar valores inválidos
                        $permiso = new SeccionesAcciones();
                        $permiso->id_secciones = $idSeccion;
                        $permiso->id_acciones = $idAccion;
                        $permiso->id_usuario = $idUsuario;
                        $permiso->save();
                    }
                }
                Yii::$app->session->setFlash('success', 'Permisos actualizados correctamente');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'Error al guardar permisos: ' . $e->getMessage());
            }

            return $this->redirect(['view', 'id' => $idUsuario]);
        }
        throw new \yii\web\BadRequestHttpException('Solicitud inválida');
    }


    public function actionRestablecer($id, $rol)
    {
        if ($rol === 'operador') {
            $sql = "CALL permisosOperador(:id)";
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(':id', $id);
            $command->execute();
            return $this->redirect(['permisos/view', 'id' => $id]);
        } else {
            $sql = "CALL permisosCliente(:id)";
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(':id', $id);
            $command->execute();
            return $this->redirect(['permisos/view', 'id' => $id]);
        }
    }

    public function actionSecciones()
    {
        $secciones = Secciones::find()->all();
        return $this->render('secciones', ['secciones' => $secciones]);
    }

    public function actionUpdateSeccion($id, $rol)
    {
        $seccion = Secciones::findOne($id);
        if ($id === '0' && $rol === 'todos') {

            $secciones = Secciones::find()->all();
            foreach ($secciones as $seccion) {
                $seccion->estado = ($seccion->estado) ? 0 : 1;
                $seccion->save();
            }
            Yii::$app->session->setFlash('success', 'Secciones desbloqueadas correctamente.');
            return $this->redirect(['permisos/secciones']);
        }
        if (!$seccion) {
            throw new NotFoundHttpException('Sección no encontrada.');
        }
        $estadoMap = [
            'cliente' => [1 => 3, 2 => 0, 3 => 1, 0 => 2],
            'operador' => [0 => 3, 1 => 2, 3 => 0, 2 => 1]
        ];

        if (isset($estadoMap[$rol][$seccion->estado])) {
            $seccion->estado = $estadoMap[$rol][$seccion->estado];
            $seccion->save();
            Yii::$app->session->setFlash('success', 'Estado de la sección actualizado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Rol o estado no válido.');
        }
        return $this->redirect(['permisos/secciones']);
    }
}
