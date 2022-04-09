<?php
session_start();

//Tiempo de Caducidad
//Comprobamos si esta definida la sesión 'tiempo'.
if(isset($_SESSION['tiempo']) ) {

  //Tiempo en segundos para dar vida a la sesión.
  $inactivo = 7200;//2h en este caso.

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


$varsesion=$_SESSION['usuario'];
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
    <title>SIPA - AMBUQ</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <!-- TABLA -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- para exportar -->
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    
    <!-- Bootstrap 4 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
    
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Place your kit's code here -->
    <script src="https://kit.fontawesome.com/d0d4b813b2.js" crossorigin="anonymous"></script>

</head>
<body>
<div class="container-fluid">

<script language="javascript">
    $(document).ready(function() {
        $('#tform').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        'excelHtml5',
        'csvHtml5'
        ],
        language: {
          "decimal": ",",
          "emptyTable": "No hay información",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
          "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
          "infoFiltered": "(Filtrado de _MAX_ total entradas)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar _MENU_ Entradas",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "zeroRecords": "Sin resultados encontrados",
          "paginate": {
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
              }
        }
      } );
    } );
  </script>

<h1 class="text-center">Planes de Acción</h1>
<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
  <i class="fa fa-file-text fa-lg"></i> Nuevo Registro
</button>

</div>
<!-- FIN Body Pagina -->
<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4 text-center">
    <div class="spinner-border text-success" role="status" id='loading'>
      <span class="sr-only">Cargando...</span>
    </div>
  </div>
  <div class="col-md-4"></div>
</div>
<table id="tform" class="table table-hover" style="width:100%;font-size:10px;display:none;">
        <thead>
            <tr>
              <th>Id</th>
              <th>Riesgo</th>
              <th>Problema</th>
              <th>Accion de Mejoramiento</th>
              <th>Proposito</th>
              <th>Estrategia</th>
              <th>Indicador</th>
              <th>Periodicidad</th>  
              <th>Linea Base</th>
              <th>Meta General</th>
              <th>Cumplimiento Total</th>
              <th>Sucursal</th>
              <th>Usuario</th>
              <th>Acciones</th>
            </tr>  
        </thead>

        <tbody>
          <?php
            
            //$conec=oci_connect($user, $pass, 'localhost/xe');
            if($tipou==1)
            {
              $consulta="select * from DATAFORM";//Consulta select a la BD
            }else{
              $consulta="select * from DATAFORM where SUCURSAL='$usucursal'";//Consulta select a la BD
            }
            $ejecutar = oci_parse($conexion,$consulta);
                    
            oci_execute($ejecutar);//Ejecutamos codigo
              while($row=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS))
              {
                
                $consulta2="select max(a.CUMPLIMIENTO_TOTAL) as CUMPLIMIENTO_TOTAL from PASEGUIMIENTO a where a.FORMID=".$row['ID'];//Consulta select a la BD
                $ejecutar2 = oci_parse($conexion,$consulta2);
                oci_execute($ejecutar2);//Ejecutamos codigo
                while($row2=oci_fetch_array($ejecutar2,OCI_ASSOC+OCI_RETURN_NULLS)){
                  $cumplimientototal=$row2['CUMPLIMIENTO_TOTAL'];
                  if($row2['CUMPLIMIENTO_TOTAL']==null) $lastcumplimiento=0;
                  else $lastcumplimiento=$row2['CUMPLIMIENTO_TOTAL'];

                  $diferencia=$lastcumplimiento-$row['META_GENERAL'];
                }

              ?>
              <tr>
                  <td> <?php echo $row['ID']; ?> </td>
                  <td style="width:10%;"> <?php echo $row['CODIGO_RIESGO'] . '-'. $row['NOMBRE_RIESGO'];?> </td>
                  <td style="width:10%;"> <?php echo $row['PROBLEMA']; ?> </td>
                  <td style="width:10%;"> <?php echo $row['ACC_MEJORAMIENTO'];?> </td>
                  <td style="width:10%;"> <?php echo $row['PROPOSITO'];?> </td>
                  <td style="width:20%;"> <?php echo $row['ESTRATEGIA'];?> </td>
                  <td> <?php echo $row['INDICADOR'];?> </td>
                  <td> <?php echo $row['PERIODICIDAD'];?> </td> 
                  <td> <?php echo $row['LINEA_BASE'];?> </td>
                  <td> <?php echo $row['META_GENERAL'];?> </td>
                  
                  <td <?php
                        if($row['META_GENERAL']!=null){
                          if($diferencia>=0)echo "class='table-success'";//inicio condicionales colores
                          else{
                              if($diferencia>=-15) {
                                  echo "class='table-warning'";
                              }else{
                                  echo "class='table-danger'";
                              }
                          }
                        }else{
                          echo "class='table-danger'";
                        }
                        ?>> 
                        <?php echo $cumplimientototal;?>
                  </td>
                  <td> <?php echo $row['SUCURSAL'];?> </td>
                  <td> <?php echo $row['USUARIO'];?> </td>
                  <td>
                  <button class="btn btn-link btn">
                    <a href="index.php?op=3&ID=<?php echo $row['ID'];?>" title="Actividades" style="font-size:12px;">
                    Ver Act
                    </a>
                  <?php
                  
                    $SQL="select count(*) as cant from paactividades where paform_id=".$row['ID']." and PAESTADOS_ID not in (2) and state='ACTIVO'";//Consulta select a la BD
                    $play = oci_parse($conexion,$SQL);
                            
                    oci_execute($play);//Ejecutamos codigo
                    $count=oci_fetch_array($play,OCI_NUM);
                    $cant=$count[0];
                    if($cant>0){
                        echo "<span class='badge badge-warning'><span class='badge badge-light'>$cant</span> Pend</span>";
                      }
                      
                  ?>
                  </button>
                  <a href="index.php?op=2&ID=<?php echo $row['ID'];?>" title="Editar">
                      <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit" style="font-size:24px;color:black;"></i>
                      </button>
                  </a>
                  <a href="index.php?op=5&ID=<?php echo $row['ID'];?>" title="Agregar avance">
                      <button type="submit" class="btn btn-info btn-sm">
                        <i class="fa fa-plus-circle" style="font-size:24px;color:black;"></i>
                      </button>
                  </a>
                  </td>
                  <!-- <a href="eliminar_acta.php?ID=<?php //echo $row['ID'];?>" title="Eliminar"
                  onclick="return confirm('¿esta seguro que desea eliminar?');"><button class="btn btn-danger">
                    <i class="fa fa-trash" style="font-size:24px;color:white;"></i> 
                    </button>
                    </a>
                  </td>-->
            </tr>   
              <?php
              }//end while    
          ?>
        </tbody>

        <tfoot>
            <tr>
              <th>Id</th>
              <th>Riesgo</th>
              <th>Problema</th>
              <th>Accion de Mejoramiento</th>
              <th>Proposito</th>
              <th>Estrategia</th>
              <th>Indicador</th>
              <th>Periodicidad</th>
              <th>Linea Base</th>
              <th>Meta General</th>
              <th>Cumplimiento Total</th>
              <th>Sucursal</th>
              <th>Usuario</th>
              <th>Acciones</th>
            </tr>  
        </tfoot>
</table>
<!-- Footer -->
<footer id="sticky-footer" class="py-4 bg-success text-white">
    <div class="container text-center">
    <strong>Gerencia de Riesgos</strong><br></br>
      <small>Copyright &copy; AMBUQ 2019</small>
      <p style="font-size:10px;">Design By: Jean C. Del Portillo</p>
    </div>
</footer>
<!-- FIN Footer -->
<?php
  include("nuevo.php");
  //include("editar.php");
?>
</body>
<script language="javascript">
window.onload = function(){
  $('#loading').fadeOut();
  $('#tform').css({"display": "block"});
}

</script>
</html>
