const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
//dinputs de password 


registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

document.getElementById('createForm').addEventListener('submit', function(event) {
    // Obtener los valores de los campos de contraseña
    const password = document.getElementById('contrasena').value;
    const confirmPassword = document.getElementById('contrasenaV').value;
    
    // Verificar si las contraseñas coinciden
    if (password !== confirmPassword) {
      // Si no coinciden, evitar el envío del formulario
      event.preventDefault();
  
      // Mostrar el mensaje de error
      document.getElementById('error-message').style.display = 'block';
    } else {
      // Si coinciden, ocultar el mensaje de error (si es necesario)
      document.getElementById('error-message').style.display = 'none';
    }
  });