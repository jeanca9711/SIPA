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
 if(isset($_POST['id']))
 {
     $id=$_POST['id'];
     $actividad=$_POST['actividad'];
     $fechae=$_POST['fechae'];
     $entregable=$_POST['entregable'];
     $fechac=$_POST['fechac'];
     $observaciones=$_POST['observaciones'];
     $estado=$_POST['estado'];
     $idform=$_POST['idform'];

     /*   //Traer id USUARIO
    $usuario2=oci_parse($conexion,"select id from AOUSUARIOS where UEMAIL=upper ('$usuario1')");// Traemos el ID del usuario
    oci_execute($usuario2);//Ejecutamos codigo
    $err_usu=oci_error($usuario2); //Devolvemos Error
    print_r($err_usu); //Imprimimos error
    $usuario3=oci_fetch_array($usuario2,OCI_NUM); //Traemos el id de usuario
    $usuario=$usuario3[0]; //Almacenamos el ID consultado en la variable */


     $SQL="update PAACTIVIDADES set ACTIVIDAD=UPPER('$actividad'), FECHA_ENTREGA=TO_DATE('$fechae', 'YYYY-MM-DD'),ENTREGABLE=UPPER('$entregable'),".
     "FECHA_CIERRE=TO_DATE('$fechac', 'YYYY-MM-DD'), OBSERVACION='$observaciones', PAESTADOS_ID=$estado".
     "where id=$id and state='ACTIVO'";
     $ejecutar = oci_parse($conexion,$SQL);
     oci_execute($ejecutar);//Ejecutamos codigo
     $error=oci_error($ejecutar); //Devolvemos Error

    if ($error) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong>.Error al actualizar. ".print_r($error)."
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }else{
        //Alerta
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Completado!</strong> Registro actualizado con exito.
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
              </button>
            </div>";
      }
      //Limpiamos statement
     oci_free_statement($ejecutar);
     //oci_free_statement($usuario2);
     oci_close($conexion); //Cerramos conexion
}
 ?>
 