<!--  BEGIN  Fomrulario Add   -->
<!-- <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
  <i class="fa fa-user fa-lg"></i> Nuevo Esudiante</button> -->
<!-- Modal -->
<div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="d-block justify-content-between modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrar()">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                  <h4><i class='fa fa-file-text fa-lg'></i> Nuevo Plan de Acción </h4>
                  
            </div>
            <!-- Modal Body -->
            <form method="post" name="formnew" id="formnew">
            <div class="modal-body">
               <p class="statusMsg">
               
               <h3><div id="resultados2"></div></h3>
               </p>
               <div class="form-group">
                    <label for="dependencia">Riesgo Asociado</label>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="riesgo" required>
                        <option value=""></option>
                        <!-- Inicio codigo llenar select dependencia -->
                        <?php
                                        
                            //$conec=oci_connect($user, $pass, 'localhost/xe');
                            $consulta="select * from PARIESGO where ESTADO='HABILITADO' order by CODIGO_RIESGO";//Consulta select a la BD
                            $ejecutar = oci_parse($conexion,$consulta);
                                    
                            oci_execute($ejecutar);//Ejecutamos codigo

                            while($riesgo=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                                echo "<option value='".$riesgo['IDRIESGO'] ."'";  
                                echo ">";
                                echo $riesgo['CODIGO_RIESGO'] . ' - ' . $riesgo['NOMBRE_RIESGO']; 
                                echo "</option>";   
                            }
                            oci_free_statement($ejecutar);
                        ?>
                        <!-- Fin codigo llenar dependencia -->
                        </select>
                    </div>    
                </div>
               <div class="form-group">
                        <label>Problema:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="problema" placeholder="Digite el problema" required></textarea>
                        </div>
                </div>    
            
                <div class="form-group">
                        <label>Accion de mejoramiento:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="accmejoramiento" placeholder="Digite la accion de mejoramiento" required></textarea>
                        </div>
                </div> 
                <div class="form-group">
                        <label>Proposito:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="proposito" placeholder="Digite el proposito" required></textarea>
                        </div>
                </div>
                <div class="form-group">
                        <label>Estrategia:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="estrategia" placeholder="Digite la estrategia" required></textarea>
                        </div>
                </div>
                <div class="form-group">
                        <label>Indicador:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="indicador" placeholder="Digite el indicador" required></textarea>
                        </div>
                </div> 

                <div class="form-group">
                        <label>Fecha:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="Date" class="form-control" name="fecha" required>
                        </div>
                </div>

                <div class="form-group">
                        <label>Responsable:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="responsable" placeholder="Digite el responsable" required>
                        </div>
                </div> 

                <div class="form-group">
                        <label>Periodicidad (número de seguimientos):</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="number" class="form-control" min="1" max="999" value="1" id="periodicidad" name="periodicidad" placeholder="Digitar el número de seguimientos" required>
                        </div>
                </div> 

                <div class="form-group">
                    <label for="dependencia">Dependencia</label>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="dependencia" required>
                        <option value=""></option>
                        <!-- Inicio codigo llenar select dependencia -->
                        <?php
                            include('conexion.php'); //Llamamos la conexion a la BD
                                        
                            //$conec=oci_connect($user, $pass, 'localhost/xe');
                            $consulta="select * from dependencia where DEPID>0";//Consulta select a la BD
                            $ejecutar = oci_parse($conexion,$consulta);
                                    
                            oci_execute($ejecutar);//Ejecutamos codigo

                            while($depend=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                                echo "<option value='".$depend['DEPID'] ."'";  
                                echo ">";
                                echo $depend['DEPENDENCIA']; 
                                echo "</option>";   
                            }
                            oci_free_statement($ejecutar);
                        ?>
                        <!-- Fin codigo llenar dependencia -->
                        </select>
                    </div>    
                 </div>
                <table class="table table-borderless">
                    <tr>
                        <td>
                            <label>Linea Base:</label>
                            <div class="align-items-center input-group">
                                <div class="input-group-addon mr-2 mr-2">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="text" class="form-control" name="lineabase" id="lineabase" placeholder="Digitar la linea base" onkeypress="return filterFloat(event,this);" required>
                            </div>
                        </td>
                        <td>
                            <label>Meta General:</label>
                            <div class="align-items-center input-group">
                                <div class="input-group-addon mr-2 mr-2">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="text" class="form-control" name="mgeneral" id="mgeneral" placeholder="Digitar la meta general" onkeypress="return filterFloat(event,this);" required>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
            <div id="resultados"></div>
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cerrar();" >Cerrar</button>
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


function cerrar()
{
    location.reload();
}

function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;     
}

function filterFloat(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
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
    $('#formnew').find('input:text, textarea').val('');
	$('#periodicidad').val('1');
 }

 $('#formnew').submit(function(event)
 {
	$("#guardar").prop("disabled", true);
    var parametros = $('#formnew').serialize();
    var salida="";
    console.log(parametros);
         $.ajax({
                type: "POST",
                url: "guardar.php",
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