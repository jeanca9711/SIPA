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
        $('#tactividades').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      } );
    } );
  </script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#SeguimientosmodalForm').modal('show'); 
    });
</script>
<?php
include('conexion.php');
if(isset($_GET['ID']))
{
    $id=$_GET['ID'];
    $consulta="select * from paform a where a.id=$id";
    $ejecutar = oci_parse($conexion,$consulta);
              
    oci_execute($ejecutar);//Ejecutamos codigo
    if($row=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS))
    {
        $metageneral=$row['META_GENERAL'];
        $lineabase=$row['LINEA_BASE'];
    }

    
}
?>
<style>
.mlg {
    max-width: 90%;
}
</style>
<!-- Modal -->
<div class="modal fade" id="SeguimientosmodalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="d-block justify-content-between modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrar()">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                    <h3 class="text-center">Seguimiento Avance</h3>
                    <div id="resultados"></div>
                    <form id="seguimientosForm" method="post">
                    <input type="hidden" name="ultimoporcentaje" value="<?php echo $lastporcentaje;?>">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <label>Linea Base:</label>
                                    <div class="align-items-center input-group">
                                        <div class="input-group-addon mr-2 mr-2">
                                            <i class="fas fa-hashtag"></i>
                                        </div>
                                        <input type="text" class="form-control" name="lineabase" id="lineabase" value="<?php echo $lineabase; ?>" onkeypress="return validaNumericos(event)" disabled>
                                    </div>
                                </td>
                                <td>
                                    <label>Meta General:</label>
                                    <div class="align-items-center input-group">
                                        <div class="input-group-addon mr-2 mr-2">
                                            <i class="fas fa-hashtag"></i>
                                        </div>
                                        <input type="text" class="form-control" name="mgeneral" id="mgeneral" value="<?php echo $metageneral; ?>" onkeypress="return validaNumericos(event)" disabled>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Porcentaje de avance:</label>
                                    <div class="align-items-center input-group">
                                        <div class="input-group-addon mr-2 mr-2">
                                            <i class="fas fa-hashtag"></i>
                                        </div>
                                        <input type="text" class="form-control" name="pavance" id="pavance" onkeypress="return validaNumericos(event)" required>
                                    </div>
                                </td>
                            </tr>
                        </table>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
               
            <!-- Modal Footer -->
            <div class="modal-footer">
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cerrar();" >Cerrar</button>
                        </div>
                        <div>
                            <a href="index.php?op=6&ID=<?php echo $id;?>" class="btn btn-primary">Ver Seguimientos</a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                        </div>
            </div>      
                    </form>
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
    }, 10000);
}

 function limpiar()
 {
    //$('#seguimientosForm').find('input:text, input:password, input:file, select, textarea').val('');
    $('#pavance').val('');
 }

function cerrar()
{
   window.location="index.php?op=1";
}

function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}

$('#seguimientosForm').submit(function(event)
 {
    var parametros = $('#seguimientosForm').serialize();
    var salida="";
    console.log(parametros);
         $.ajax({
                type: "POST",
                url: "guardar_seguimiento.php",
                data: parametros,
                beforeSend: function() {
                  $('#resultados').show();
                 },
                error: function() {
                 $('#resultados').html(salida);
                  },
                success: function(datos){
                  $('#resultados').html(datos);
                  limpiar();  
                  removeMessage();
            }
        });
        event.preventDefault();
        
  }) 


</script>
