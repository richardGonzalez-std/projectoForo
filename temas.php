<body>
<?php
include "db.php";
include "menu.php";

// Validar y sanitizar el parámetro GET
if (!isset($_GET['cual']) || !is_numeric($_GET['cual'])) {
    echo "<p>Error: ID de tema inválido.</p>";
    echo "<a href='foro.php'>Volver al foro</a>";
    exit;
}

$tema_id = (int)$_GET['cual'];

// Obtener información del tema con prepared statement
$sql = "SELECT ID, Titulo, Tema, autor, fecha, Hora FROM tema WHERE ID = :id";
try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $tema_id]);
    $ver = $stmt->fetch(PDO::FETCH_ARRAY);
    
    if (!$ver) {
        echo "<p>Error: Tema no encontrado.</p>";
        echo "<a href='foro.php'>Volver al foro</a>";
        exit;
    }
} catch(PDOException $e) {
    echo "<p>Error al cargar el tema: " . $e->getMessage() . "</p>";
    exit;
}
?>

<div style="margin: 20px;">
    <h2>Detalles del Tema</h2>
    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; background-color: #f9f9f9;">
        <p><strong>Título:</strong> <?php echo htmlspecialchars($ver[1]); ?><br />
        <strong>Autor:</strong> <?php echo htmlspecialchars($ver[3]); ?><br />
        <strong>Fecha:</strong> <?php echo htmlspecialchars($ver[4]); ?><br />
        <strong>Hora:</strong> <?php echo htmlspecialchars($ver[5]); ?><br />
        <strong>Contenido:</strong> <?php echo nl2br(htmlspecialchars($ver[2])); ?></p>
    </div>
</div>

<div style="margin: 20px;">
    <h3>Responder al tema</h3>
    <form id="form1" name="form1" method="post" action="agregar_respuesta.php">
        <table border="1" style="border-collapse: collapse;">
            <tr>
                <td><label for="respuesta">Respuesta:</label></td>
                <td><textarea name="respuesta" id="respuesta" cols="45" rows="5" required></textarea></td>
            </tr>
            <tr>
                <td><label for="autor">Autor:</label></td>
                <td>
                    <input type="text" name="autor" id="autor" required />
                    <input name="oculto" type="hidden" id="oculto" value="<?php echo htmlspecialchars($ver[0]); ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="button" id="button" value="Responder" />
                </td>
            </tr>
        </table>
    </form>
</div>

<div style="margin: 20px;">
    <h3>Respuestas del tema</h3>
    <?php 
    // Obtener respuestas con prepared statement
    $sql2 = "SELECT ID, id_tema, Autor, Fecha, Respuesta FROM respuesta WHERE id_tema = :id_tema ORDER BY ID DESC";
    try {
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->execute([':id_tema' => $ver[0]]);
        
        $respuestas_count = 0;
        while($ver2 = $stmt2->fetch(PDO::FETCH_ARRAY)) {
            $respuestas_count++;
    ?>
        <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 15px; background-color: #ffffff;">
            <p><strong>Respuesta #<?php echo $respuestas_count; ?></strong><br>
            <strong>Autor:</strong> <?php echo htmlspecialchars($ver2[2]); ?><br>
            <strong>Fecha:</strong> <?php echo htmlspecialchars($ver2[3]); ?><br>
            <strong>Respuesta:</strong> <?php echo nl2br(htmlspecialchars($ver2[4])); ?></p>
        </div>
    <?php 
        }
        
        if ($respuestas_count == 0) {
            echo "<p><em>No hay respuestas aún. ¡Sé el primero en responder!</em></p>";
        }
        
    } catch(PDOException $e) {
        echo "<p>Error al cargar las respuestas: " . $e->getMessage() . "</p>";
    }
    ?>
</div>

<div style="margin: 20px; text-align: center;">
    <a href="foro.php" style="text-decoration: none; background-color: #007cba; color: white; padding: 10px 20px; border-radius: 5px;">← Volver al Foro</a>
</div>

</body>