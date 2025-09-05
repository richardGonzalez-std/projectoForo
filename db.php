<?php
// db.php - Configuración PostgreSQL para Render

$host = "dpg-d2thgker433s73de7d80-a";
$port = "5432";
$dbname = "forodb_wms8";
$user = "forodb_wms8_user";
$password = "1DopdhqCrrNEitTqjRysSwlB8vGqXkqK";

try {
    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ⚠️ IMPORTANTE: En PostgreSQL no uses AUTOINCREMENT, se usa SERIAL o IDENTITY
    $conexion->exec("
        CREATE TABLE IF NOT EXISTS tema (
            ID SERIAL PRIMARY KEY,
            Titulo VARCHAR(100) NOT NULL,
            Tema TEXT NOT NULL,
            autor VARCHAR(50) NOT NULL,
            fecha DATE NOT NULL,
            Hora TIME NOT NULL
        );
    ");

    $conexion->exec("
        CREATE TABLE IF NOT EXISTS respuesta (
            ID SERIAL PRIMARY KEY,
            id_tema INT NOT NULL REFERENCES tema(ID) ON DELETE CASCADE,
            Respuesta TEXT NOT NULL,
            Autor VARCHAR(50) NOT NULL,
            Fecha DATE NOT NULL
        );
    ");

} catch (PDOException $e) {
    die("Error de conexión a PostgreSQL: " . $e->getMessage());
}
?>
