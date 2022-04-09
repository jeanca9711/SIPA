<?php
session_start();

$_SESSION['tiempo'] = time();


$varsesion= $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
  echo "<script>alert('Usted no esta autorizado para ver este sitio');
        </script>";
  header('location:login.php');
  die();
}
include('conexion.php'); //Llamamos la conexion a la BD

$usuario2=oci_parse($conexion,"select * from usuarios where EMAIL=upper ('$varsesion')");// Traemos el ID del usuario
oci_execute($usuario2);//Ejecutamos codigo
if($row=oci_fetch_array($usuario2,OCI_ASSOC+OCI_RETURN_NULLS)){
  $uid=$row['USERID'];
  $tipou=$row['TIPOUSUARIO_ID'];
  $usucursal=$row['SUCURSAL'];
  $nombresu=$row['NOMBRES']. ' '. $row['APELLIDOS'];
}

if ($tipou <> 1) {
  echo "<script>alert('Usted no esta autorizado para ver este sitio');
        </script>";
  header('location:index.php?op=1');
  die();
}


include "conexion.php";
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache"); 
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=SIPA_EXPORT.xls" );
?>
<table id="tbformulario">
                <thead>
                    <tr>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">ID</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">RIESGO</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">FECHA</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">F_CREACION</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">PROBLEMA</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">ACC_MEJORAMIENTO</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">PROPOSITO</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">ESTRATEGIA</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">INDICADOR</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">RESPONSABLE</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">DEPENDENCIA</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">PERIODICIDAD</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">LINEA_BASE</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">META_GENERAL</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">USUARIO</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">SUCURSAL</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">ID_ACTIVIDAD</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">ACTIVIDAD</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">F_CREACION_ACT</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">FECHA_ENTREGA</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">ENTREGABLE</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">FECHA_CIERRE</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">OBSERVACION</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">STATE</p></th>
                    <th style="background-color: #458b37;" scope="col"><p style="color: white;">EDESCRIPCION</p></th>
                    </tr>
                </thead>
                <!-- Llenamos Tabla Formulario -->
                <?php                                
                    //$conec=oci_connect($user, $pass, 'localhost/xe');
                    $consulta="select * from DATA_FORM";//Consulta select a la BD
                    $ejecutar = oci_parse($conexion,$consulta);
                            
                    oci_execute($ejecutar);//Ejecutamos codigo
                    while($data=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                        echo "<tr>";  
                        echo "<th scope='row'>".$data['ID']."</th>";
                        echo "<td>".$data['RIESGO']."</td>";
                        echo "<td>".$data['FECHA']."</td>";
                        echo "<td>".$data['F_CREACION']."</td>";
                        echo "<td>".$data['PROBLEMA']."</td>";
                        echo "<td>".$data['ACC_MEJORAMIENTO']."</td>";
                        echo "<td>".$data['PROPOSITO']."</td>";
                        echo "<td>".$data['ESTRATEGIA']."</td>";
                        echo "<td>".$data['INDICADOR']."</td>";
                        echo "<td>".$data['RESPONSABLE']."</td>";
                        echo "<td>".$data['DEPENDENCIA']."</td>";
                        echo "<td>".$data['PERIODICIDAD']."</td>";
                        echo "<td>".$data['LINEA_BASE']."</td>";
                        echo "<td>".$data['META_GENERAL']."</td>";
                        echo "<td>".$data['USUARIO']."</td>";
                        echo "<td>".$data['SUCURSAL']."</td>";
                        echo "<td>".$data['ID_ACTIVIDAD']."</td>";
                        echo "<td>".$data['ACTIVIDAD']."</td>";
                        echo "<td>".$data['F_CREACION_ACT']."</td>";
                        echo "<td>".$data['FECHA_ENTREGA']."</td>";
                        echo "<td>".$data['ENTREGABLE']."</td>";
                        echo "<td>".$data['FECHA_CIERRE']."</td>";
                        echo "<td>".$data['OBSERVACION']."</td>";
                        echo "<td>".$data['STATE']."</td>";
                        echo "<td>".$data['EDESCRIPCION']."</td>";
                        echo "</tr>";
                    }
                    //Limpiamos statement
                    oci_free_statement($ejecutar);
                    oci_close($conexion); //Cerramos conexion
                ?>
</table>