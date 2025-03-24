<?php 
use yii\helpers\Url; 
?>


<div class="modal fade" id="myModalTicketOperador" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myModalLabel">Comnetario Resolución</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="ticket-id" class="form-control" value="7">
                <div class="mb-3">
                    <label for="ticket-descripcion" style="font-size:20px;">Descripción de la solución del  Ticket</label>
                    <textarea id="ticket-descripcion" rows="6" class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitTicket()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
