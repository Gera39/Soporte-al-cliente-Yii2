
<main>
    <div class="head-title">
        <div class="left">
            <h1>Servicios</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Administrador</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Servicios</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="table-data">
        <?= $this->render('_servicios',['servicios' => $servicios,'servicioForm' => $servicioForm])?>
    </div>
</main>