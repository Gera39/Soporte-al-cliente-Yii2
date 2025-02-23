



// document.addEventListener("DOMContentLoaded", function() {
//     // Verifica si el modal ya fue mostrado
  
//         // Si no ha sido mostrado, lo muestra
//         var myModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
//         myModal.show();

     
    
// });


 
document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll(".btn-check");
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("focus", function(event) {
            event.preventDefault(); // Evita que el navegador realice el scroll
        });
    });
});
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})







// if(window.innerWidth < 768) {
// 	sidebar.classList.add('hide');
// } else if(window.innerWidth > 576) {
// 	searchButtonIcon.classList.replace('bx-x', 'bx-search');
// 	searchForm.classList.remove('show');
// }


// window.addEventListener('resize', function () {
// 	if(this.innerWidth > 576) {
// 		searchButtonIcon.classList.replace('bx-x', 'bx-search');
// 		searchForm.classList.remove('show');
// 	}
// })



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {

		
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})


// // Esta función se encargará de hacer la solicitud AJAX
// function loadContent(page) {
// 	// Usamos XMLHttpRequest para realizar la petición AJAX
// 	var xhr = new XMLHttpRequest();
// 	xhr.open("GET", page, true);

// 	// Definir lo que debe hacer cuando la solicitud esté lista
// 	xhr.onload = function() {
// 		if (xhr.status == 200) {
// 			// Si la solicitud fue exitosa, cambiamos el contenido
// 			document.getElementById("main-content").innerHTML = xhr.responseText;
// 		}
// 	};

// 	// Enviar la solicitud
// 	xhr.send();
// }

// function loadContent(page) {
// 	let loaderSection = document.querySelector('.loader-section');
//         loaderSection.style.display = 'flex';
//     var xhr = new XMLHttpRequest();
//     xhr.open("GET", page, true);
	
//     xhr.onload = function() {
//         if (xhr.status == 200) {
//             var mainContent = document.getElementById("main-content");
//             mainContent.innerHTML = xhr.responseText;

//             // Evalúa cualquier script del contenido cargado
//             var scripts = mainContent.getElementsByTagName("script");
//             for (var i = 0; i < scripts.length; i++) {
//                 eval(scripts[i].innerText); // Ejecuta el script
//             }
//         }
//     };

//     xhr.send();
// }

function obtenerUbicacionUsuario() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Enviar la ubicación al servidor PHP usando AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../Conexion/obtenerUbicacion.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    
                    if (response) {
                        document.getElementById("direccion").value = response.direccion || ''; 
                        document.getElementById("estado").value = response.estado || ''; 
                    } else {
                        alert("No se pudo obtener la información de la ubicación.");
                    }
                }
            };
            xhr.send("latitud=" + lat + "&longitud=" + lon);
        });
    } else {
        alert("Geolocalización no soportada por este navegador.");
    }
}

function loadContent(page) {
    let loaderSection = document.querySelector('.loader-section');
    loaderSection.style.display = 'flex'; // Mostrar el loader

    var xhr = new XMLHttpRequest();
    xhr.open("GET", page, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var mainContent = document.getElementById("main-content");
            mainContent.innerHTML = xhr.responseText;

            // Ocultar el loader después de que se haya cargado el contenido
            loaderSection.style.display = 'none';

            // Evalúa cualquier script del contenido cargado
            var scripts = mainContent.getElementsByTagName("script");
            for (var i = 0; i < scripts.length; i++) {
                eval(scripts[i].innerText); // Ejecuta el script
            }
        } else {
            // Ocultar el loader en caso de error
            loaderSection.style.display = 'none';
            alert("Error al cargar la página: " + xhr.statusText);
        }
    };

    xhr.onerror = function() {
        // Ocultar el loader en caso de error de red
        loaderSection.style.display = 'none';
        alert("Ocurrió un error de red.");
    };

    xhr.send(); // Enviar la solicitud
}


