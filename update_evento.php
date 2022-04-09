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

    $id=$_POST['id'];
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

        //Traer id USUARIO
        $usuario2=oci_parse($conexion,"select USERID from usuarios where EMAIL=upper ('$usuario1')");// Traemos el ID del usuario
        oci_execute($usuario2);//Ejecutamos codigo
        $err_usu=oci_error($usuario2); //Devolvemos Error
        print_r($err_usu); //Imprimimos error
        $usuario3=oci_fetch_array($usuario2,OCI_NUM); //Traemos el id de usuario
        $usuario=$usuario3[0]; //Almacenamos el ID consultado en la variable

        $dateformat='YYYY-MM-DD"T"HH24:MI';
        $consulta="UPDATE paeventos SET proceso='$proceso', f_descubrimiento=to_date('$fecha_descubrimiento', '$dateformat'), f_inicio=to_date('$fecha_inicio','$dateformat'), f_finalizacion=to_date('$fecha_finalizacion','YYYY-MM-DD'), descripcion='$evento', producto_afectado='$producto', cuantia=$cuantia, cuantia_total_rec=$cuantia_recuperada, cuantia_rec_seg=$cuantia_seguro, cuenta_afectada=$cuentas, fecha_contabilizacion=to_date('$fecha_contabilizacion','$dateformat'), clases_eventos_id=$clase_evento, tipos_perdidas_id=$tipo_perdida, userid=$usuario WHERE id=$id";
        $ejecutar = oci_parse($conexion,$consulta);
        oci_execute($ejecutar);//Ejecutamos codigo
        $error=oci_error($ejecutar); //Devolvemos Error
            
            if ($error) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>¡Error!</strong>.Error al guardar. ".print_r($error)."
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            }else{
            //Alerta
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>¡Completado!</strong> Registro actualizado con exito.
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
}//end if
?>