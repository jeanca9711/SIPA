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
if (isset($_POST['proceso']))
{
    $cuantia='null';
    $cuantia_recuperada='null';
    $cuantia_seguro='null';

    $proceso=strtoupper($_POST['proceso']);
    $fecha_descubrimiento=$_POST['fecha_descubrimiento'];
    $fecha_inicio=$_POST['fecha_inicio'];
    $fecha_finalizacion=$_POST['fecha_finalizacion'];
    $evento=strtoupper($_POST['evento']);
    $producto=strtoupper($_POST['producto']);
    $clase_evento=$_POST['clase_evento'];
    $tipo_perdida=$_POST['tipo_perdida'];
    $divisa='COP';
    if (isset($_POST['cuantia'])){ //validar cuantia >0
        $cuantia=$_POST['cuantia'];
        if($cuantia<=0){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>. La '<i>Cuantía</i>' debe ser mayor a <b>0</b>.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return;
        }
    } 
    if (isset($_POST['cuantia_recuperada'])){ //validar cuantia_recuperada >0
        $cuantia_recuperada=$_POST['cuantia_recuperada'];
        if($cuantia_recuperada<=0){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>. La '<i>Cuantía total recuperada</i>' debe ser mayor a <b>0</b>.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return;
        }
    } 
    if (isset($_POST['cuantia_seguro'])){ //validar cuantia_seguro >0
        $cuantia_seguro=$_POST['cuantia_seguro'];
        if($cuantia_seguro<=0){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>. La '<i>Cuantía recuperada por seguros</i>' debe ser mayor a <b>0</b>.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return;
        }
    }
    $cuentas=$_POST['cuentas'];
    $fecha_contabilizacion=$_POST['fecha_contabilizacion'];
    $usuario1=$_SESSION['usuario'];
    
    // conversion a tipo fecha
    $f_d = date_create($fecha_descubrimiento);
    $f_i = date_create($fecha_inicio);
    $f_f = date_create($fecha_finalizacion);
    $f_c = date_create($fecha_contabilizacion);

    if($cuentas<0){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>¡Error!</strong>. La '<i>Cuentas del plan de cuentas afectadas</i>' debe ser mayor o igual a <b>0</b>.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
        return;
    }  

    if ($f_i>$f_d){ // validacion fecha inicio vs fecha descubrimiento
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>. La '<i>fecha de inicio</i>' debe ser menor a la  '<i>fecha de descubrimiento</i>'.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
    }elseif($f_f<$f_i){ // validacion fecha fin vs fecha inicio
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>. '<i>La fecha de inicio</i>' debe ser menor a la '<i>fecha de finalización</i>'.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
    }elseif($f_c<$f_d){ // validacion fecha contabilizacion vs fecha descubrimiento
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>. La '<i>fecha de contabilización</i>' debe ser mayor '<i>fecha de descubrimiento</i>'.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
    }elseif($f_f<$f_d){ // validacion fecha contabilizacion vs fecha descubrimiento
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>. La '<i>fecha de finalización</i>' debe ser mayor '<i>fecha de descubrimiento</i>'.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
    }else{ // Si todas las fechas estan bien

        //Consulta INSERTAR BD
        //Traer ultimo id form
        $formid1=oci_parse($conexion,"SELECT MAX(id) FROM paeventos");//Traemos el ultimo ID de PA_FORM
        oci_execute($formid1);//Ejecutamos codigo
        $formid2=oci_fetch_array($formid1,OCI_NUM); //Traemos el id form
        $err_formid=oci_error($formid1); //Devolvemos Error
        print_r($err_formid); //Imprimimos error
        $formid3=$formid2[0]; //Almacenamos el ID consultado en la variable
        $formid=$formid3+1;//Sumamos 1+ para el nuevo ID

        //Traer id USUARIO
        $usuario2=oci_parse($conexion,"SELECT USERID FROM usuarios WHERE EMAIL=UPPER('$usuario1')");// Traemos el ID del usuario
        oci_execute($usuario2);//Ejecutamos codigo
        $err_usu=oci_error($usuario2); //Devolvemos Error
        print_r($err_usu); //Imprimimos error
        $usuario3=oci_fetch_array($usuario2,OCI_NUM); //Traemos el id de usuario
        $usuario=$usuario3[0]; //Almacenamos el ID consultado en la variable

        // CALCULAMOS CONSECUTIVO DE REFERENCIA
        $ref1=oci_parse($conexion,"SELECT MAX(to_number(substr(referencia,3,6))) AS referencia FROM paeventos");//Traemos el ultimo ID de PA_FORM
        oci_execute($ref1);//Ejecutamos codigo
        $ref2=oci_fetch_array($ref1,OCI_NUM); //Traemos el id form
        $err_ref1=oci_error($ref1); //Devolvemos Error
        print_r($err_ref1); //Imprimimos error
        $ref3=$ref2[0]; //Almacenamos el ID consultado en la variable
        $ref=$ref3+1;//Sumamos 1+ para el nuevo ID
        $largo_ref=strlen($ref); //Largo de la cadena referencia

        
        if($largo_ref==1){
            $referencia="EV000000".$ref;
        }elseif($largo_ref==2){
            $referencia="EV00000".$ref;
        }elseif($largo_ref==3){
            $referencia="EV0000".$ref;
        }elseif($largo_ref==4){
            $referencia="EV000".$ref;
        }elseif($largo_ref==5){
            $referencia="EV00".$ref;
        }elseif($largo_ref==6){
            $referencia="EV0".$ref;
        }else{
            $referencia="EV".$ref;
        }

        $dateformat='YYYY-MM-DD"T"HH24:MI';
        $consulta="INSERT INTO paeventos VALUES ($formid,'$referencia', '$proceso', to_date('$fecha_descubrimiento', '$dateformat'), to_date('$fecha_inicio','$dateformat'), to_date('$fecha_finalizacion','YYYY-MM-DD'), '$evento', '$producto', '$divisa', $cuantia, $cuantia_recuperada, $cuantia_seguro, $cuentas, to_date('$fecha_contabilizacion','$dateformat'), SYSDATE, $clase_evento, $tipo_perdida, $usuario)";
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
    }
}//end if
?>