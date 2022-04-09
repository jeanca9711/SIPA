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
?>

<?php
 include('conexion.php');
 if(isset($_POST['problema']))
 {
    $id=$_POST['id'];
    $pro=$_POST['problema'];  
    $accmejo=$_POST['accmejoramiento']; 
    $prop=$_POST['proposito'];
    $estr=$_POST['estrategia'];
    $ind=$_POST['indicador'];
    $resp=$_POST['responsable'];
    $dep=$_POST['dependencia'];
    $per=$_POST['periodicidad'];
    $metageneral=$_POST['mgeneral'];
    $lineabase=$_POST['lineabase'];
    $riesgo=$_POST['riesgo'];
    $usuario1 = $_SESSION['usuario'];
    $fech=$_POST['fecha'];

        //Traer id USUARIO
    $usuario2=oci_parse($conexion,"select USERID from USUARIOS where EMAIL=upper ('$usuario1')");// Traemos el ID del usuario
    oci_execute($usuario2);//Ejecutamos codigo
    $err_usu=oci_error($usuario2); //Devolvemos Error
    print_r($err_usu); //Imprimimos error
    $usuario3=oci_fetch_array($usuario2,OCI_NUM); //Traemos el id de usuario
    $usuario=$usuario3[0]; //Almacenamos el ID consultado en la variable


     $consulta="update PAFORM set PROBLEMA=UPPER('$pro'),ACC_MEJORAMIENTO=UPPER('$accmejo'),PROPOSITO=UPPER('$prop'),ESTRATEGIA=UPPER('$estr'),INDICADOR=UPPER('$ind'),RESPONSABLE=UPPER('$resp'),DEPID=$dep,PERIODICIDAD=$per,USERID=$usuario, META_GENERAL=$metageneral, LINEA_BASE=$lineabase, IDRIESGO=$riesgo 
     where id=$id";
     $ejecutar = oci_parse($conexion,$consulta);
     oci_execute($ejecutar);//Ejecutamos codigo
     $error=oci_error($ejecutar); //Devolvemos Error

    if ($error) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong>.Error al guardar. ".print_r($error)."
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }else{
        //Alerta
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Completado!</strong> Registro guardado con exito.
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
              </button>
            </div>";
      }
      //Limpiamos statement
     oci_free_statement($ejecutar);
     oci_free_statement($usuario2);
     oci_close($conexion); //Cerramos conexion
}
 ?>
 