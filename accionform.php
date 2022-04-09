<?php
session_start();
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
   $consulta="insert into PA_FORM values ($formid,'$problema', '$acc_mejoramiento', '$proposito', '$estrategia',
                                         '$actividades', '$indicador', '$responsable', $dependencia, '$periodicidad',
                                         $usuario, SYSDATE)"; // Consulta Insertar PA_FORM
   $ejecutar = oci_parse($conexion,$consulta);
   oci_execute($ejecutar);//Ejecutamos codigo
   $error=oci_error($ejecutar); //Devolvemos Error
   
   if ($error) {
      print_r($error);//Imprimimos error
   }else{
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
               <strong>¡Completado!</strong> Los datos se han guardado satisfactoriamente.
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span>
               </button>
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

?>