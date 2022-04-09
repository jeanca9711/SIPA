<!--  BEGIN  Fomrulario Add   -->
<!-- <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
  <i class="fa fa-user fa-lg"></i> Nuevo Esudiante</button> -->
<!-- Modal -->
<div class="modal fade" id="ContrasenamodalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="d-block justify-content-between modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrarpass()">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                  <h4><i class='fa fa-file-text fa-lg'></i> Cambio de contraseña </h4>
                  
            </div>
            <!-- Modal Body -->
            <form method="post" name="formnewcontrasena" id="formnewcontrasena">
            <div class="modal-body">
               <p class="statusMsg">
               
               <h3><div id="resultados"></div></h3>
               </p>
               
                <table class="table table-borderless">
                    <tr>
                        <td>
                            <label>Contraseña actual:</label>
                            <div class="align-items-center input-group">
                                <div class="input-group-addon mr-2 mr-2">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="password" class="form-control" name="acontrasena" id="acontrasena" placeholder="Digite la conraseña actual" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nueva Contraseña:</label>
                            <div class="align-items-center input-group">
                                <div class="input-group-addon mr-2 mr-2">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="password" class="form-control" name="ncontrasena" id="ncontrasena" placeholder="Digite la nueva contraseña" required>
                            </div>
                        </td>
                        <td>
                            <label>Confirmar Contraseña:</label>
                            <div class="align-items-center input-group">
                                <div class="input-group-addon mr-2 mr-2">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="password" class="form-control" name="ccontrasena" id="ccontrasena" placeholder="Digite nuevamente la contraseña" required>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cerrarpass();" >Cerrar</button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary" id="guardar">Cambiar</button>
                        </div>
                    </div>
        </form>   
        </div>
    </div>
</div>
<!--  END  Fomrulario Add    -->

<script type="text/javascript">


function cerrarpass()
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
    }, 5000);
}


 function limpiar()
 {
    $('#formnewcontrasena').find('input:text, input:password, input:file, select, textarea').val('');
    $('#email').val('');

 }

 $('#formnewcontrasena').submit(function(event)
 {
    var parametros = $('#formnewcontrasena').serialize();
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
                  removeMessage();
            }
        });
        event.preventDefault();
        
  }) 
</script>