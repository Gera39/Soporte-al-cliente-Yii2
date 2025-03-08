
<!-- MAIN -->
<main>
			<div class="head-title">
				<div class="left">
					<h1>Tickets</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Tickets</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">tickets</a>
						</li>
					</ul>
				</div>
				
			</div>

           
            
			<div class="table-data">
				
          
				<div class="todo">
                <form action="../Controlador/insertTicket.php" method="POST">
                    <h3>Crear Ticket</h3>
					<input type="hidden" name="id_cliente" value="78">
                    <select name="id_empleado" id="id_emp" class="form-select custom-select" required>
                        <option value="">Selecciona un Empleado y Servicio Disponible</option>
                    </select>
                    <textarea class="form-control mt-3" id="descripcion" name="descripcion" placeholder="Descripción" rows="3" required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm px-3 mt-3">Crear</button>
                    </form>
					<div class="head m-4">
						<h3>Tickets</h3>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Internet<br>no hay<br>00/00/00</p>
							<i class='bx bx-message-square-dots bx-tada' style="font-size:30px;"></i>
						</li>
						<li class="not-completed">
							<p>Internet <br> no hay  <br>00/00/00</p>
							<i class='bx bx-message-square-dots bx-tada' style="font-size:30px;"></i>
						</li>
					</ul>
				</div>
			</div>
           
		</main>
