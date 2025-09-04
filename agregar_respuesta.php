<?php
include "db.php";

// Validar que los datos POST existan y no estén vacíos
if (!isset($_POST['oculto']) || !isset($_POST['respuesta']) || !isset($_POST['autor'])) {
    echo "<p>Error: Faltan datos requeridos.</p>";
    echo "<meta http-equiv='refresh' content='3;URL=foro.php' />";
    exit;
}

// Validar y sanitizar datos
$tema_id = filter_var($_POST['oculto'], FILTER_VALIDATE_INT);
$respuesta = trim($_POST['respuesta']);
$autor = trim($_POST['autor']);

// Validar que el ID del tema sea válido
if ($tema_id === false || $tema_id <= 0) {
    echo "<p>Error: ID de tema inválido.</p>";
    echo "<meta http-equiv='refresh' content='3;URL=foro.php' />";
    exit;
}

// Validar que los campos no estén vacíos
if (empty($respuesta) || empty($autor)) {
    echo "<p>Error: La respuesta y el autor son obligatorios.</p>";
    echo "<meta http-equiv='refresh' content='3;URL=temas.php?cual=" . $tema_id . "' />";
    exit;
}

// Validar longitudes máximas
if (strlen($autor) > 100) {
    echo "<p>Error: El nombre del autor es demasiado largo (máximo 100 caracteres).</p>";
    echo "<meta http-equiv='refresh' content='3;URL=temas.php?cual=" . $tema_id . "' />";
    exit;
}

if (strlen($respuesta) > 2000) {
    echo "<p>Error: La respuesta es demasiado larga (máximo 2000 caracteres).</p>";
    echo "<meta http-equiv='refresh' content='3;URL=temas.php?cual=" . $tema_id . "' />";
    exit;
}

// Verificar que el tema existe antes de insertar la respuesta
$sql_check = "SELECT ID FROM tema WHERE ID = :tema_id";
try {
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->execute([':tema_id' => $tema_id]);
    
    if (!$stmt_check->fetch()) {
        echo "<p>Error: El tema no existe.</p>";
        echo "<meta http-equiv='refresh' content='3;URL=foro.php' />";
        exit;
    }
} catch(PDOException $e) {
    echo "<p>Error al verificar el tema.</p>";
    error_log("Error al verificar tema: " . $e->getMessage());
    echo "<meta http-equiv='refresh' content='3;URL=foro.php' />";
    exit;
}

// Obtener fecha actual
$fecha = date("Y-m-d H:i:s");

// Insertar respuesta con prepared statement (PDO)
$sql = "INSERT INTO respuesta (ID, id_tema, Respuesta, Autor, Fecha) VALUES (NULL, :id_tema, :respuesta, :autor, :fecha)";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':id_tema' => $tema_id,
        ':respuesta' => $respuesta,
        ':autor' => $autor,
        ':fecha' => $fecha
    ]);
    
    echo "<p style='color: green; text-align: center;'>¡Respuesta agregada con éxito!</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red; text-align: center;'>Error: No se pudo agregar la respuesta. Estamos en mantenimiento.</p>";
    // En desarrollo, puedes mostrar el error: echo $e->getMessage();
    error_log("Error al insertar respuesta: " . $e->getMessage());
}
?>

<meta http-equiv="refresh" content="2;URL=temas.php?cual=<?php echo htmlspecialchars($tema_id); ?>" />