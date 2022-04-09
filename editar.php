<!--Bootstrap CSS -->
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     <!--jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <!--Place your kit's code here -->
     <script src="https://kit.fontawesome.com/d0d4b813b2.js" crossorigin="anonymous"></script>
  <!--BEGIN  Fomrulario Edit   -->
  <script type="text/javascript">
    $(document).ready(function()
    {
        $('#editmodalForm').modal('show'); 
    });
</script>

<?php
include('conexion.php');
if(isset($_GET['ID']))
{
  $id=$_GET['ID'];
  $consulta="select to_char(a.fecha, 'YYYY-MM-DD') fecha2, a.* from paform a where a.id=$id";
    $ejecutar = oci_parse($conexion,$consulta);
              
    oci_execute($ejecutar);//Ejecutamos codigo
  if($row=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS))
  {
    $pro=$row['PROBLEMA'];  
    $accmejo=$row['ACC_MEJORAMIENTO']; 
    $prop=$row['PROPOSITO'];
    $estr=$row['ESTRATEGIA'];
    $ind=$row['INDICADOR'];
    $resp=$row['RESPONSABLE'];
    $dep=$row['DEPID'];
    $per=$row['PERIODICIDAD'];
    $user=$row['USERID'];
    $fech=$row['FECHA2'];
    $metageneral=$row['META_GENERAL'];
    $lineabase=$row['LINEA_BASE'];
    $idriesgo=$row['IDRIESGO'];
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
                  <h4><i class='fa fa-file-text fa-lg'></i> Editar Plan </h4>
                  
            </div>
            <!-- Modal Body -->
            <form method="post" name="editform" id="editform">
            <div class="modal-body">
               <p class="statusMsg">
               <h3><div id="resultados2"></div></h3>
               </p>
               
               <input type="hidden" name="id" value="<?php echo $id ?>">   
               <div class="form-group">
                    <label for="dependencia">Riesgo Asociado</label>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="riesgo" id="riesgo" required>
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
                        <script type="text/javascript">
                                $("#riesgo > option[value=<?php echo $idriesgo;?>]").attr("selected",true);
                        </script>
                    </div>    
                </div>

               <div class="form-group">
                        <label>Problema:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="problema" placeholder="Digite el problema" required><?php echo $pro; ?></textarea>
                        </div>
                </div>    
            
                <div class="form-group">
                        <label>Accion de mejoramiento:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="accmejoramiento" placeholder="Digite la accion de mejoramiento" required><?php echo $accmejo; ?></textarea>
                        </div>
                </div> 
                <div class="form-group">
                        <label>Proposito:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="proposito" placeholder="Digite el proposito" required><?php echo $prop; ?></textarea>
                        </div>
                </div>
                <div class="form-group">
                        <label>Estrategia:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="estrategia" placeholder="Digite la estrategia" required><?php echo $estr; ?></textarea>
                        </div>
                </div>
                <div class="form-group">
                        <label>Indicador:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <textarea class="form-control" name="indicador" placeholder="Digite el indicador" required><?php echo $ind; ?></textarea>
                        </div>
                </div> 

                <div class="form-group">
                        <label>Fecha:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                            <input type="Date" class="form-control" name="fecha" value="<?php echo $fech; ?>" required>
                        </div>
                </div>

                <div class="form-group">
                        <label>Responsable:</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="text" class="form-control" name="responsable" value="<?php echo $pro; ?>" placeholder="Digite el responsable" required>
                        </div>
                </div> 

                <div class="form-group">
                        <label>Periodicidad (número de seguimientos):</label>
                        <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <input type="number" class="form-control" min="1" max="999" value="<?php echo $per; ?>" name="periodicidad" placeholder="Digitar el número de seguimientos" required>
                        </div>
                </div>  

                  <div class="form-group">
                    <strong><label for="dependencia">Dependencia</label></strong>
                    <div class="align-items-center input-group">
                            <div class="input-group-addon mr-2 mr-2">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        <select  class="form-control" name="dependencia" id="dependencia" required>
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
                        <script type="text/javascript">
                                $("#dependencia > option[value=<?php echo $dep;?>]").attr("selected",true);
                        </script>
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
                                <input type="text" class="form-control" name="lineabase" id="lineabase" placeholder="Digitar linea base" value="<?php echo $lineabase; ?>" onkeypress="return filterFloat(event,this);" required>
                            </div>
                        </td>
                        <td>
                            <label>Meta General:</label>
                            <div class="align-items-center input-group">
                                <div class="input-group-addon mr-2 mr-2">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="text" class="form-control" name="mgeneral" id="mgeneral" placeholder="Digitar la meta general" value="<?php echo $metageneral; ?>" onkeypress="return filterFloat(event,this);" required>
                            </div>
                        </td>
                    </tr>
                </table>
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


 function limpiar()
 {
    $('#editform').find('input:text, input:password, input:file, select, textarea').val('');
 }

function cerrar()
{
   window.location="index.php?op=1";
}

 $('#editform').submit(function(event)
 {
    var parametros = $('#editform').serialize();
    var salida="";
         $.ajax({
                type: "POST",
                url: "update.php",
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