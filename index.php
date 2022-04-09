<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

date_default_timezone_set('America/Bogota');// ZONA HORARIA
//Tiempo de Caducidad
//Comprobamos si esta definida la sesión 'tiempo'.
if(isset($_SESSION['tiempo']) ) {

  //Tiempo en segundos para dar vida a la sesión.
  $inactivo = 7200;//2h en este caso.

  //Calculamos tiempo de vida inactivo.
  $vida_session = time() - $_SESSION['tiempo'];

      //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
      if($vida_session > $inactivo)
      {
          session_unset();            
          //Redirigimos pagina.
          echo "<script>alert('Su sesión ha caducado');
        </script>";
          header("Location:cerrar_sesion.php");

          exit();
      }

}
$_SESSION['tiempo'] = time();


$varsesion= $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
  echo "<script>alert('Usted no esta autorizado para ver este sitio');
        </script>";
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
    <title>SIPA - AMBUQ</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <!-- TABLA -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- para exportar -->
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    
    <!-- Bootstrap 4 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
    
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
  <div class="col-sm-9"><!-- Col 10 -->
    <?php echo '<h3 style="text-align:right; padding:16px;">Bienvenido '. $nombresu . '</h1>'; ?>
  </div>
  <div class="col-sm-1">
    <button type="button"  class="btn btn-outline-info mt-2" data-toggle="modal" data-target="#ContrasenamodalForm"  title="Cambiar Contraseña">
      <i class="fa fa-key fa-lg"></i>
    </button>
    <!-- <button type="button"  class="btn btn-outline-info mt-2" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Opción no disponible :(">
      <i class="fa fa-key fa-lg"></i>
    </button> -->
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
        <li class="nav-item">
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
<!-- Body Pagina -->
<!-- Begin Page Content -->

        <?php
            if(isset($_GET['op']))
            {
              $op=$_GET['op']; 
              switch($op)
              {
                  case 1: $page='paview.php';break;
                  case 2: $page='editar.php';break;
                  case 3: $page='actividades.php';break;
                  case 4: $page='editar_actividad.php';break;
                  case 5: $page='seguimientos.php';break;
                  case 6: $page='ver_seguimientos.php';break;
                  case 7: $page='reportes.php';break;
                  case 8: $page='eventos.php';break;
                  case 9: $page='editar_evento.php';break;
              }  
            }else{
              $page='paview.php';
            }

            include($page);
            include('cambiar_contrasena.php');
        ?>

</body>
</html>

<script type="text/javascript">

$(function () {
  $('[data-toggle="popover"]').popover()
})

</script>