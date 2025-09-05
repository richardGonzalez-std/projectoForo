<?php
include "db.php";

// Validar que los datos POST existan y no estén vacíos
if (!isset($_POST['titulo']) || !isset($_POST['contenido']) || !isset($_POST['autor'])) {
    echo "<p>Error: Faltan datos requeridos.</p>";
    echo "<meta http-equiv='refresh' content='3;URL=agregar_temas.php' />";
    exit;
}

// Validar que no estén vacíos
$titulo = trim($_POST['titulo']);
$contenido = trim($_POST['contenido']);
$autor = trim($_POST['autor']);

if (empty($titulo) || empty($contenido) || empty($autor)) {
    echo "<p>Error: Todos los campos son obligatorios.</p>";
    echo "<meta http-equiv='refresh' content='3;URL=agregar_temas.php' />";
    exit;
}

// Validar longitudes máximas
if (strlen($titulo) > 255) {
    echo "<p>Error: El título es demasiado largo (máximo 255 caracteres).</p>";
    echo "<meta http-equiv='refresh' content='3;URL=agregar_temas.php' />";
    exit;
}

if (strlen($autor) > 100) {
    echo "<p>Error: El nombre del autor es demasiado largo (máximo 100 caracteres).</p>";
    echo "<meta http-equiv='refresh' content='3;URL=agregar_temas.php' />";
    exit;
}

if (strlen($contenido) > 2000) {
    echo "<p>Error: El contenido es demasiado largo (máximo 2000 caracteres).</p>";
    echo "<meta http-equiv='refresh' content='3;URL=agregar_temas.php' />";
    exit;
}

// Obtener fecha y hora
$fecha = date("Y-m-d");
$hora = date("H:i:s");

// Insertar con prepared statement (PDO)
$sql = "INSERT INTO tema ( Titulo, Tema, autor, fecha, Hora) VALUES ( :titulo, :contenido, :autor, :fecha, :hora)";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':contenido' => $contenido, 
        ':autor' => $autor,
        ':fecha' => $fecha,
        ':hora' => $hora
    ]);
    
    echo "<p style='color: green; text-align: center;'>¡Tema creado con éxito!</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red; text-align: center;'>Error: No se pudo crear el tema. Estamos en mantenimiento.</p>";
    // En desarrollo, puedes mostrar el error: echo $e->getMessage();
    error_log("Error al insertar tema: " . $e->getMessage());
}
?>

<meta http-equiv="refresh" content="3;URL=index.php" />