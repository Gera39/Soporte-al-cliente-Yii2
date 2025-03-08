<main id="mainChat">
    <div class="head-title">
        <div class="left">
            <h1>Mensajes</h1>
            <ul class="breadcrumb">
                <li><a href="#">Admin</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Mensajes</a></li>
            </ul>
        </div>
    </div>

    <div id="chat">
        <section id="tickets">
            <div class="alert alert-danger" role="alert">
                No se encontraron tickets
            </div>
            <ul class="text-center" style=" padding-left: 0px;">
                <li>
                    <div class="alert text-center alert-primary" role="alert">
                        Tickets
                    </div>
                </li>

                <!-- <li>
                    <a href="#">
                        <i class='bx bx-message-dots' style='color:#0f5cd7'></i>
                        <span class="text">
                            Ticket
                            Internet; 200202
                        </span>
                    </a>

                </li> -->
            </ul>
        </section>

        <section id="conversacion">
            <section id="mensajes"> <!-- Mensajes se mostrarán aquí --> </section>
            <section id="botonesMensajes">
                <input type="text" placeholder="Escribe tu mensaje aquí" id="msj" name="msj">
                <button
                    id="enviarBtn">Enviar</button>
            </section>
        </section>
    </div>
</main>