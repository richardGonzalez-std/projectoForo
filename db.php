<?php
// db.php - Configuración SQLite para Docker/Render
try {
    $dbPath = '/var/www/html/foro.db';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Crear tabla 'tema' (convertida de MySQL a SQLite)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tema (
            ID INTEGER PRIMARY KEY AUTOINCREMENT,
            Titulo VARCHAR(30) NOT NULL,
            Tema VARCHAR(100) NOT NULL,
            autor VARCHAR(30) NOT NULL,
            fecha DATE NOT NULL,
            Hora TIME NOT NULL
        )
    ");
    
    // Crear tabla 'respuesta' (convertida de MySQL a SQLite)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS respuesta (
            ID INTEGER PRIMARY KEY AUTOINCREMENT,
            id_tema VARCHAR(30) NOT NULL,
            Respuesta VARCHAR(30) NOT NULL,
            Autor VARCHAR(30) NOT NULL,
            Fecha DATE NOT NULL
        )
    ");
    
    // Insertar datos de ejemplo (solo si las tablas están vacías)
    $countTemas = $pdo->query("SELECT COUNT(*) FROM tema")->fetchColumn();
    if ($countTemas == 0) {
        // Insertar temas de ejemplo
        $pdo->exec("
            INSERT INTO tema (ID, Titulo, Tema, autor, fecha, Hora) VALUES
            (1, 'Mario', 'contenido contenido', 'richard', '2024-08-16', '11:18:04'),
            (2, 'Mario', 'dppppppo', 'richard', '2024-08-16', '11:19:21'),
            (3, 'Jose', 'Cardio', 'jose', '2024-08-16', '11:21:30')
        ");
        
        // Insertar respuesta de ejemplo
        $pdo->exec("
            INSERT INTO respuesta (ID, id_tema, Respuesta, Autor, Fecha) VALUES
            (1, '3', 'correeeeeee', 'richard', '2024-08-16')
        ");
    }
    
    // Para compatibilidad con código existente que use mysqli
    // Crear wrapper para funciones mysqli comunes
    $conexion = $pdo;
    
    // Función helper para mysqli_query compatibility
    function mysqli_query_compat($pdo, $sql) {
        try {
            return $pdo->query($sql);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // Función helper para mysqli_fetch_assoc compatibility
    function mysqli_fetch_assoc_compat($stmt) {
        if ($stmt) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    // Función helper para mysqli_num_rows compatibility
    function mysqli_num_rows_compat($stmt) {
        if ($stmt) {
            return $stmt->rowCount();
        }
        return 0;
    }
    
} catch(PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
