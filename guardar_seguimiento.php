<?php
session_start();
date_default_timezone_set('America/Bogota');

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
if (isset($_POST['pavance']))
{
    $usuario1=$_SESSION['usuario'];
    $id=$_POST['id'];
    $fecha=date('Y-m-d');
    $pavance=$_POST['pavance'];

    // TRAER ULTIMO CUMPLIMIENTO TOTAL
    $consulta="select * from paseguimiento a where a.FORMID=$id and a.IDSEGUIMIENTO=(select max(IDSEGUIMIENTO) from paseguimiento)";
    $ejecutar = oci_parse($conexion,$consulta);

    oci_execute($ejecutar);//Ejecutamos codigo
    $lastporcentajes=null;
    if($row=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS))
    {
        $lastporcentajes=$row['CUMPLIMIENTO_TOTAL'];
    }
    
    if($lastporcentajes==null) $lastporcentaje=0;
        else $lastporcentaje=$lastporcentajes;

    $cumplimientototal=$lastporcentaje+$pavance;
    
    

  //Consulta INSERTAR BD
  //Traer ultimo id form
  $formid1=oci_parse($conexion,"select max(IDSEGUIMIENTO) as id from PASEGUIMIENTO");//Traemos el ultimo ID de PA_FORM
  oci_execute($formid1);//Ejecutamos codigo
  $formid2=oci_fetch_array($formid1,OCI_NUM); //Traemos el id form
  $err_formid=oci_error($formid1); //Devolvemos Error
  print_r($err_formid); //Imprimimos error
  $formid3=$formid2[0]; //Almacenamos el ID consultado en la variable
  $formid=$formid3+1;//Sumamos 1+ para el nuevo ID

  //Traer id USUARIO
   $usuario2=oci_parse($conexion,"select USERID from usuarios where EMAIL=upper ('$usuario1')");// Traemos el ID del usuario
   oci_execute($usuario2);//Ejecutamos codigo
   $err_usu=oci_error($usuario2); //Devolvemos Error
   print_r($err_usu); //Imprimimos error
   $usuario3=oci_fetch_array($usuario2,OCI_NUM); //Traemos el id de usuario
   $usuario=$usuario3[0]; //Almacenamos el ID consultado en la variable
    

    $consulta="insert into PASEGUIMIENTO values ($formid, $pavance, $cumplimientototal, SYSDATE, $id, $usuario)";
    $ejecutar = oci_parse($conexion,$consulta);
    oci_execute($ejecutar);//Ejecutamos codigo
    $error=oci_error($ejecutar); //Devolvemos Error

    
    if ($error) {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Error!</strong>.Error al guardar. ". print_r($error) ."
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
   oci_free_statement($formid1);
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
   
}//end if
?>