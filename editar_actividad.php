<!--Bootstrap CSS -->
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
     <!-- Place your kit's code here -->
     <script src="https://kit.fontawesome.com/d0d4b813b2.js" crossorigin="anonymous"></script>
<!--  BEGIN  Fomrulario Edit   -->
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#editmodalForm').modal('show'); 
    });
</script>
<?php
include('conexion.php');
if(isset($_GET['AId']))
{
  $id=$_GET['AId'];  
  $consulta="select to_char(a.FECHA_ENTREGA, 'YYYY-MM-DD') FECHA_E, to_char(a.FECHA_CIERRE, 'YYYY-MM-DD') FECHA_C, a.* from PAACTIVIDADES a where a.id=$id";
  $ejecutar = oci_parse($conexion,$consulta);
              
  oci_execute($ejecutar);//Ejecutamos codigo
  if($row=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS))
  {
    $act=$row['ACTIVIDAD'];  
    $fechae=$row['FECHA_E']; 
    $entregable=$row['ENTREGABLE'];
    $fechac=$row['FECHA_C'];
    $observacion=$row['OBSERVACION'];
    $estado=$row['PAESTADOS_ID'];
    $idform=$row['PAFORM_ID'];
  }
}
?>
<!-- Modal -->
<div class="modal fade" id="editmodalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="d-block justify-content-between modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrar()">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                  <h4><i class='fa fa-file-text fa-lg'></i> Editar Actividad </h4>
                  
            </div>
            <!-- Modal Body -->
            <form method="post" name="editform" id="editform">
            <div class="modal-body">
               
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="idform" value="<?php echo $idform; ?>">
            <div class="form-group">
                        <label>Actividad:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="actividad" placeholder="Digite la actividad" required><?php echo $act; ?></textarea>
                        </div>
                </div>    
            
                <div class="form-group">
                        <label>Fecha de entrega:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="Date" class="form-control" value="<?php echo $fechae; ?>" name="fechae" required>
                        </div>
                </div>
                <div class="form-group">
                        <label>Entregable:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="entregable" value="<?php echo $entregable; ?>" placeholder="Digite el(los) entregable" required>
                        </div>
                </div>
                
                <div class="form-group">
                        <label>Fecha de cierre:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="Date" class="form-control" name="fechac" value="<?php echo $fechac; ?>">
                        </div>
                </div>

                <div class="form-group">
                        <label>Observaciones:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="observaciones" placeholder="Digite las observaciones"><?php echo $observacion; ?></textarea>
                        </div>
                </div>

                  <div class="form-group">
                    <strong><label for="estado">Estado</label></strong>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="estado" id="estado" required>
                        <option value=""></option>
                        <!-- Inicio codigo llenar select dependencia -->
                        <?php
                            include('conexion.php'); //Llamamos la conexion a la BD
                                        
                            //$conec=oci_connect($user, $pass, 'localhost/xe');
                            $consulta="select * from paestados";//Consulta select a la BD
                            $ejecutar = oci_parse($conexion,$consulta);
                                    
                            oci_execute($ejecutar);//Ejecutamos codigo

                            while($depend=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                                echo "<option value='".$depend['ID'] ."'";  
                                echo ">";
                                echo $depend['EDESCRIPCION']; 
                                echo "</option>";   
                            }
                            oci_free_statement($ejecutar);
                        ?>
                        <!-- Fin codigo llenar dependencia -->
                        </select>
                        <script type="text/javascript">
                                $("#estado > option[value=<?php echo $estado;?>]").attr("selected",true);
                        </script>
                    </div>    
                    </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <p class="statusMsg">
                    <div id="resultados"></div>
                </p>
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cerrar();" >Cerrar</button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary" id="guardar">Actualizar</button>
                        </div>
            </div>
        </form>   
        </div>
    </div>
</div>
<!--  END  Fomrulario edit    -->

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
   window.location="index.php?op=3&ID=<?php echo $idform; ?>";
}

 $('#editform').submit(function(event)
 {
    var parametros = $('#editform').serialize();
    var salida="";
         $.ajax({
                type: "POST",
                url: "update_actividad.php",
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