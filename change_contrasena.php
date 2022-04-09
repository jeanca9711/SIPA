<?php
session_start();

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
if (isset($_POST['ccontrasena']))
{
    $acontrasena=$_POST['acontrasena'];
    $ncontrasena=$_POST['ncontrasena'];
    $ccontrasena=$_POST['ccontrasena'];
    $usuario1 = strtoupper($_SESSION['usuario']);

    if($ncontrasena != $ccontrasena){
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Error!</strong>. las contraseñas no coinciden.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }else{
    
      $consulta2="SELECT * FROM usuarios a WHERE a.contrasena='$acontrasena' AND a.email='$usuario1'";//Consulta select a la BD
      $ejecutar2 = oci_parse($conexion,$consulta2);
      oci_execute($ejecutar2);//Ejecutamos codigo
      $row=oci_fetch_array($ejecutar2,OCI_ASSOC+OCI_RETURN_NULLS);
      if($row2==null){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Error!</strong>.La antigua contraseña es incorrecta.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
      }else{
      //Consulta ACTUALIZAR USUARIO

      //Traer id USUARIO
      $usuario2=oci_parse($conexion,"SELECT USERID FROM usuarios WHERE EMAIL='$usuario1'");// Traemos el ID del usuario
      oci_execute($usuario2);//Ejecutamos codigo
      $err_usu=oci_error($usuario2); //Devolvemos Error
      print_r($err_usu); //Imprimimos error
      $usuario3=oci_fetch_array($usuario2,OCI_NUM); //Traemos el id de usuario
      $usuario=$usuario3[0]; //Almacenamos el ID consultado en la variable

        $consulta="UPDATE USUARIOS A SET A.CONTRASENA='$ncontrasena' WHERE A.USERID='$usuario'";
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


    /*
        if ($mysqli->affected_rows>0) {
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Completado!</strong> Registro guardado con exito.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
        }else{
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Error al guardar.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
        }
    */
    } 
  }
}//end if
?>