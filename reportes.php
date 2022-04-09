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

$usuario2=oci_parse($conexion,"select * from usuarios where EMAIL=upper ('$varsesion')");// Traemos el ID del usuario
oci_execute($usuario2);//Ejecutamos codigo
if($row=oci_fetch_array($usuario2,OCI_ASSOC+OCI_RETURN_NULLS)){
  $uid=$row['USERID'];
  $tipou=$row['TIPOUSUARIO_ID'];
  $usucursal=$row['SUCURSAL'];
  $nombresu=$row['NOMBRES']. ' '. $row['APELLIDOS'];
}

if ($tipou <> 1) {
    echo "<script>alert('Usted no esta autorizado para ver este sitio');
          </script>";
    header('location:index.php?op=1');
    die();
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
<div class="container-fluid">

<script language="javascript">
    $(document).ready(function() {
        $('#tform').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        'excelHtml5',
        'csvHtml5',
        ]
      } );
    } );
  </script>

<h1 class="text-center">Reportes</h1>
<div class="card mb-3" style="max-width: 18rem;">
  <div class="card-header text-white text-center bg-success"><b>Exportar Planes de Acción</b></div>
  <div class="card-body">
    
    <p class="card-text text-center"><a href="exportformxlsx.php" class="btn btn-success"><i class="fa fa-file-excel"></i> Exportar</a></p>
  </div>
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
</html>