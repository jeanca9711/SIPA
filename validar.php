<?php
session_start();
include('conexion.php'); //Llamamos la conexion a la BD

$usuario=$_POST['usuario'];
$_SESSION['usuario'] = $usuario;
$contrasena=$_POST['contrasena'];

 //$conec=oci_connect($user, $pass, 'localhost/xe');
$consulta="select * from USUARIOS where EMAIL=upper ('$usuario') and CONTRASENA='$contrasena'";//Consulta select a la BD
$ejecutar = oci_parse($conexion,$consulta);
 
oci_execute($ejecutar);//Ejecutamos codigo

$depend=oci_fetch_array($ejecutar,OCI_ASSOC+OCI_RETURN_NULLS);
if ($depend!=null) {
        header("location:index.php?op=1");
}else{
        session_destroy();
        echo "<script>alert('Usuario y/o Contraseña incorrectos.');
        window.location='index.php'</script>";
}
oci_free_statement($ejecutar);
oci_close($conexion);
?>

