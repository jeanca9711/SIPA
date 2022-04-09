<?php
session_start();

//Tiempo de Caducidad
//Comprobamos si esta definida la sesión 'tiempo'.
if(isset($_SESSION['tiempo']) ) {

    //Tiempo en segundos para dar vida a la sesión.
    $inactivo = 7200;//20min en este caso.
  
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

$varsesion= $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
  echo "<script>alert('Usted no esta autorizado para ver este sitio');
        '</script>";
  header('location:login.php');
  die();
}
include('conexion.php');

$usuario2=oci_parse($conexion,"select * from usuarios where EMAIL=upper ('$varsesion')");// Traemos el ID del usuario
oci_execute($usuario2);//Ejecutamos codigo
if($row=oci_fetch_array($usuario2,OCI_ASSOC+OCI_RETURN_NULLS)){
  $uid=$row['USERID'];
  $tipou=$row['TIPOUSUARIO_ID'];
  $usucursal=$row['SUCURSAL'];
  $nombresu=$row['NOMBRES']. ' '. $row['APELLIDOS'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIPA-Estrategias</title>
    <!-- Bootstrap 4 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Place your kit's code here -->
    <script src="https://kit.fontawesome.com/d0d4b813b2.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="row">
  <!-- Icono -->
  <div class="col-sm-2"><!-- Col 2 -->
  <a class="navbar-brand" href="#">
    <img src="img/logo.png" alt="logo" style="width:150px;">
  </a>
  </div>
  <div class="col-sm-10"><!-- Col 10 -->
    <?php echo '<h3 style="text-align:right; padding:16px;">Bienvenido '. $varsesion . '</h1>'; ?>
  </div>
</div>
<!-- Barra de Navegacion -->
<nav class="navbar navbar-expand-sm bg-success navbar-dark sticky-top">
    <!-- Links -->
    <a class="navbar-brand" href="#">SIPA - AMBUQ</a>
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="index.php?op=1"><i class="fa fa-wpforms"></i> Formulario</a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="estrategias.php"><i class="fa fa-project-diagram"></i> Estrategias</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="instructivo.php"><i class="fa fa-file-pdf"></i> Instructivo</a>
        </li>
        <?php if($tipou == 1){ ?>
        <li class="nav-item">
        <a class="nav-link" href="index.php?op=7"><i class="fa fa-chart-bar"></i> Reportes</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="index.php?op=8"><i class="fa fa-exclamation-triangle"></i> Eventos materializados</a>
        </li> 
        <?php } ?>
        </ul>
        <ul class="navbar-nav  ml-auto">
          <li class="nav-item">
            <a class="btn btn-outline-warning" href="cerrar_sesion.php" role="button">Cerrar Sesión</a>
          </li>
        </ul>
</nav>
<!-- FIN Barra de Navegacion -->
<div style="padding: 25px;">
        
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <!-- FIN Grupo de Botones -->
            <div class="btn-group-vertical" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-success" onclick="showTbControlPrenatal()">Control Prenatal</button>
                <button type="button" class="btn btn-success" onclick="showTbRiesgoCardiovascular()">Riesgo Cardiovascular</button>
                <button type="button" class="btn btn-success" onclick="showTbCitologia()">Citología</button>
                <button type="button" class="btn btn-success" onclick="showTbMamografia()">Mamografía</button>
                <button type="button" class="btn btn-success" onclick="showTbJoven()">Joven</button>
                <button type="button" class="btn btn-success" onclick="showTbPlanifFamiliar()">Planificación Familiar</button>
                <button type="button" class="btn btn-success" onclick="showTbCrecimientoDesarrollo()">Crecimiento y Desarrollo</button>
                <button type="button" class="btn btn-success" onclick="showTbAdultoMayor()">Adulto Mayor</button>
            </div>
            <!-- FIN Grupo de botones -->
        </div>
        <div class="col-sm-6">
            <!-- Tabla Control Prenatal -->
            <table class="table table-hover table-sm" id="tbcontrolprenatal">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Fortalecimiento de la demanda inducida, con el fin de organizar, incentivar
                         y orientar a la población hacia la utilización de los servicios y la adherencia
                         al programa de control prenatal.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Intervención en la captación temprana de las gestantes, garantizando el tamizaje oportuno,
                         diagnóstico temprano y seguimiento de las alteraciones propias del embarazo</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Orientar al efectivo cumplimiento de las actividades, procedimientos e intervenciones definidos
                         en la Ruta de Atención Integral  Materno perinatal, verificando la adherencia a las RIAS en la
                          red de prestación de servicios.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Auditorías de calidad a la de la adherencia de la RIAS materno perinatal  con abordaje de género
                         intercultural y de derechos humanos en la red de prestación de servicios.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Seguimiento estricto e individualizado las gestantes de alto riesgo obstétrico.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Aumentar cobertura de los programas de control prenatal y planificación familiar.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Producción e implementación de base de datos con generación de alertas sujetas a guía 
                        de las RIAS Materno Perinatal.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Educación en salud contínua a las gestantes, compañero y familia sobre el proceso de gestación
                         y los signos de alarma.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>En el departamento de Chocó, las gestantes con dificultad para el acceso a los servicios de salud
                         o residen en área rural dispersa, son trasladadas a Casa de Paso de la cabecera municipal, para 
                         brindar atención oportuna con el objetivo de disminuir los riesgos en esta población.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Promocionar la lactancia materna exclusiva y complementaria dando a conocer los beneficios en la calidad
                         de vida de los menores de dos años de edad, economía del hogar, impacto ambiental, entre otros.</td>
                    </tr>
                    <tr>
                    <th scope="row">Control prenatal</th>
                    <td>Educación en salud sexual y reproductiva con enfoque de pareja en la aplicación de tratamiento de infecciones
                         de transmisión sexual para evitar reinfecciones.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Control Prenatal -->
            <!-- Tabla Control Riesgo Cardiovascular -->
            <table class="table table-hover table-sm" id="tbriesgocardiovascular" style="display:none;">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Riesgo Cardiovascular</th>
                    <td>Inducir a la población objeto a acudir de manera oportuna a citas y realización de laboratorios de control
                         para cumplir con vigilancia de la patología.</td>
                    </tr>
                    <tr>
                    <th scope="row">Riesgo Cardiovascular</th>
                    <td>Realizar auditoria a la adherencia de RIAS de Riesgo Cardiovascular a la red de prestación de servicios.</td>
                    </tr>
                    <tr>
                    <th scope="row">Riesgo Cardiovascular</th>
                    <td>Intensificación de las actividades de tamizaje en la población a riesgo.</td>
                    </tr>
                    <tr>
                    <th scope="row">Riesgo Cardiovascular</th>
                    <td>Educación en salud promoviendo la reducción de consumo de bebidas azucaradas, sal añadida, productos de alta
                         densidad calórica y por el contrario promocionar el consumo de alimentos saludables, especialmente frutas y
                          verduras.</td>
                    </tr>
                    <tr>
                    <th scope="row">Riesgo Cardiovascular</th>
                    <td>Educación y consejería para la adecuada y segura realización de la actividad física, para la prevención y control
                         de las enfermedades crónicas no trasmisibles.</td>
                    </tr>
                    <tr>
                    <th scope="row">Riesgo Cardiovascular</th>
                    <td>Informar y orientar a nivel colectivo e individual las actividades de promoción y mantenimiento de la salud que
                         permiten disminuir el riesgo de presentar HTA y DM.</td>
                    </tr>
                    <tr>
                    <th scope="row">Riesgo Cardiovascular</th>
                    <td>Estimulación a la asistencia de programas de protección específica y detección temprana de acuerdo a su grupo de edad.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Riesgo Cardiovascular -->
            <!-- Tabla Citologia -->
            <table class="table table-hover table-sm" id="tbcitologia" style="display:none;">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Citología</th>
                    <td>Realización de jornadas para toma de citologías cervicouterina.</td>
                    </tr>
                    <tr>
                    <th scope="row">Citología</th>
                    <td>Incrementar captación de la población de mujeres con edades entre 25 y 69 años, articulando con la institución prestadora
                         de servicios encargadas de ejecutar demanda inducida, la realizacion de búsqueda activa mediante la estrategia casa a casa,
                          medio radial, entre otros.</td>
                    </tr>
                    <tr>
                    <th scope="row">Citología</th>
                    <td>Establecer en pacientes con reporte de citología anormal y con necesidad de realizar colposcopia más biopsia, política de atención
                         sin barrera con el fin de disminuir los tiempos en la oportunidad de la atención para confirmación de diagnóstico precoz
                          y realizar tratamiento oportuno.</td>
                    </tr>
                    <th scope="row">Citología</th>
                    <td>Educación en salud sobre la importancia de la realización de citología cervicouterina para la detección temprana de cáncer de cuello uterino.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Citologia -->
            <!-- Tabla Mamografia -->
            <table class="table table-hover table-sm" id="tbmamografia" style="display:none;">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Mamografía</th>
                    <td>Contratación de servicios ambulatorios para realización de mamografías en zonas geográficas de difícil acceso.</td>
                    </tr>
                    <tr>
                    <th scope="row">Mamografía</th>
                    <td>Socialización y educación de las indicaciones en las cuales se debe realizar la mamografía en las poblaciones étnicas para reducir las barreras
                         culturales.</td>
                    </tr>
                    <tr>
                    <th scope="row">Mamografía</th>
                    <td>Educación en salud sobre la importancia y la técnica adecuada de la realización del autoexamen de mamas y  signos de alarma en todas las mujeres mayores
                         de 20 años.</td>
                    </tr>
                    <tr>
                    <th scope="row">Mamografía</th>
                    <td>Promover la realización de la mamografía como método para la detección temprana de cáncer de mama en mujeres mayores de 50 años de edad.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Mamografia -->
            <!-- Tabla Joven -->
            <table class="table table-hover table-sm" id="tbjoven" style="display:none;">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Fortalecimiento de la inducción a la demanda de los servicios de salud con énfasis en el uso del programa de planificación familiar.</td>
                    </tr>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Fortalecimiento y apoyo al autocuidado en salud con énfasis en educación en derechos sexuales y reproductivos, prevención de embarazos en la adolescencia,
                         prevención de ITS, Prevención del consumo de sustancias psicoactivas, convivencia social, entre otros.</td>
                    </tr>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Valoración de la salud sexual y reproductiva.</td>
                    </tr>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Promover la asesoría, formulación e inserción de métodos anticonceptivos de larga duración (implantes subdérmicos y dispositivos intrauterinos).</td>
                    </tr>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Promoción de la participación de los adolescentes y jóvenes en los servicios de salud amigables.</td>
                    </tr>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Promover realización de la citología cervicouterina para la detección temprana de alteraciones en el cuello uterino.</td>
                    </tr>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Promover realización de la citología cervicouterina para la detección temprana de alteraciones en el cuello uterino.</td>
                    </tr>
                    <tr>
                    <th scope="row">Joven</th>
                    <td>Promoción de pruebas de tamizaje para VIH y sífilis en individuos con prácticas sexuales de alto riesgo.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Joven -->
            <!-- Tabla Planificacion Familiar -->
            <table class="table table-hover table-sm" id="tbplaniffamiliar" style="display:none;">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Planificación Familiar</th>
                    <td>Educación en salud sexual y reproductiva con enfoque de pareja en la aplicación de tratamiento de infecciones de transmisión 
                        sexual para evitar reinfecciones.</td>
                    </tr>
                    <tr>
                    <th scope="row">Planificación Familiar</th>
                    <td>Asesoría y entrega efectiva de métodos anticonceptivos.</td>
                    </tr>
                    <tr>
                    <th scope="row">Planificación Familiar</th>
                    <td>Fomentar el uso de métodos anticonceptivos  hormonales, intrauterinos y permanentes, en combinación con el uso de preservativos,
                         para la disminución de infecciones de trasmisión sexual.</td>
                    </tr>
                    <tr>
                    <th scope="row">Planificación Familiar</th>
                    <td>Educación en salud sexual y reproductiva para el goce placentero y autónomo de una sexualidad en libertad.</td>
                    </tr>
                    <tr>
                    <th scope="row">Planificación Familiar</th>
                    <td>Promover realización de citología cervicouterina para detectar oportunamente alteraciones en el cuello uterino.</td>
                    </tr>
                    <tr>
                    <th scope="row">Planificación Familiar</th>
                    <td>Promoción de pruebas de tamizaje para VIH y sífilis en individuos con prácticas sexuales de alto riesgo.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Planificacion Familiar -->
            <!-- Tabla Crecimiento y Desarrollo -->
            <table class="table table-hover table-sm" id="tbcrecimientodesarrollo" style="display:none;">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Seguimiento individual a los niños entre 1 a 5 años con alto riesgo con diagnóstico de Enfermedades potencialmente mortales.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Búsqueda activa de menores de 1 año de edad en las poblaciones con barreras de tipo geográfico y cultural.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Intensificación en el seguimiento de la corte de menores de 6 años para actualización en el sistema nominal del PAI – PAI WEB
                         que no se encuentran conectados al Paiweb.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Aumento de las coberturas del Plan Ampliado de inmunizaciones – PAI.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Educación para la salud de niños y niñas, a sus familias y cuidadores en cuanto a autocuidado, salud oral, maltrato infantil, abuso
                         sexual, hábitos saludables, entre otros.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Promover aplicación de la vacuna contra VPH para la reducción de la incidencia de cáncer de cuello uterino.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Fomentar la lactancia materna exclusiva hasta los 6 meses de edad y la lactancia materna complementaria hasta los 2 años de edad.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Garantizar a la población menor de 10 años el esquema completo de vacunación, de acuerdo a los lineamientos establecidos en el PAI.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Impulsar el uso de los servicios de salud oral y visual, para evitar patologías orales y visuales.</td>
                    </tr>
                    <tr>
                    <th scope="row">Crecimiento y Desarrollo</th>
                    <td>Fomentar la identificación e inscripción de los niñas y niñas en el programa de crecimiento y desarrollo antes del alta médica en donde ocurrió su nacimiento.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Crecimiento y Desarrollo -->
            <!-- Tabla Adulto Mayor -->
            <table class="table table-hover table-sm" id="tbadultomayor" style="display:none;">
                <thead>
                    <tr class="bg-success">
                    <th scope="col"><p style="text-align:center;color:white;">Programa</p></th>
                    <th scope="col"><p style="text-align:center;color:white;">Estrategia</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">Adulto Mayor</th>
                    <td>Realización de exámenes de laboratorios básicos (glicemia, perfil lipídico, creatinina, uroanalisis) para la detección temprana de las alteraciones en este grupo
                         poblacional.</td>
                    </tr>
                    <tr>
                    <th scope="row">Adulto Mayor</th>
                    <td>Educación en salud sobre estilos de vida saludable e instrucciones de la periodicidad para controles por medicina general.</td>
                    </tr>
                    <tr>
                    <th scope="row">Adulto Mayor</th>
                    <td>A las mujeres inducir a la realización de la citología cervicovaginal siguiendo el esquema del grupo de edad correspondiente. De la misma forma a las mayores de 50
                         años sin realización de mamografía, remitir a la realización de la misma.</td>
                    </tr>
                    <tr>
                    <th scope="row">Adulto Mayor</th>
                    <td>En los hombres promover y orientar a la realización de medición de Antígeno Prostático Específico – PSA a partir de los 50 años de edad.</td>
                    </tr>
                    <tr>
                    <th scope="row">Adulto Mayor</th>
                    <td>Promocionar la aplicación de la vacuna contra el virus de la influenza en mayor de 60 años.</td>
                    </tr>
                    <tr>
                    <th scope="row">Adulto Mayor</th>
                    <td>Direccionar a los servicios de salud oral a los adultos sin daño o perdida de dentición por enfermedades prevenibles.</td>
                    </tr>
                    <tr>
                    <th scope="row">Adulto Mayor</th>
                    <td>Inducir a la realización de examen de agudeza visual.</td>
                    </tr>
                </tbody>
            </table>
            <!-- FIN Tabla Adulto Mayor -->
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
</body>
<!-- Footer -->
<footer id="sticky-footer" class="py-4 bg-success text-white">
    <div class="container text-center">
    <strong>Gerencia de Riesgos</strong><br>
      <small>Copyright &copy; AMBUQ 2019</small>
      <p style="font-size:10px;">Jean C. Del Portillo</p>
    </div>
</footer>
<!-- FIN Footer -->
<!-- Funciones mostrar tablas -->
<script>
function showTbControlPrenatal(){
    document.getElementById('tbcontrolprenatal').style.display = 'block';
    document.getElementById('tbriesgocardiovascular').style.display = 'none';
    document.getElementById('tbcitologia').style.display = 'none';
    document.getElementById('tbmamografia').style.display = 'none';
    document.getElementById('tbjoven').style.display = 'none';
    document.getElementById('tbplaniffamiliar').style.display = 'none';
    document.getElementById('tbcrecimientodesarrollo').style.display = 'none';
    document.getElementById('tbadultomayor').style.display = 'none';
}

function showTbRiesgoCardiovascular(){
    document.getElementById('tbriesgocardiovascular').style.display = 'block';
    document.getElementById('tbcontrolprenatal').style.display = 'none';
    document.getElementById('tbcitologia').style.display = 'none';
    document.getElementById('tbmamografia').style.display = 'none';
    document.getElementById('tbjoven').style.display = 'none';
    document.getElementById('tbplaniffamiliar').style.display = 'none';
    document.getElementById('tbcrecimientodesarrollo').style.display = 'none';
    document.getElementById('tbadultomayor').style.display = 'none';
}

function showTbCitologia(){
    document.getElementById('tbcitologia').style.display = 'block';
    document.getElementById('tbriesgocardiovascular').style.display = 'none';
    document.getElementById('tbcontrolprenatal').style.display = 'none';
    document.getElementById('tbmamografia').style.display = 'none';
    document.getElementById('tbjoven').style.display = 'none';
    document.getElementById('tbplaniffamiliar').style.display = 'none';
    document.getElementById('tbcrecimientodesarrollo').style.display = 'none';
    document.getElementById('tbadultomayor').style.display = 'none';
}

function showTbMamografia(){
    document.getElementById('tbmamografia').style.display = 'block';
    document.getElementById('tbriesgocardiovascular').style.display = 'none';
    document.getElementById('tbcontrolprenatal').style.display = 'none';
    document.getElementById('tbcitologia').style.display = 'none';
    document.getElementById('tbjoven').style.display = 'none';
    document.getElementById('tbplaniffamiliar').style.display = 'none';
    document.getElementById('tbcrecimientodesarrollo').style.display = 'none';
    document.getElementById('tbadultomayor').style.display = 'none';
}

function showTbJoven(){
    document.getElementById('tbjoven').style.display = 'block';
    document.getElementById('tbriesgocardiovascular').style.display = 'none';
    document.getElementById('tbcontrolprenatal').style.display = 'none';
    document.getElementById('tbcitologia').style.display = 'none';
    document.getElementById('tbmamografia').style.display = 'none';
    document.getElementById('tbplaniffamiliar').style.display = 'none';
    document.getElementById('tbcrecimientodesarrollo').style.display = 'none';
    document.getElementById('tbadultomayor').style.display = 'none';
}

function showTbPlanifFamiliar(){
    document.getElementById('tbplaniffamiliar').style.display = 'block';
    document.getElementById('tbriesgocardiovascular').style.display = 'none';
    document.getElementById('tbcontrolprenatal').style.display = 'none';
    document.getElementById('tbcitologia').style.display = 'none';
    document.getElementById('tbmamografia').style.display = 'none';
    document.getElementById('tbjoven').style.display = 'none';
    document.getElementById('tbcrecimientodesarrollo').style.display = 'none';
    document.getElementById('tbadultomayor').style.display = 'none';
}

function showTbCrecimientoDesarrollo(){
    document.getElementById('tbcrecimientodesarrollo').style.display = 'block';
    document.getElementById('tbriesgocardiovascular').style.display = 'none';
    document.getElementById('tbcontrolprenatal').style.display = 'none';
    document.getElementById('tbcitologia').style.display = 'none';
    document.getElementById('tbmamografia').style.display = 'none';
    document.getElementById('tbjoven').style.display = 'none';
    document.getElementById('tbplaniffamiliar').style.display = 'none';
    document.getElementById('tbadultomayor').style.display = 'none';
}

function showTbAdultoMayor(){
    document.getElementById('tbadultomayor').style.display = 'block';
    document.getElementById('tbriesgocardiovascular').style.display = 'none';
    document.getElementById('tbcontrolprenatal').style.display = 'none';
    document.getElementById('tbcitologia').style.display = 'none';
    document.getElementById('tbmamografia').style.display = 'none';
    document.getElementById('tbjoven').style.display = 'none';
    document.getElementById('tbplaniffamiliar').style.display = 'none';
    document.getElementById('tbcrecimientodesarrollo').style.display = 'none';
}

</script>
</html>