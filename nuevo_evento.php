<!--  BEGIN  Fomrulario Add   -->
<!-- <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
  <i class="fa fa-user fa-lg"></i> Nuevo Esudiante</button> -->
<!-- Modal -->

<?php
 // CALCULAMOS CONSECUTIVO DE REFERENCIA
 $ref1=oci_parse($conexion,"SELECT MAX(to_number(substr(referencia,3,9))) AS referencia FROM paeventos");//Traemos el ultimo ID de PA_FORM
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
?>

<div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="d-block justify-content-between modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrar()">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                  <h4><i class='fa fa-file-text fa-lg'></i> Nuevo Evento Materializado </h4>
                  
            </div>
            <!-- Modal Body -->
            <form method="post" name="formnew" id="formnew">
            <div class="modal-body">
               <p class="statusMsg">
               
               <h3><div id="resultados2"></div></h3>
               </p>
               <div class="form-group">
                        <label>Referencia:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="ref" value="<?php echo $referencia; ?>" disabled>
                        </div>
                </div>

                <div class="form-group">
                        <label>Proceso:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="proceso" placeholder="Campo vacío..." required>
                        </div>
                </div> 

                <?php $hoy=date("Y-m-d"). 'T' . date("H:i"); ?> <!-- CALCULAR DIA DE HOY FORMATO DATETIME-LOCAL -->

                <div class="form-group">
                        <label>Fecha de descubrimiento:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="datetime-local" class="form-control" name="fecha_descubrimiento" max="<?php echo $hoy;?>" required>
                        </div>  
                </div>

                <div class="form-group">
                        <label>Fecha inicio:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="datetime-local" class="form-control" name="fecha_inicio" max="<?php echo $hoy;?>" required>
                        </div>
                </div>

                <div class="form-group">
                        <label>Fecha de finalización:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="date" class="form-control" name="fecha_finalizacion" max="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                </div>
                
                <div class="form-group">
                        <label>Descripción del evento:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="evento" placeholder="Campo vacío..." required></textarea>
                        </div>
                </div> 

                <div class="form-group">
                        <label>Producto o Servicio afectado:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="producto" placeholder="Campo vacío...">
                        </div>
                </div> 

               <div class="form-group">
                    <label for="dependencia">Clase de evento</label>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="clase_evento" required>
                        <option value=""></option>
                        <!-- Inicio codigo llenar select dependencia -->
                        <?php
                                        
                            //$conec=oci_connect($user, $pass, 'localhost/xe');
                            $consulta="select * from PACLASES_EVENTOS A where A.STATE='ACTIVO' order by A.ID";//Consulta select a la BD
                            $ejecutar = oci_parse($conexion,$consulta);
                                    
                            oci_execute($ejecutar);//Ejecutamos codigo

                            while($clases=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                                echo "<option value='".$clases['ID'] ."'";  
                                echo ">";
                                echo $clases['DESCRIPCION']; 
                                echo "</option>";   
                            }
                            oci_free_statement($ejecutar);
                        ?>
                        <!-- Fin codigo llenar dependencia -->
                        </select>
                    </div>    
                </div>
                
                <div class="form-group">
                    <label for="dependencia">Tipo de perdida</label>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="tipo_perdida" id="tipo_perdida" required>
                        <option value=""></option>
                        <!-- Inicio codigo llenar select dependencia -->
                        <?php
                                        
                            //$conec=oci_connect($user, $pass, 'localhost/xe');
                            $consulta="select * from PATIPOS_PERDIDAS where STATE='ACTIVO' order by ID";//Consulta select a la BD
                            $ejecutar = oci_parse($conexion,$consulta);
                                    
                            oci_execute($ejecutar);//Ejecutamos codigo

                            while($riesgo=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS)){// While para llenar    
                                echo "<option value='".$riesgo['ID'] ."'";  
                                echo ">";
                                echo $riesgo['DESCRIPCION']; 
                                echo "</option>";   
                            }
                            oci_free_statement($ejecutar);
                        ?>
                        <!-- Fin codigo llenar dependencia -->
                        </select>
                    </div>    
                </div>

                <div class="form-group">
                        <label>Divisa:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="divi" placeholder="Campo vacío..." value="COP (Pesos Colombianos)" disabled>
                        </div>
                </div>

                <input type="hidden" name="divisa" value="<?php echo 'ete sech'; ?>">

                <div class="form-group">
                        <label>Cuantía:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="cuantia" placeholder="Digite un valor mayor a 0" onkeypress="return validaNumericos(event);">
                        </div>
                </div>

                <div class="form-group">
                        <label>Cuantía total recuperada:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="cuantia_recuperada" placeholder="Digite un valor mayor a 0" onkeypress="return validaNumericos(event);">
                        </div>
                </div>

                <div class="form-group">
                        <label>Cuantía recuperada por seguros:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="cuantia_seguro" placeholder="Digite un valor mayor a 0" onkeypress="return validaNumericos(event);">
                        </div>
                </div>
                
                <div class="form-group">
                        <label>Cuentas del plan de cuentas afectadas:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="cuentas" placeholder="Digite un valor mayor a 0" onkeypress="return validaNumericos(event);">
                        </div>
                </div>

                <div class="form-group">
                        <label>Fecha contabilización:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="datetime-local" class="form-control" name="fecha_contabilizacion" placeholder="Digite un valor mayor a 0">
                        </div>
                </div>
              
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
                url: "guardar_evento.php",
                data: parametros,
                beforeSend: function() {
                  $('#resultados').show();
                 },
                error: function() {
                 $('#resultados').html(salida);
                  },
                success: function(datos){
                  $('#resultados').html(datos);
				  $("#guardar").prop("disabled", false);
            }
        });
        event.preventDefault();
        
  });


$('#tipo_perdida').change(function() {
    if ($('#tipo_perdida').val() == 3){
        $('[name="cuantia"]').prop('disabled', true);
        $('[name="cuantia_recuperada"]').prop('disabled', true);
        $('[name="cuantia_seguro"]').prop('disabled', true);
    }else{
        $('[name="cuantia"]').prop('disabled', false);
        $('[name="cuantia_recuperada"]').prop('disabled', false);
        $('[name="cuantia_seguro"]').prop('disabled', false);
    }
});
</script>