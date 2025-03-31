document.addEventListener("DOMContentLoaded", function () {
  const checkboxes = document.querySelectorAll(".btn-check");
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("focus", function (event) {
      event.preventDefault(); // Evita que el navegador realice el scroll
    });
  });
});

const cerrarModal = document.getElementById("cerrar-modal");
const modal = document.getElementById("mi_modal");

cerrarModal.addEventListener("click", function () {
  modal.classList.remove("modal--show");
});
function mostrarAlerta(idUsuario, estadoActual, nombreUsuario) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger m-2",
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: "¿Estás seguro?",
      text:
        " Está actualmente " +
        estadoActual +
        ",¿Desea " +
        (estadoActual === "Activo" ? "suspender" : "activar") +
        " ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText:
        "Sí, " + (estadoActual === "Activo" ? "suspender" : "activar") + "!",
      cancelButtonText: "No, cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        let nuevoEstado = estadoActual === "Activo" ? 0 : 1;
        $.ajax({
          url:
            "index.php?r=" +
            (nombreUsuario == "paquete" ? "paquete" : "cliente") +
            "/update-estatus&id=" +
            idUsuario,
          type: "POST",
          data: {
            estado: nuevoEstado,
          },
          dataType: "json",
          cache: false,
          success: function (response) {
            if (response.status === "success") {
              Swal.fire({
                title: "¡Estado cambiado!",
                text: response.message,
                icon: "success",
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                title: "Error",
                text: response.message || "No se pudo cambiar el estado",
                icon: "error",
              });
            }
          },
        });
      }
    });
}

function mostrarAlertaTicket(idTicket) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger m-2",
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: "¿El operador AYUDO con la solución del Ticket?",
      text: "Marque si el operador ayudo con la solución del Ticket",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, ayudo!",
      cancelButtonText: "No ya esta solucionado el Ticket",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        mostrarAlertaCalificacion(idTicket);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $.ajax({
          url: "index.php?r=ticket/cerrar&id=" + idTicket,
          type: "GET",
          success: function (response) {
            Swal.fire({
              title: "¡Ticket cerrado!",
              text: "El ticket ha sido cerrado con éxito",
              icon: "success",
            }).then(() => {
              location.reload();
            });
          },
          error: function (response) {
            Swal.fire({
              title: "Error",
              text: response.message || "No se pudo cerrar el ticket",
              icon: "error",
            });
          },
        });
      }
    });
}
function openSweetAlert(id) {
  Swal.fire({
    title: "Comentario Resolución",
    html: `
          <input type="hidden" id="ticket-id" value="${id}"/>   
          <textarea id="ticket-descripcion" class="swal2-textarea" placeholder="Solución del Ticket"></textarea>
      `,
    showCancelButton: true,
    confirmButtonText: "Guardar",
    cancelButtonText: "Cancelar",
    preConfirm: () => {
      let id = document.getElementById("ticket-id").value;
      let descripcion = document.getElementById("ticket-descripcion").value;

      if (!id || !descripcion) {
        Swal.showValidationMessage("Todos los campos son obligatorios");
        return false;
      }
      window.location.href =
        "index.php?r=ticket/terminar-ticket&id=" +
        encodeURIComponent(id) +
        "&descripcion=" +
        encodeURIComponent(descripcion);
    },
  });
}

function cancelacionPaquete(id, idUsuario,rol) {
  Swal.fire({
    title: rol === "admin" ? "Motivo de rechazo" : "Motivo de cancelación",
    html: `
         <div class="alert alert-warning swal2-custom-alert">
                <h2><i class="bx bx-error-circle"></i> ADVERTENCIA</h2>
                <p>${rol === "admin" ? "Esta acción es irreversible y será registrada en el sistema. Por favor, asegúrese de que esta decisión es definitiva." : "Esta acción no puede revertirse. Si usted tiene más de 10 cancelaciones el administrador tomará asuntos con usted. Gracias ¿Estás seguro de continuar?"}</p>
          </div>
          <input type="hidden" id="pq-id" value="${id}"/>  
          <input type="hidden" id="pq-idUser" value="${idUsuario}"/> 
          <input type="hidden" id="pq-rol" value="${rol}"/> 
          <textarea id="pq-descripcion" class="form-control mt-3" 
          placeholder="Describe la razón de ${rol === "admin" ? "rechazo" : "cancelación"}(opcional)"
          rows="3" required></textarea>      `,
    showCancelButton: true,
    confirmButtonText: "Guardar",
    cancelButtonText: "Cancelar",
    preConfirm: () => {
      let id = document.getElementById("pq-id").value;
      let idUser = document.getElementById("pq-idUser").value;
      let descripcion = document.getElementById("pq-descripcion").value;
      let rol = document.getElementById("pq-rol").value;
      if (!id) {
        Swal.showValidationMessage("Todos los campos son obligatorios");
        return false;
      }

      direccion = rol === "admin" ? "solicitud" : "paquete";
      window.location.href =
        "index.php?r=paquete/cancelar-"+direccion+"&id=" +
        encodeURIComponent(id) +
        "&idUser=" +
        encodeURIComponent(idUser) +
        "&descripcion=" +
        encodeURIComponent(descripcion);
    },
  });
}

function mostrarAlertaCalificacion(idTicket) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger m-2",
    },
    buttonsStyling: false,
  });

  let rating = 0;

  swalWithBootstrapButtons
    .fire({
      title: "¿Desea calificar el servicio?",
      html: `
          <div class="star-rating-container">
              <div class="star-rating">
                  <i class="bx bx-star" data-value="1"></i>
                  <i class="bx bx-star" data-value="2"></i>
                  <i class="bx bx-star" data-value="3"></i>
                  <i class="bx bx-star" data-value="4"></i>
                  <i class="bx bx-star" data-value="5"></i>
              </div>
              <small id="rating-text" class="text-muted">Seleccione de 1 a 5 estrellas</small>
          </div>
      `,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Calificar",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
      didOpen: () => {
        const stars = document.querySelectorAll(".star-rating i");

        stars.forEach((star) => {
          star.addEventListener("mouseover", () => {
            const value = parseInt(star.getAttribute("data-value"));
            highlightStars(value);
          });

          star.addEventListener("mouseout", () => {
            if (!rating) {
              resetStars();
            } else {
              highlightStars(rating);
            }
          });

          star.addEventListener("click", () => {
            rating = parseInt(star.getAttribute("data-value"));
            document.getElementById(
              "rating-text"
            ).textContent = `Calificación seleccionada: ${rating} estrellas`;
          });
        });

        function highlightStars(value) {
          stars.forEach((s, index) => {
            s.classList.toggle("bxs-star", index < value);
            s.classList.toggle("bx-star", index >= value);
          });
        }

        function resetStars() {
          stars.forEach((star) => {
            star.classList.remove("bxs-star");
            star.classList.add("bx-star");
          });
        }
      },
    })
    .then((result) => {
      if (result.isConfirmed) {
        if (rating > 0) {
          $.ajax({
            url:
              "index.php?r=ticket/calificar&id=" +
              idTicket +
              "&calificacion=" +
              rating,
            type: "GET",
            success: function (response) {
              Swal.fire({
                title: "¡Gracias por tu calificación!",
                html: `Has calificado con <strong>${rating} estrellas</strong>`,
                icon: "success",
              }).then(() => {
                location.reload();
              });
            },
            error: function (response) {
              Swal.fire({
                title: "Error",
                text:
                  response.message || "No se pudo registrar la calificación",
                icon: "error",
              });
            },
          });
        } else {
          Swal.fire({
            title: "¡Calificación requerida!",
            text: "Por favor selecciona una calificación",
            icon: "error",
          });
        }
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: "¡Gracias!",
          text: "Tu calificación no ha sido registrada.",
          icon: "info",
        });
      }
    });
}
function mostrarCompra(idPaquete, idCliente) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger m-2",
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: "¿Estás seguro de comprar este paquete buenisimo?",
      text: " ¿Está actualmente comprado el paquete?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, comprar Ya!",
      cancelButtonText: "No, cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url:
            "index.php?r=cliente/comprar&id=" +
            idPaquete +
            "&cliente=" +
            idCliente,
          type: "GET",
          dataType: "json",
          cache: false,
          success: function (response) {
            if (response.status === "success") {
              Swal.fire({
                title: "¡Compra realizada!",
                text: response.message,
                icon: "success",
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                title: "Error",
                text: response.message || "No se pudo realizar la compra",
                icon: "error",
              });
            }
          },
        });
      }
    });
}
