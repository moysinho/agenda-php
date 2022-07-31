<?php
include "inc/functions/funciones.php";

include "inc/layout/header.php";
?>

<div class="contenedor-barra">
    <h1>Agenda de Contactos</h1>
</div> <!-- Contenedor barra -->

<div class="bg-amarillo contenedor sombra">
    <form action="#" id="contacto">
        <legend>Añada un Contacto <span>Todos los campos son obligatorios</span></legend>

        <?php include "inc/layout/formulario.php";?>

    </form>
</div> <!-- contenedor amarillo -->

<div class="bg-blanco contenedor sombra contactos">
    <div class="contenedor-contactos">
        <h2>Contactos</h2>

        <input type="text" name="" id="buscar" class="buscador sombra" placeholder="Buscar Contactos...">

        <p class="total-contactos"><span></span> Contactos</p>

        <div class="contenedor-tabla">
            <table id="listado-contactos" class="listado-contactos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contactos = obtenerContactos();

                    if ($contactos->num_rows) {

                        foreach ($contactos as $contacto) { ?>
                            <tr>
                                <td><?php echo $contacto['nombre_contacto']; ?></td>
                                <td><?php echo $contacto['empresa_contacto']; ?></td>
                                <td><?php echo $contacto['telefono_contacto']; ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $contacto['id_contacto']; ?>" class="btn btn-editar">
                                        <i class="fas fa-pen-square"></i>
                                    </a>

                                    <button data-id="<?php echo $contacto['id_contacto']; ?>" type="button" class="btn btn-borrar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div> <!-- contenedor tabla -->
    </div> <!-- Contenedor contactos -->
</div> <!-- contenedor blanco -->

<?php include "inc/layout/footer.php" ?>