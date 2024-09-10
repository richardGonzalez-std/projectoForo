<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <?php
        include 'db.php';
        include 'menu.php';

        ?>
        <button id="light_mode">Light Mode</button>
        <br>

<form id="form1" name="form1" method="post" action="">
<table  align ="center">
<tr>
<td><label for="buscar">Temas</label></td>
<td><input type="text" name="buscar" id="buscar" /></td>
<td><input type="submit" name="button" id="button" value="Buscar por temas" /></td>
</tr>
</table>
</form>

<form id="form2" name="form2" method="post" action="">
<table align ="center" >
<tr>
<td><label for="autor">Lista de autores</label></td>
<td>
<select name="autor" id="autor"> 
<?php 
$sql4="select autor from tema group by autor order by autor";
$con4=mysqli_query($conexion,$sql4);
while($autor=mysqli_fetch_array($con4))
{?>
<option value="<?php print $autor[0]; ?>"> <?php print $autor[0]; ?></option>
<?php }?>
</select>
</td>

<td><input type="submit" name="button2" id="button2" value="Buscar" /></td>

</tr>
</table>
</form>

<br>
<table id="foro" width="600" border="1" align ="center">
<tr>
<td width="271" align="center">Temas</td>
<td width="75" align="center">Autor</td>
<td width="89" align="center">Fecha</td>
<td width="68" align="center">Respuestas</td>
</tr>
<?php 
if(@$_POST['buscar'])
{ 
$sql="select id,titulo,autor,fecha from tema where (titulo like '%$_POST[buscar]%' or Tema like '%$_POST[buscar]%') order by id desc";
}
else if(@$_POST['autor'])
{
$sql="select id,titulo,autor,fecha from tema where autor='$_POST[autor]' order by id desc";
} 
else
{ 
$sql="select id,titulo,autor,fecha from tema order by id desc";
}
$con=mysqli_query($conexion,$sql);
while($ver=mysqli_fetch_array($con)){
?> <tr> 
<td><a href="temas.php?cual=<?php print $ver[0]?>"><?php print $ver[1]?></a></td>
<td align="center"><?php print $ver[2]?></td>
<td align="center"><?php print $ver[3]?></td>
<td align="center">

<?php 
$sql2="select id from respuesta where id_tema='$ver[0]'";
$filas=mysqli_query($conexion,$sql2);
print mysqli_num_rows($filas);
?>
</td>
</tr><?php }?>
</table>
<script>
            document.getElementById('light_mode').addEventListener('click', function () {
    document.body.classList.toggle('light-mode');

    // Cambiar el texto del botón según el modo actual
    if (document.body.classList.contains('light-mode')) {
        this.textContent = 'Dark Mode';
    } else {
        this.textContent = 'Light Mode';
    }
});
        </script>
    </body>
</html>