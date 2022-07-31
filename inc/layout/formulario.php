<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre: </label>
        <input 
            type="text" 
            placeholder="Nombre Contacto" 
            id="nombre" 
            value="<?php echo ($pagina === 'editar' ? $contacto['nombre_contacto'] : ''); ?>"
        >
    </div>
    <div class="campo">
        <label for="empresa">Empresa: </label>
        <input 
            type="text" 
            placeholder="Empresa Contacto" 
            id="empresa"
            value="<?php echo ($pagina === 'editar' ? $contacto['empresa_contacto'] : ''); ?>"
        >
    </div>
    <div class="campo">
        <label for="telefono">Teléfono: </label>
        <input 
            type="tel" 
            placeholder="Teléfono Contacto" 
            id="telefono"
            value="<?php echo ($pagina === 'editar' ? $contacto['telefono_contacto'] : ''); ?>"
        >
    </div>
</div> <!-- Contenedor padre para flexbox (Campos) -->
<div class="campo enviar">
    <?php
    $textoBtn = ($pagina === 'editar') ? 'Guardar' : 'Añadir';
    $accion = ($pagina === 'editar') ? 'editar' : 'crear';
    ?>
    <input type="hidden" id="accion" value="<?php echo $accion; ?>">
    <?php if(isset($contacto['id_contacto'])) { ?>
        <input type="hidden" id="id" value="<?php echo $contacto['id_contacto']; ?>">
    <?php } ?>
    <input type="submit" value="<?php echo $textoBtn; ?>">
</div>