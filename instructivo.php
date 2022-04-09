<?php
session_start();

//Tiempo de Caducidad
//Comprobamos si esta definida la sesión 'tiempo'.
if(isset($_SESSION['tiempo']) ) {

  //Tiempo en segundos para dar vida a la sesión.
  $inactivo = 7200;//20min en este caso.

  //Calculamos tiempo de vida inactivo.
  $vida_session = time() - $_SESSION['tiempo'];

      //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
      if($vida_session > $inactivo)
      {
          session_unset();
          echo "<script>alert('Su sesión ha caducado');
          </script>";            
          //Redirigimos pagina.
          header("Location:cerrar_sesion.php");

          exit();
      }

}
$_SESSION['tiempo'] = time();

$varsesion= $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
  echo "<script>alert('Usted no esta autorizado para ver este sitio');
        '</script>";
  header('location:login.php');
  die();
}
include('conexion.php');

$usuario2=oci_parse($conexion,"select * from usuarios where EMAIL=upper ('$varsesion')");// Traemos el ID del usuario
oci_execute($usuario2);//Ejecutamos codigo
if($row=oci_fetch_array($usuario2,OCI_ASSOC+OCI_RETURN_NULLS)){
  $uid=$row['USERID'];
  $tipou=$row['TIPOUSUARIO_ID'];
  $usucursal=$row['SUCURSAL'];
  $nombresu=$row['NOMBRES']. ' '. $row['APELLIDOS'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIPA-Instructivo</title>
    <!-- Bootstrap 4 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Place your kit's code here -->
    <script src="https://kit.fontawesome.com/d0d4b813b2.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="row">
  <!-- Icono -->
  <div class="col-sm-2"><!-- Col 2 -->
  <a class="navbar-brand" href="#">
    <img src="img/logo.png" alt="logo" style="width:150px;">
  </a>
  </div>
  <div class="col-sm-10"><!-- Col 10 -->
    <?php echo '<h3 style="text-align:right; padding:16px;">Bienvenido '. $varsesion . '</h1>'; ?>
  </div>
</div>
<!-- Barra de Navegacion -->
<nav class="navbar navbar-expand-sm bg-success navbar-dark sticky-top">
    <!-- Links -->
    <a class="navbar-brand" href="#">SIPA - AMBUQ</a>
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="index.php?op=1"><i class="fa fa-wpforms"></i> Formulario</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="estrategias.php"><i class="fa fa-project-diagram"></i> Estrategias</a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="instructivo.php"><i class="fa fa-file-pdf"></i> Instructivo</a>
        </li>
        <?php if($tipou == 1){ ?>
        <li class="nav-item">
        <a class="nav-link" href="index.php?op=7"><i class="fa fa-chart-bar"></i> Reportes</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="index.php?op=8"><i class="fa fa-exclamation-triangle"></i> Eventos materializados</a>
        </li> 
        <?php } ?>
        </ul>
        <ul class="navbar-nav  ml-auto">
          <li class="nav-item">
            <a class="btn btn-outline-warning" href="cerrar_sesion.php" role="button">Cerrar Sesión</a>
          </li>
        </ul>
</nav>
<!-- FIN Barra de Navegacion -->
<div style="padding: 25px;">
        
</div>
<!-- Body pagina -->
<div class="container">
<iframe src="http://10.244.20.4:89/sipa/pdf/Instructivo_aplicativo_SIPA_V2.0.pdf" width="100%" height="680px"></iframe>
</div>
</body>
<!-- Footer -->
<footer id="sticky-footer" class="py-4 bg-success text-white">
    <div class="container text-center">
    <strong>Gerencia de Riesgos</strong><br>
      <small>Copyright &copy; AMBUQ 2019</small>
      <p style="font-size:10px;">Jean C. Del Portillo</p>
    </div>
</footer>
<!-- FIN Footer -->