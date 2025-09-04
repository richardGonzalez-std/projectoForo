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
        // Convertido a PDO con prepared statement
        $sql4 = "SELECT autor FROM tema GROUP BY autor ORDER BY autor";
        try {
            $stmt4 = $conexion->query($sql4);
            while($autor = $stmt4->fetch(PDO::FETCH_ARRAY)) {
        ?>
        <option value="<?php echo htmlspecialchars($autor[0]); ?>"> <?php echo htmlspecialchars($autor[0]); ?></option>
        <?php 
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
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
        // Convertido a PDO con prepared statements para mayor seguridad
        if(isset($_POST['buscar']) && !empty($_POST['buscar'])) { 
            $buscar = $_POST['buscar'];
            $sql = "SELECT ID, Titulo, autor, fecha FROM tema WHERE (Titulo LIKE :buscar1 OR Tema LIKE :buscar2) ORDER BY ID DESC";
            $stmt = $conexion->prepare($sql);
            $searchTerm = '%' . $buscar . '%';
            $stmt->execute([
                ':buscar1' => $searchTerm,
                ':buscar2' => $searchTerm
            ]);
        } else if(isset($_POST['autor']) && !empty($_POST['autor'])) {
            $autorBuscar = $_POST['autor'];
            $sql = "SELECT ID, Titulo, autor, fecha FROM tema WHERE autor = :autor ORDER BY ID DESC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':autor' => $autorBuscar]);
        } else { 
            $sql = "SELECT ID, Titulo, autor, fecha FROM tema ORDER BY ID DESC";
            $stmt = $conexion->query($sql);
        }

        try {
            while($ver = $stmt->fetch(PDO::FETCH_ARRAY)) {
        ?> 
        <tr> 
        <td><a href="temas.php?cual=<?php echo htmlspecialchars($ver[0]); ?>"><?php echo htmlspecialchars($ver[1]); ?></a></td>
        <td align="center"><?php echo htmlspecialchars($ver[2]); ?></td>
        <td align="center"><?php echo htmlspecialchars($ver[3]); ?></td>
        <td align="center">

        <?php 
        // Convertido a PDO para contar respuestas
        $sql2 = "SELECT COUNT(*) as total FROM respuesta WHERE id_tema = :id_tema";
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->execute([':id_tema' => $ver[0]]);
        $resultado = $stmt2->fetch(PDO::FETCH_ASSOC);
        echo $resultado['total'];
        ?>
        </td>
        </tr>
        <?php 
            }
        } catch(PDOException $e) {
            echo "<tr><td colspan='4'>Error al cargar los temas: " . $e->getMessage() . "</td></tr>";
        }
        ?>
        </table>

        <script>
            document.querySelector('#light_mode').addEventListener('click',function(){
                console.log("this is working");
            });
        </script>
    </body>
</html>