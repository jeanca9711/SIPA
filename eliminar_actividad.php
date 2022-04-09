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
 if(isset($_GET['AId']))
 {
     $id=$_GET['AId'];
     $id2=$_GET['ID'];
     $consulta="update paactividades set state='INACTIVO' Where id=$id";
     $ejecutar = oci_parse($conexion,$consulta);
                     
     oci_execute($ejecutar);//Ejecutamos codigo
 ?>
<script language='javascript'>
 alert('Registro Eliminado');
 window.location="index.php?op=3&ID=<?php echo $id2; ?>";
</script>

<?php
 
  }//end if
 ?>