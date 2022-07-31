const formularioContactos = document.querySelector("#contacto"),
listadoContactos = document.querySelector("#listado-contactos tbody"),
inputBuscador = document.querySelector("#buscar");

eventListeners();

function eventListeners() {
  // Cuando el formulario de crear o editar se ejecute
  formularioContactos.addEventListener("submit", leerFormulario);
  
  // Listener para eliminar el contacto
  if (listadoContactos) {
    listadoContactos.addEventListener("click", eliminarContacto);  
  }

  // Buscador
  inputBuscador.addEventListener("input", buscarContactos);

  // Mostrar la cantidad de Contactos
  numeroContacto();
}

function leerFormulario(e) {
  e.preventDefault();
  
  // Leer los datos de los imput
  const nombre = document.querySelector("#nombre").value,
  empresa = document.querySelector("#empresa").value,
  telefono = document.querySelector("#telefono").value,
  accion = document.querySelector("#accion").value;
  
  if (nombre === "" || empresa === "" || telefono === "") {
    // 2 parametros texto y clase
    mostrarNotificacion("Todos los Campos son Obligatorios", "error");
  } else {
    // Pasar la validacion, Crear llamado a AJAX
    const infoContacto = new FormData();
    infoContacto.append("nombre", nombre);
    infoContacto.append("empresa", empresa);
    infoContacto.append("telefono", telefono);
    infoContacto.append("accion", accion);
    
    if (accion === "crear") {
      // Crearemos un nuevo contacto
      insertarBD(infoContacto);
    } else {
      // Editar el contacto
      // leer el id
      const idRegistro = document.querySelector('#id').value;
      infoContacto.append('id', idRegistro);
      actualizarRegistro(infoContacto);
    }
  }
}

// Insertar en la base de datos via AJAX
function insertarBD(datos) {
  // LLamado a AJAX
  
  // Crear el Objeto
  const xhr = new XMLHttpRequest();
  
  // Abrir la conexion
  xhr.open("POST", "inc/models/modelo-contactos.php", true);
  
  // Pasar los datos
  xhr.onload = function () {
    if (this.status === 200) {
      //Leemos la respuesta de PHP
      const respuesta = JSON.parse(xhr.responseText);
      
      // Inserta un nuevo elemento a la tabla
      const nuevoContacto = document.createElement("tr");
      
      nuevoContacto.innerHTML = `
      <td>${respuesta.datos.nombre}</td>
      <td>${respuesta.datos.empresa}</td>
      <td>${respuesta.datos.telefono}</td>
      `;
      
      // Contenedor para los botones
      const contenedorAcciones = document.createElement("td");
      
      // Crear el icono de editar
      const iconoEditar = document.createElement("i");
      iconoEditar.classList.add("fas", "fa-pen-square");
      
      // Crear el enlace para editar
      const btnEditar = document.createElement("a");
      btnEditar.appendChild(iconoEditar);
      btnEditar.href = `editar.php?id=${respuesta.datos.id_insertado}`;
      btnEditar.classList.add("btn", "btn-editar");
      
      // Agregarlo al padre editar
      contenedorAcciones.appendChild(btnEditar);
      
      // Crear el icono de eliminar
      const iconoEliminar = document.createElement("i");
      iconoEliminar.classList.add("fas", "fa-trash-alt");
      
      // Crear el boton de eliminar
      const btnEliminar = document.createElement("button");
      btnEliminar.appendChild(iconoEliminar);
      btnEliminar.setAttribute("data-id", respuesta.datos.id_insertado);
      btnEliminar.classList.add("btn", "btn-borrar");
      
      // Agregarlo al padre eliminar
      contenedorAcciones.appendChild(btnEliminar);
      
      // Agregarlo al tr
      nuevoContacto.appendChild(contenedorAcciones);
      
      // Agregarlo con los contactos
      listadoContactos.appendChild(nuevoContacto);
      
      // Resetear el Formulario
      document.querySelector("form").reset();
      
      // Mostrar la notififcaion
      mostrarNotificacion("Contacto Creado Correctamente", "exito");
      numeroContacto();
    }
  };
  
  // Enviar los datos
  xhr.send(datos);
}

// Actualizar en la base de datos via AJAX
function actualizarRegistro(datos) {
  // crear el obejo 
  const xhr = new XMLHttpRequest();

  // Abrir la conexion
  xhr.open('POST', 'inc/models/modelo-contactos.php', true);

  // leer la respuesta
  xhr.onload = function() {
    if (this.status ===200) {
      const respuesta = JSON.parse(xhr.responseText)
      if (respuesta.respuesta === 'correcto') {
        // Mostramos una Notificaion
        mostrarNotificacion("Contacto Actualizado Correctamente", "exito");
      } 
      setTimeout(() => {
        window.location.href = 'index.php';
      }, 3500)
    }
  }

  // enviar la peticion
  xhr.send(datos);
}

// Eliminar el contacto
function eliminarContacto(e) {
  if (e.target.parentElement.classList.contains("btn-borrar")) {
    // Tomar el id
    const id = e.target.parentElement.getAttribute("data-id");
    
    // Preguntar al usuario si esta seguro
    const respuesta = confirm("¿Estas Seguro?");
    if (respuesta) {
      // LLamado a AJAX
      
      // Crear el Objeto
      const xhr = new XMLHttpRequest();
      
      // Abrir la conexion
      xhr.open("GET", `inc/models/modelo-contactos.php?id=${id}&accion=borrar`);
      
      // Pasar los datos
      xhr.onload = function () {
        if (this.status === 200) {
          
          const respuesta = JSON.parse(xhr.responseText);
          
          if (respuesta.respuesta === 'correcto') {
            //Eliminar el registro del Dom  
            e.target.parentElement.parentElement.parentElement.remove();
            // Mostramos una Notificaion
            mostrarNotificacion("Contacto Eliminado", "exito");
            numeroContacto()
          } else {
            // Mostramos una Notificaion
            mostrarNotificacion("Hubo un error...", "error");
          }
        }
      };
      // Enviar los datos
      xhr.send();
    } 
  }
}

//Notificacion en pantalla
function mostrarNotificacion(mensaje, clase) {
  const notificacion = document.createElement("div");
  notificacion.classList.add(clase, "notificacion", "sombra");
  notificacion.textContent = mensaje;
  
  // Formulario
  formularioContactos.insertBefore(
    notificacion,
    document.querySelector("form legend")
    );
    
    // ocultar y mostrar la notificacion
    setTimeout(() => {
      notificacion.classList.add("visible");
      
      setTimeout(() => {
        notificacion.classList.remove("visible");
        
        setTimeout(() => {
          notificacion.remove();
        }, 500);
      }, 3000);
    }, 100);
  }

// Buscar Conctactos
function buscarContactos(e) {
  const expresion = new RegExp(e.target.value, "i" ),
        registros = document.querySelectorAll('tbody tr');

  registros.forEach(registro => {
    registro.style.display = 'none';
    
    if (registro.childNodes[1].textContent.replace(/\s/g, " ").search(expresion) != -1 || registro.childNodes[3].textContent.replace(/\s/g, " ").search(expresion) != -1 || registro.childNodes[5].textContent.search(expresion) != -1) {
      registro.style.display = 'table-row';
    }
    numeroContacto()
  })
  
}
  
// Mostrar la cantidad de Contactos
function numeroContacto() {
  const totalContactos = document.querySelectorAll('tbody tr'),
        contenedorNumero = document.querySelector('.total-contactos span');

  let total = 0;
  totalContactos.forEach(contacto => {
    if (contacto.style.display === '' || contacto.style.display === 'table-row') {
      total++;
    }
    contenedorNumero.textContent = total;
  });
}