
<main>
    <div class="head-title">
        <div class="left">
            <h1>Perfil</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Perfil</a>
                </li>
            </ul>
        </div>


   

    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        <span class="text"><i class='bx bx-plus'></i>Adminitrador</span>
    </a>
    
         </div>

    <i class="bx bx-user" style="font-size:150px;"></i> <!-- Tamaño 3 veces más grande -->
    
    
    <form action="../Controlador/LoginControlador.php?accion=actualizarPerfil" method="POST">


        <div class="form-group p-3">
            <input type="text" class="form-control custom-input" value=""
                placeholder="Nombre" name="nombre" required>
        </div>
        <div class="form-group p-3">
            <input type="text" class="form-control custom-input" value=""
                placeholder="Apellido" name="apellido" required>
        </div>
        <div class="form-group p-3">
            <input type="email" class="form-control custom-input" value=""
                placeholder="Correo" name="correo" required>
        </div>
        <div class="form-group p-3">
            <input type="tel" class="form-control custom-input" value=""
                placeholder="Teléfono" name="telefono" required>
        </div>
        
       
        <div class="form-group p-3">
        <button class="btn btn-primary" onclick="obtenerUbicacionUsuario()">Obtener Ubicación  <i class='bx bx-world' style="font-size:20px;"></i></button>
            <input type="text" class="form-control custom-input" value=""
                placeholder="Dirección" id="direccion" name="direccion" required>
        </div>
        <div class="form-group p-3">
            <input type="text" class="form-control custom-input" value=""
                placeholder="Municipio" id="estado" name="estado" required>
        </div>
        <div class="form-group p-3">
            <input type="text" class="form-control custom-input" value= ""  placeholder="Código Postal" id="cp" name="cp" required>
        </div>
        <div class="form-group p-3">
            <input type="password" class="form-control custom-input" placeholder="Nueva contraseña" id="contrasena"
                name="password" required>
        </div>
        <input type="hidden" name="rol" value="1">
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary btn-sm px-3">Guardar</button>
            <button type="reset" class="btn btn-secondary btn-sm px-3">Cancelar</button>
        </div>

    </form>

   




</main>