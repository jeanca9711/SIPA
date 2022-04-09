<!--  BEGIN  Fomrulario Add   -->
<!-- <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
  <i class="fa fa-user fa-lg"></i> Nuevo Esudiante</button> -->
<!-- Modal -->
<div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="d-block justify-content-between modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrar2()">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                  <h4><i class='fa fa-file-text fa-lg'></i> Nueva Actividad </h4>
                  
            </div>
            <!-- Modal Body -->
            <form method="post" name="formnew" id="formnew">
            <div class="modal-body">
               <p class="statusMsg">
                <h3><div id="resultados2"></div></h3>
               </p>
               <input type="hidden" name="id" value="<?php echo $id;?>">
               <div class="form-group">
                        <label>Actividad:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="actividad" placeholder="Digite la actividad" required></textarea>
                        </div>
                </div>    
            
                <div class="form-group">
                        <label>Fecha de entrega:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="Date" class="form-control" name="fechae" required>
                        </div>
                </div>
                <div class="form-group">
                        <label>Entregable:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="entregable" placeholder="Digite el(los) entregable" required>
                        </div>
                </div>
                
                <div class="form-group">
                        <label>Fecha de cierre:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="Date" class="form-control" name="fechac">
                        </div>
                </div>

                <div class="form-group">
                        <label>Observaciones:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="observaciones" placeholder="Digite las observaciones"></textarea>
                        </div>
                </div>

                  <div class="form-group">
                    <strong><label for="dependencia">Estado</label></strong>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="estado" required>
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
                    </div>    
                    </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <p class="statusMsg">
                    <div id="resultados"></div>
                </p>
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cerrar2();" >Cerrar</button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
                        </div>
                    </div>
        </form>   
        </div>
    </div>
</div>
<!--  END  Fomrulario Add    -->

<script type="text/javascript">


function cerrar2()
{
    location.reload();
}

function removeMessage(){
    setTimeout(function () 
    {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            //$(this).remove();
            $(".alert").alert('close');
        });
    }, 20000);
}


 function limpiar()
 {
    $('#formnew').find('input:text, input:password, input:file, select, textarea').val('');
 }

 $('#formnew').submit(function(event)
 {
	$("#guardar").prop("disabled", true);
    var parametros = $('#formnew').serialize();
    var salida="";
    console.log(parametros);
         $.ajax({
                type: "POST",
                url: "guardar_actividad.php",
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
				  $("#guardar").prop("disabled", false);
            }
        });
        event.preventDefault();
        
  }) 
</script>