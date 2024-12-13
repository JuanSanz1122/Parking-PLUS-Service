document.getElementById("form-login").addEventListener("submit", function(event) {
  const correo = document.getElementById("correo").value;
  const contrasena = document.getElementById("contrasena").value;

  // Validar que el correo no esté vacío
  if (!correo) {
      Swal.fire({
          icon: "warning",
          title: "Correo vacío",
          text: "Por favor, ingresa tu correo electrónico.",
      });
      event.preventDefault(); // Detener el envío del formulario
      return;
  }

  // Validar que el correo contenga una "@"
  if (!correo.includes("@")) {
      Swal.fire({
          icon: "error",
          title: "Correo no válido",
          text: "El correo debe contener '@'.",
      });
      event.preventDefault(); // Detener el envío del formulario
      return;
  }

  // Validar que la contrasena no esté vacía
  if (!contrasena) {
      Swal.fire({
          icon: "warning",
          title: "Contrasena vacía",
          text: "Por favor, ingresa tu contrasena.",
      });
      event.preventDefault(); // Detener el envío del formulario
      return;
  }

  // Validación de la contrasena (mínimo 8 caracteres y al menos una mayúscula)
  const passwordRegex = /^(?=.*[A-Z]).{8,}$/; // Al menos 1 mayúscula y mínimo 8 caracteres
  if (!passwordRegex.test(contrasena)) {
      Swal.fire({
          icon: "error",
          title: "Contrasena inválida",
          text: "La contrasena debe tener al menos 8 caracteres y una letra mayúscula.",
      });
      event.preventDefault(); // Detener el envío del formulario
      return;
  }

  // Si todo es correcto, mostrar mensaje de inicio de sesión y redirigir
  Swal.fire({
      icon: "success",
      title: "Sesión iniciada",
      text: "Redirigiendo al inicio...",
      timer: 1500, // Duración del mensaje antes de redirigir
      showConfirmButton: false,
      willClose: () => {
          window.location.href = "index.html";
      },
  });

  return true;
});
