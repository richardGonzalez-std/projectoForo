<?php
include "db.php";
$fecha=date("Y-m-d");
$hora=date("h:i:s a");
$sql="insert into respuesta value('','$_POST[oculto]','$_POST[respuesta]','$_POST[autor]','$fecha')";
if(mysqli_query($conexion,$sql))
{
print "se inserto con exito";
}
else
{
print "Estamos en mantenimiento";
}
?>
<meta http-equiv="refresh" content="2;URL=temas.php?cual=<?php print $_POST['oculto']; ?>" />