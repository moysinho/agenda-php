<?php
include "inc/functions/funciones.php";
include "inc/layout/header.php";

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

$resultado = obtenerContacto($id);

$contacto = $resultado->fetch_assoc();

?>

<div class="contenedor-barra">
    <div class="contenedor barra">
        <a href="index.php" class="btn volver">Volver</a>
        <h1>Editar Contactos</h1>
    </div> <!-- Contenedor y barra clases separadas -->
</div> <!-- Contenedor Barra -->

<div class="bg-amarillo contenedor sombra">
    <form action="#" id="contacto">
        <legend>Edite el Contacto</legend>

        <?php include "inc/layout/formulario.php" ?>

    </form>
</div> <!-- contenedor amarillo -->

<?php include "inc/layout/footer.php" ?>