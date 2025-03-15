<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Tickets;
use app\models\Operador;
use yii\web\UploadedFile;

class TicketController extends Controller
{
    public $layout = 'codetrail/main';
    public function actionLevantarTicket()
    {
        $datos = Yii::$app->request->post('TicketForm', []);

            if (empty($datos)) {
                Yii::$app->session->setFlash('error', 'No se recibieron datos.');
                return $this->redirect(['cliente/ticket-cliente']);
            }
        $archivo = UploadedFile::getInstanceByName('TicketForm[nombre_archivo]');
        $directorioUploads = Yii::getAlias('@webroot/uploads');
        if ($archivo) {
           
            $rutaArchivo = $directorioUploads . '/'. $archivo->baseName . '.' . $archivo->extension;
            if ($archivo->saveAs($rutaArchivo)) {
                $nombreArchivo =$archivo->name;
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo subir el archivo.');
                return $this->redirect(['cliente/ticket-cliente']);
            }
        }
        if (!isset(Yii::$app->user->identity->cliente->id)) {
            Yii::$app->session->setFlash('error', 'No se encontró un cliente asociado.');
            return $this->redirect(['cliente/ticket-cliente']);
        }
        $sql = "CALL insertar_ticket_con_imagen(:id_categoria, :id_paquete, :id_cliente, :descripcion, :prioridad, :nombre_archivo)";
        $resultado = Yii::$app->db->createCommand($sql, [
            ':id_categoria' => $datos['id_categoria'] ?? '',
            ':id_paquete' => $datos['id_paquete'] ?? '',
            ':id_cliente' => Yii::$app->user->identity->cliente->id,
            ':descripcion' => $datos['descripcion'] ?? '',
            ':prioridad' => $datos['prioridad'] ?? '',
            ':nombre_archivo' => $nombreArchivo,
        ])->queryAll();
        if (!empty($resultado) && $resultado[0]['resultado'] == 200) {
            Yii::$app->session->setFlash('success', 'Ticket levantado con éxito.');
        } else {
            Yii::$app->session->setFlash('error', 'Hubo un problema al levantar el ticket.');
        }

        return $this->redirect(['cliente/ticket-cliente']);
    }


    public function actionView($id)
    {
        $ticket = Tickets::findOne($id);

        if (!$ticket) {
            Yii::$app->session->setFlash('error', 'No se encontró el ticket.');
            return $this->redirect(['cliente/ticket-cliente']);
        }
        return $this->render('view', ['model' => $ticket]);
    }
}
