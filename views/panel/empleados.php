
<main>
			<div class="head-title">
				<div class="left">
					<h1>Empleados</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Administrador</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Empleados</a>
						</li>
					</ul>
				</div>
				<!-- <a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a> -->
			</div>

			<ul class="box-info">
				<li>
				<i class='bx bxs-briefcase-alt-2'></i>
					<span class="text">
						<h3>78</h3>
						<p>Empleados</p>
					</span>
				</li>
				<li>
				<i class='bx bx-ghost' style="background-color:#000000; color:#ffffff;" ></i>

					<span class="text">
						<h3>89</h3>
						<p>Inactivos</p>
					</span>
				</li>
				<li>
				<i class='bx bx-user-voice' style="background-color:#ffffff; color:#000000;"></i>

					<span class="text">
						<h3>89</h3>
						<p>Activos</p>
					</span>
				</li>
				
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Asignar Horario</h3>
						<!-- <form action="" method="GET">
						<input type="search" name="search"  style="border-radius:15px; outline:none; border:none;" placeholder="Search...">
						<button type="submit" class="btn btn-primary botonchido "><i class='bx bx-search' ></i></button>
						</form> -->
						
						<a href="#" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary   botonchidoG" ><i class='bx bx-plus'></i>Empleado</a>
						
					</div>
					
				<form action="../Controlador/establecerHorario.php" method="POST">
					   
					  

                <!-- Hora de Inicio y Finalización en una fila -->
                <div class="row g-2 mb-2">
                    <div class="col">
                        <label for="horaInicio" class="form-label mb-1">Inicio</label>
                        <input type="time" class="form-control form-control-sm" id="horaInicio" name="inicio" required>
                    </div>
                    <div class="col">
                        <label for="horaFin" class="form-label mb-1">Fin</label>
                        <input type="time" class="form-control form-control-sm" name="fin" id="horaFin" required>
                    </div>
                </div>

                <!-- Días de la Semana en una fila -->
                <div class="mb-2">
                    <label class="form-label mb-1">Días</label>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="dias[]" value="lun" type="checkbox" id="lunes">
                            <label class="form-check-label" for="lunes">Lun</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="dias[]" value="mar" type="checkbox" id="martes">
                            <label class="form-check-label" for="Martes">Mar</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="dias[]" value="mie" type="checkbox" id="miércoles">
                            <label class="form-check-label" for="Miércoles">Mié</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="dias[]" value="jue" type="checkbox" id="jueves">
                            <label class="form-check-label" for="Jueves">Jue</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="dias[]" value="vie" type="checkbox" id="viernes">
                            <label class="form-check-label" for="Viernes">Vie</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="dias[]" value="sab" type="checkbox" id="sábado">
                            <label class="form-check-label" for="Sábado">Sáb</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="dias[]" value="dom" type="checkbox" id="domingo">
                            <label class="form-check-label" for="Domingo">Dom</label>
                        </div>
                    </div>
                </div><div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Guardar</button>
                    <button type="reset" class="btn btn-secondary btn-sm px-3">Cancelar</button>
                </div>
				<div class="head m-5">
						<h3>Empleados</h3>				
					</div>
					<table class="m-5 ">
						<thead>
							<tr class="text-center">
								<th class="fs-5" >Nombre</th>
								<th class="fs-5">Servicio</th>
								<th class="fs-5">Horario</th>
								<th class="fs-5">Estado</th>
								<th class="fs-5">Establecer Horario</th>
							</tr>
						</thead>
						<tbody>
							<td><span class="status completed"><i class="bx bx-user"></i></span></td>

							<td>
							<input type="checkbox" class="form-check-input" value="7" name="empleados[]"  >
							<span>Seleccionar</span>
							</td>
						</tbody>
					</table>
					</form>
				</div>
				<!-- <div class="todo">
					<div class="head">
						<h3>Todos</h3>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
					</ul>
				</div> -->
			</div>
		</main>