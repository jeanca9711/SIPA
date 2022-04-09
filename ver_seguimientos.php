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
<!-- Body Pagina -->
<div class="container-fluid">

<script language="javascript">
    $(document).ready(function() {
        $('#tseguimientos').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
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
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#VerSeguimientosmodalForm').modal('show'); 
    });
</script>
<?php
include('conexion.php');
if(isset($_GET['ID']))
{
    $id=$_GET['ID'];
}
?>
<style>
.mlg {
    max-width: 90%;
}
</style>
<!-- Modal -->
<div class="modal fade" id="VerSeguimientosmodalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg mlg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="d-block justify-content-between modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrar()">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>     
                <h3 class="text-center">Seguimientos</h3>               
                    <!-- FIN Body Pagina -->
                    <table id="tseguimientos" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>FECHA</th>
                                    <th>PORCENTAJE AVANCE</th>
                                    <th>CUMPLIMIENTO TOTAL</th>
                                    <th>META GENERAL</th>
                                </tr>  
                            </thead>

                            <tbody>
                            <?php
                                include('conexion.php'); //Llamamos la conexion a la BD
                                                    
                                //$conec=oci_connect($user, $pass, 'localhost/xe');
                                $consulta="select b.PERIODICIDAD, b.META_GENERAL, to_char(a.FECHA, 'YYYY-MM-DD') FECHA2, a.* FROM PASEGUIMIENTO a inner join PAFORM b on a.FORMID=b.ID where a.FORMID=$id order by a.IDSEGUIMIENTO";//Consulta select a la BD
                                $ejecutar = oci_parse($conexion,$consulta);
                                        
                                oci_execute($ejecutar);//Ejecutamos codigo
                                
                                $division=0;
                                while($row=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS))
                                {
                                    $division=($row['META_GENERAL']/$row['PERIODICIDAD'])+$division;
                                    $diferencia=$row['CUMPLIMIENTO_TOTAL']-$division;
                                
                                ?>
                                
                                <tr <?php
                                    if($diferencia>=0)echo "class='table-success'";//color terminado
                                    else{
                                        if($diferencia>=-6) {//inicio condicionales colores
                                            echo "class='table-warning'";
                                        }else{
                                            echo "class='table-danger'";
                                        }
                                    }
                                    ?>>
                                    <td> <?php echo $row['IDSEGUIMIENTO'] . '-'. $diferencia; ?> </td>
                                    <td> <?php echo $row['FECHA'];?> </td>
                                    <td> <?php echo $row['PORCENTAJE_AVANCE'];?> </td>
                                    <td> <?php echo $row['CUMPLIMIENTO_TOTAL'];?> </td>
                                    <td> <?php echo $row['META_GENERAL'];?> </td>
                                </tr>   
                                <?php
                                }//end while    
                            ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>FECHA</th>
                                    <th>PORCENTAJE AVANCE</th>
                                    <th>CUMPLIMIENTO TOTAL</th>
                                    <th>META GENERAL</th>
                                </tr>
                            </tfoot>
                    </table>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
               
            <!-- Modal Footer -->
            <div class="modal-footer">
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cerrar();" >Cerrar</button>
                        </div>
            </div> 

        </div>
    </div>
</div>
<?php
  include("nueva_actividad.php");
  //include("editar_acta.php");
?>
<script type="text/javascript">
function removeMessage(){
    setTimeout(function () 
    {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            //$(this).remove();
            $(".alert").alert('close');
        });
    }, 5000);
}

 function limpiar()
 {
    $('#editform').find('input:text, input:password, input:file, select, textarea').val('');
 }

function cerrar()
{
   window.location="index.php?op=5&ID=<?php echo $id;?>";
}


</script>
