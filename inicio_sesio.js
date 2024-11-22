document.getElementById("form-login").addEventListener("submit", function(event) {
    const correo = document.getElementById("correo").value;
    const contraseña = document.getElementById("contraseña").value;

    // Validar que el correo no esté vacío
    if (!correo) {
      alert("Por favor, ingresa tu correo electrónico.");
      event.preventDefault();  // Detener el envío del formulario
      return;
    }

    // Validar que el correo contenga una "@"
    if (!correo.includes("@")) {
      alert("Correo no valido");
      event.preventDefault();
      return;
    }

    // Validar que la contraseña no esté vacía
    if (!contraseña) {
      alert("Por favor, ingresa tu contraseña.");
      event.preventDefault();
      return;
    }

    // Validación de la contraseña (mínimo 8 caracteres y al menos una mayúscula)
    const passwordRegex = /^(?=.*[A-Z]).{8,}$/; // Al menos 1 mayúscula y mínimo 8 caracteres
    if (!passwordRegex.test(contraseña)) {
      alert("Contraseña incorrecta");
      event.preventDefault();  // Detener el envío del formulario
      return;
    }

    // Si todo es correcto, puedes proceder con el envío del formulario
    alert("Sesion Iniciada");
    
    // Redirigir a index.html después de 1 segundo
    setTimeout(function() {
    window.location.href = "index.html";
    }, 1000); // Redirigir después de 1 segundo
    return true;
  });