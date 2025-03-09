

document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll(".btn-check");
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("focus", function(event) {
            event.preventDefault(); // Evita que el navegador realice el scroll
        });
    });
});
const switchMode = document.getElementById('switch-mode');


function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

const theme = getCookie('theme') || 'light';
if (theme === 'dark') {
  document.body.classList.add('dark');
  switchMode.checked = true;
}

switchMode.addEventListener('change', function () {
  if(this.checked) {
    document.body.classList.add('dark');
    document.cookie = "theme=dark; path=/";
  } else {
    document.body.classList.remove('dark');
    document.cookie = "theme=light; path=/";
  }
});


// const validCareers = ["redes","telecomunicaciones","seguridad informatica","electronica", "desarrollo de software"];
// const careerInput = document.getElementById('carreraEmpleado');

// careerInput.addEventListener('input', function () {
//   const inputValue = careerInput.value.toLowerCase();
//   if (validCareers.includes(inputValue)) {
//     careerInput.setCustomValidity('');
//   } else {
//     careerInput.setCustomValidity('Por favor, ingrese una carrera válida.');
//   }
// });

// const nameInput = document.getElementById('nombreEmpleado');

// nameInput.addEventListener('input', function () {
//   const nameValue = nameInput.value.trim();
//   const namePattern = /^[a-zA-Z\s]+$/;

//   if (nameValue === '') {
//     nameInput.setCustomValidity('El nombre no puede estar vacío.');
//   } else if (!namePattern.test(nameValue)) {
//     nameInput.setCustomValidity('Por favor, ingrese un nombre válido (solo letras y espacios).');
//   } else {
//     nameInput.setCustomValidity('');
//   }
// });
const cerrarModal =document.getElementById('cerrar_modal');
const modal = document.getElementById('mi_modal');

cerrarModal.addEventListener('click', function(){
  modal.classList.remove('modal--show');
});





function mostrarAlerta(idUsuario, estadoActual) {
  const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger m-2"
      },
      buttonsStyling: false
  });
  swalWithBootstrapButtons.fire({
      title: "¿Estás seguro?",
      text: "El operador está actualmente " + estadoActual + ",¿Desea " + (estadoActual === "Activo" ? "bloquear" : "activar") + " ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, "+ (estadoActual === "Activo" ? "bloquear" : "activar") + "!",
      cancelButtonText: "No, cancelar",
      reverseButtons: true
  }).then((result) => {
      if (result.isConfirmed) {
          let nuevoEstado = estadoActual === "Activo" ? 0 : 1; 
          console.log(nuevoEstado);
          $.ajax({
              url: 'index.php?r=cliente/update-estatus&id=' + idUsuario, 
              type: 'POST',
              data: {
                estado: nuevoEstado
              },
              dataType: 'json',
              cache: false,
              success: function(response) {
                  if (response.status === "success") {
                      Swal.fire({
                          title: "¡Estado cambiado!",
                          text: response.message, 
                          icon: "success"
                      }).then(() => {
                          location.reload();
                      });
                  } else {
                      Swal.fire({
                          title: "Error",
                          text: response.message || "No se pudo cambiar el estado",
                          icon: "error"
                      });
                  }
              },
          });
      }
  });
}
