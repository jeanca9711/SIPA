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
        $('#teventos').DataTable( {
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

<h1 class="text-center">Registro de Eventos Materializados</h1>
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
<table id="teventos" class="table table-hover" style="width:100%;font-size:9px;display:none;">
        <thead>
            <tr>
              <th>Referencia</th>
              <th>Fecha Descubrimiento</th>
              <th>Fecha Inicio</th>
              <th>Fecha Finalización</th>
              <th>Descripción</th>
              <th>Producto Afectado</th>
              <th>Clase de evento</th>
              <th>Tipo de perdida</th>
              <th>Divisa</th>  
              <th>Cuantía</th>
              <th>Cuantía total recuperada</th>
              <th>Cuantía recuperada por seguros</th>
              <th>Cuenta Afectada</th>
              <th>Fecha Contabilización</th>
              <th>Usuario</th>
              <th>Sucursal</th>
              <th>Acciones</th>
            </tr>  
        </thead>

        <tbody>
          <?php
            
             //$conec=oci_connect($user, $pass, 'localhost/xe');
             if($tipou==1)
             {
              $consulta="select * from PAEVENTOS_VIEW";//Consulta select a la BD
             }else{
              $consulta="select * from PAEVENTOS_VIEW where SUCURSAL='$usucursal'";//Consulta select a la BD
             }
             $ejecutar = oci_parse($conexion,$consulta);
                     
             oci_execute($ejecutar);//Ejecutamos codigo
              while($row=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS))
              {
              ?>
              <tr>
                  <td> <?php echo $row['REFERENCIA']; ?> </td>
                  <td> <?php echo $row['F_DESCUBRIMIENTO']; ?>  </td>
                  <td> <?php echo $row['F_INICIO']; ?> </td>
                  <td> <?php echo $row['F_FINALIZACION'];?> </td>
                  <td> <?php echo $row['DESCRIPCION'];?> </td>
                  <td> <?php echo $row['PRODUCTO_AFECTADO'];?> </td>
                  <td> <?php echo $row['CLASE_EVENTO'];?> </td>
                  <td> <?php echo $row['TIPO_PERDIDA'];?> </td> 
                  <td> <?php echo $row['DIVISA'];?> </td>
                  <td> <?php echo $row['CUANTIA'];?> </td>
                  <td> <?php echo $row['CUANTIA_TOTAL_REC'];?> </td>
                  <td> <?php echo $row['CUANTIA_REC_SEG'];?> </td>
                  <td> <?php echo $row['CUENTA_AFECTADA'];?> </td>
                  <td> <?php echo $row['FECHA_CONTABILIZACION'];?> </td>
                  <td> <?php echo $row['NOMBRES'];?> </td>
                  <td> <?php echo $row['SUCURSAL'];?> </td>
                  <td>
                  <button class="btn btn-link btn"></button>
                  <a href="index.php?op=9&ID=<?php echo $row['ID'];?>" title="Editar">
                      <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit" style="font-size:24px;color:black;"></i>
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
              <th>Referencia</th>
              <th>Fecha Descubrimiento</th>
              <th>Fecha Inicio</th>
              <th>Fecha Finalización</th>
              <th>Descripción</th>
              <th>Producto Afectado</th>
              <th>Clase de evento</th>
              <th>Tipo de perdida</th>
              <th>Divisa</th>  
              <th>Cuantía</th>
              <th>Cuantía total recuperada</th>
              <th>Cuantía recuperada por seguros</th>
              <th>Cuenta Afectada</th>
              <th>Fecha Contabilización</th>
              <th>Usuario</th>
              <th>Sucursal</th>
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
  include("nuevo_evento.php");
  //include("editar.php");
?>
</body>
<script language="javascript">
window.onload = function(){
  $('#loading').fadeOut();
  $('#teventos').css({"display": "block"});
}

</script>
</html>