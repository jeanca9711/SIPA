<?php
session_start();

//Tiempo de Caducidad
//Comprobamos si esta definida la sesión 'tiempo'.
if(isset($_SESSION['tiempo']) ) {

  //Tiempo en segundos para dar vida a la sesión.
  $inactivo = 1200;//20min en este caso.

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
        </script>";
  header('location:login.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIPA-AMBUQ</title>
    <!-- Bootstrap 4 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
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
        <a class="nav-link" href="index.php">Formulario</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="estrategias.php">Estrategias</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="instructivo.php">Instructivo</a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="#">Ver Datos</a>
        </li>
        </ul>
        <ul class="navbar-nav  ml-auto">
          <li class="nav-item">
          <a class="btn btn-outline-warning" href="cerrar_sesion.php" role="button">Cerrar Sesión</a>
          </li>
        </ul>
</nav>
<!-- FIN Barra de Navegacion -->
<div class="espacio-sm">
        
</div>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4" style="padding-left:150px">
            <a class="btn btn-success btn-lg" href="exportexcel.php" role="button"><strong>Exportar a excel</strong></a>
    </div>
    <div class="col-sm-4"></div>
</div>
<div class="espacio-sm">
        
</div>
<div class="container-fluid">
            <table class="table table-hover table-sm" id="tbformulario">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">FORMID</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">PROBLEMA</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">ACCION DE MEJORAMIENTO</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">PROPOSITO</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">ESTRATEGIA</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">ACTIVIDADES</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">INDICADOR</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">RESPONSABLE</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">DEPENDENCIA</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">PERIODICIDAD</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">USUARIO</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">SUCURSAL</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">FECHA</p></th>
                    </tr>
                </thead>
                <!-- Llenamos Tabla Formulario -->
                <?php
                    include('conexion.php'); //Llamamos la conexion a la BD
                                
                    //$conec=oci_connect($user, $pass, 'localhost/xe');
                    $consulta="select * from DATA_FORM";//Consulta select a la BD
                    $ejecutar = oci_parse($conexion,$consulta);
                            
                    oci_execute($ejecutar);//Ejecutamos codigo
                    while($data=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                        echo "<tr>";  
                        echo "<th scope='row'>".$data['FORMID']."</th>";
                        echo "<td>".$data['PROBLEMA']."</td>";
                        echo "<td>".$data['ACC_MEJORAMIENTO']."</td>";
                        echo "<td>".$data['PROPOSITO']."</td>";
                        echo "<td>".$data['ESTRATEGIA']."</td>";
                        echo "<td>".$data['ACTIVIDADES']."</td>";
                        echo "<td>".$data['INDICADOR']."</td>";
                        echo "<td>".$data['RESPONSABLE']."</td>";
                        echo "<td>".$data['DEPENDENCIA']."</td>";
                        echo "<td>".$data['PERIODICIDAD']."</td>";
                        echo "<td>".$data['USUARIO']."</td>";
                        echo "<td>".$data['SUCURSAL']."</td>";
                        echo "<td>".$data['FECHA']."</td>";
                        echo "</tr>";
                    }
                    //Limpiamos statement
                    oci_free_statement($ejecutar);
                    oci_close($conexion); //Cerramos conexion
                ?>
            </table>
</div>
</body>