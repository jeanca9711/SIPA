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
        <li class="nav-item active">
        <a class="nav-link" href="#">Formulario</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="estrategias.php">Estrategias</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="instructivo.php">Instructivo</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="verdatos.php">Ver Datos</a>
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
<!-- Body Pagina -->
<div class="container">
<div class="row">
  <div class="col-sm-2"></div>
  <div class="col-sm-8">
        <!-- Formulario -->
    <form action ="" method="post" <?php echo $_SERVER['PHP_SELF'];?> class="needs-validation" novalidate>
      <div class="form-group">
        <strong><label for="problema">Problema</label></strong>
        <input type="text" class="form-control" name="problema" placeholder="Digitar Problema" required>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <div class="form-group">
      <strong><label for="acc_mejoramiento">Acción de mejoramiento</label></strong>
        <input type="text" class="form-control" name="acc_mejoramiento" placeholder="Digitar Accion de Mejoramiento" required>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <div class="form-group">
      <strong><label for="proposito">Proposito</label></strong>
        <input type="text" class="form-control" name="proposito" placeholder="Digitar Proposito" required>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <div class="form-group">
      <strong><label for="estrategia">Estrategia</label></strong>
        <textarea class="form-control" name="estrategia" rows="3" placeholder="Digitar Estrategias" required></textarea>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <div class="form-group">
      <strong><label for="actividades">Actividades</label></strong>
        <textarea class="form-control" name="actividades" rows="3" placeholder="Digitar actividades" required></textarea>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <div class="form-group">
      <strong><label for="indicador">Indicador</label></strong>
        <input type="text" class="form-control" name="indicador" placeholder="Digitar Indicador" required>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <div class="form-group">
      <strong><label for="responsable">Responsable</label></strong>
        <input type="text" class="form-control" name="responsable" placeholder="Digitar Responsable" required>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <!-- Select Dependencia -->
      <div class="form-group">
      <strong><label for="dependencia">Dependencia</label></strong>
        <select  class="form-control" name="dependencia" placeholder="Digitar Dependencia" required>
        <option value=""></option>
        <!-- Inicio codigo llenar select dependencia -->
        <?php
            include('conexion.php'); //Llamamos la conexion a la BD
                        
              //$conec=oci_connect($user, $pass, 'localhost/xe');
              $consulta="select * from dependencia where DEPID>0";//Consulta select a la BD
              $ejecutar = oci_parse($conexion,$consulta);
                    
              oci_execute($ejecutar);//Ejecutamos codigo

              while($depend=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                echo "<option value='".$depend['DEPID'] ."'";  
                echo ">";
                echo $depend['DEPENDENCIA']; 
                echo "</option>";   
              }
              oci_free_statement($ejecutar);
        ?>
        <!-- Fin codigo llenar dependencia -->
        </select>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <div class="form-group">
      <strong><label for="periodicidad">Periodicidad</label></strong>
        <input type="text" class="form-control" name="periodicidad" placeholder="Digitar Periodicidad (Diario, Semanal, Mensual, etc)" required>
        <div class="valid-feedback">Completado.</div>
        <div class="invalid-feedback">Por favor complete el campo.</div>
      </div>
      <button type="submit" class="btn btn-success btn-lg btn-block" id="enviar">Enviar</button>
    </form>
    <!-- FIN Formulario -->
  </div>
  <div class="col-sm-2"></div>
</div>
</div>
<!-- FIN Body Pagina -->
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

<?php
error_reporting(E_ERROR | E_PARSE);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('conexion.php');

   $usuario1 = $_SESSION['usuario'];
   $problema = $_POST['problema'];
   $acc_mejoramiento = $_POST['acc_mejoramiento'];
   $proposito = $_POST['proposito'];
   $estrategia = $_POST['estrategia'];
   $actividades = $_POST['actividades'];
   $indicador = $_POST['indicador'];
   $responsable = $_POST['responsable'];
   $dependencia = $_POST['dependencia'];
   $periodicidad = $_POST['periodicidad'];

   //Consulta INSERTAR BD
   $formid1=oci_parse($conexion,"select max(formid) from pa_form");//Traemos el ultimo ID de PA_FORM
   oci_execute($formid1);//Ejecutamos codigo
   $formid2=oci_fetch_array($formid1,OCI_NUM); //Traemos el id form
   $err_formid=oci_error($formid1); //Devolvemos Error
   print_r($err_formid); //Imprimimos error
   $formid3=$formid2[0]; //Almacenamos el ID consultado en la variable
   $formid=$formid3+1;//Sumamos 1+ para el nuevo ID

   $usuario2=oci_parse($conexion,"select USERID from USUARIOS where EMAIL=upper ('$usuario1')");// Traemos el ID del usuario
   oci_execute($usuario2);//Ejecutamos codigo
   $err_usu=oci_error($usuario2); //Devolvemos Error
   print_r($err_usu); //Imprimimos error
   $usuario3=oci_fetch_array($usuario2,OCI_NUM); //Traemos el id de usuario
   $usuario=$usuario3[0]; //Almacenamos el ID consultado en la variable
   $consulta="insert into PA_FORM values ($formid,upper('$problema'), upper('$acc_mejoramiento'), upper('$proposito'), upper('$estrategia'),
                                         upper('$actividades'), upper('$indicador'), upper('$responsable'), $dependencia, upper('$periodicidad'),
                                         $usuario, SYSDATE)"; // Consulta Insertar PA_FORM
   $ejecutar = oci_parse($conexion,$consulta);
   oci_execute($ejecutar);//Ejecutamos codigo
   $error=oci_error($ejecutar); //Devolvemos Error
   
   if ($error) {
      print_r($error);//Imprimimos error
   }else{
     //Alerta
        echo "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>¡Completado!</strong> Los datos se han guardado correctamente.
              </div>";
   }
   //Limpiamos statement
   oci_free_statement($ejecutar);
   oci_free_statement($usuario2);
   oci_free_statement($usuario3);
   oci_free_statement($err_usu);
   oci_free_statement($err_formid);
   oci_free_statement($formid1);
   oci_free_statement($formid2);
   oci_free_statement($error);
   oci_close($conexion); //Cerramos conexion
}
?>
<div class="espacio-sm">

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