<?php
session_start();
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if ($varsesion != null || $varsesion != '') {
  header('location:index.php?op=1');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar Sesión SIPA-AMBUQ</title>
    <!-- Bootstrap 4 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<body>
<!-- Body Pagina -->
<div class="container">
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-5">
      <div class="espacio">
        
      </div>
      <div class="jumbotron">
        <div class="row">
          <div class="col-sm-3"></div>
          <div class="col-sm-4">
            <img src="img/logo.png" alt="logo" style="width:150px;">
          </div>
          <div class="col-sm-4"></div>
        </div>
      <h2 class="text-center">Iniciar Sesión</h2>
      <hr class="my-4">
      <div class="contenedor">
          <!-- Inicio de Formulario-->
          <form action ="validar.php" method="post" class="needs-validation" novalidate>
              <div class="form-group">
              <strong><label for="usuario">Usuario</label></strong>
              <input type="email" class="form-control" name="usuario" placeholder="Ingrese su correo electrónico" required>
              <div class="valid-feedback">Completado.</div>
              <div class="invalid-feedback">Por favor escriba una direccion email correcta.</div>
              </div>
              <div class="form-group">
              <strong><label for="contrasena">Contraseña</label></strong>
              <input type="password" class="form-control" name="contrasena" placeholder="Ingrese su contraseña" required>
              <div class="valid-feedback">Completado.</div>
              <div class="invalid-feedback">Por favor complete el campo.</div>
              </div>
              <button type="submit" class="btn btn-success btn-sm">Iniciar Sesión</button>
              <button type="submit" class="btn btn-link btn-sm">¿Olvidaste tu contraseña?</button>
          </form>
          <!-- FIN de Formulario-->
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>
</div>
</body>
<!-- Script Validar Vacio Formulario -->
<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<!-- FIN Script Validar Vacio Formulario -->
</html>