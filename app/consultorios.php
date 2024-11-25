<?php
// Conexión a la base de datos
$host = "clinica.cvhmfndeld5j.us-east-1.rds.amazonaws.com";
$user = "admin"; // Usuario por defecto en XAMPP
$pass = getenv('BDD_PASS'); // Contraseña vacía por defecto
$db = "clinica"; // Cambiar al nombre de tu base de datos

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de acciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear nuevo consultorio
    if (isset($_POST['crear'])) {
        $nombre = $_POST['nombre'];

        $sql = "INSERT INTO consultorios (nombre) VALUES ('$nombre')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Consultorio creado exitosamente.</p>";
        } else {
            echo "<p>Error al crear consultorio: " . $conn->error . "</p>";
        }
    }

    // Actualizar consultorio
    if (isset($_POST['actualizar'])) {
        $id_consultorio = $_POST['id_consultorio'];
        $nombre = $_POST['nombre'];

        $sql = "UPDATE consultorios SET nombre = '$nombre' WHERE id_consultorio = '$id_consultorio'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Consultorio actualizado exitosamente.</p>";
        } else {
            echo "<p>Error al actualizar consultorio: " . $conn->error . "</p>";
        }
    }

    // Eliminar consultorio
    if (isset($_POST['eliminar'])) {
        $id_consultorio = $_POST['id_consultorio'];

        $sql = "DELETE FROM consultorios WHERE id_consultorio = '$id_consultorio'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Consultorio eliminado exitosamente.</p>";
        } else {
            echo "<p>Error al eliminar consultorio: " . $conn->error . "</p>";
        }
    }
}

// Leer todos los consultorios
$consultorios = $conn->query("SELECT * FROM consultorios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Consultorios</title>
    <style>
        nav {
            background-color: #0056b3; /* Fondo azul oscuro */
            padding: 10px 0;
        }
        nav ul {
            list-style: none; /* Elimina las viñetas */
            margin: 0;
            padding: 0;
            display: flex; /* Muestra los elementos en una fila horizontal */
            justify-content: center; /* Centra los elementos en el menú */
            gap: 20px; /* Espaciado entre las opciones */
        }
        nav ul li {
            margin: 0; /* Asegura que no haya márgenes adicionales */
        }
        nav ul li a {
            color: white; /* Texto blanco */
            text-decoration: none; /* Elimina el subrayado de los enlaces */
            font-size: 16px; /* Tamaño de letra */
            font-weight: bold; /* Texto en negrita */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 4px; /* Bordes ligeramente redondeados */
            transition: background-color 0.3s ease, transform 0.2s ease; /* Animación suave */
        }
        nav ul li a:hover {
            background-color: #003f8a; /* Cambia el fondo al pasar el cursor */
            transform: scale(1.1); /* Amplía ligeramente el botón al pasar el cursor */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container input, .form-container button {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Gestión de Consultorios</h1>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="consultas.php">Consultas</a></li>
                <li><a href="doctores.php">Doctores</a></li>
                <li><a href="pacientes.php">Pacientes</a></li>
                <li><a href="consultorios.php">Consultorios</a></li>
            </ul>
        </nav>
    </header>
    <!-- Mostrar consultorios -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $consultorios->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id_consultorio']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_consultorio" value="<?php echo $fila['id_consultorio']; ?>">
                            <button type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulario para Crear/Actualizar consultorio -->
    <div class="form-container">
        <form method="POST">
            <input type="hidden" name="id_consultorio">
            <input type="text" name="nombre" placeholder="Nombre del Consultorio" required>
            <button type="submit" name="crear">Crear</button>
            <button type="submit" name="actualizar">Actualizar</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
<?php
// Conexión a la base de datos
$host = "clinica.cvhmfndeld5j.us-east-1.rds.amazonaws.com";
$user = "admin"; // Usuario por defecto en XAMPP
$pass = getenv('BDD_PASS'); // Contraseña vacía por defecto
$db = "clinica"; // Cambiar al nombre de tu base de datos

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de acciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear nueva consulta
    if (isset($_POST['crear'])) {
        $id_doctor = $_POST['id_doctor'];
        $id_paciente = $_POST['id_paciente'];
        $id_consultorio = $_POST['id_consultorio'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $motivo = $_POST['motivo'];
        $diagnostico = $_POST['diagnostico'];
        $tratamiento = $_POST['tratamiento'];

        $sql = "INSERT INTO consultas (id_doctor, id_paciente, id_consultorio, fecha, hora, motivo, diagnostico, tratamiento)
                VALUES ('$id_doctor', '$id_paciente', '$id_consultorio', '$fecha', '$hora', '$motivo', '$diagnostico', '$tratamiento')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Consulta creada exitosamente.</p>";
        } else {
            echo "<p>Error al crear consulta: " . $conn->error . "</p>";
        }
    }

    // Actualizar consulta
    if (isset($_POST['actualizar'])) {
        $id_consulta = $_POST['id_consulta'];
        $id_doctor = $_POST['id_doctor'];
        $id_paciente = $_POST['id_paciente'];
        $id_consultorio = $_POST['id_consultorio'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $motivo = $_POST['motivo'];
        $diagnostico = $_POST['diagnostico'];
        $tratamiento = $_POST['tratamiento'];

        $sql = "UPDATE consultas 
                SET id_doctor = '$id_doctor', id_paciente = '$id_paciente', id_consultorio = '$id_consultorio', 
                    fecha = '$fecha', hora = '$hora', motivo = '$motivo', diagnostico = '$diagnostico', tratamiento = '$tratamiento'
                WHERE id_consulta = '$id_consulta'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Consulta actualizada exitosamente.</p>";
        } else {
            echo "<p>Error al actualizar consulta: " . $conn->error . "</p>";
        }
    }

    // Eliminar consulta
    if (isset($_POST['eliminar'])) {
        $id_consulta = $_POST['id_consulta'];

        $sql = "DELETE FROM consultas WHERE id_consulta = '$id_consulta'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Consulta eliminada exitosamente.</p>";
        } else {
            echo "<p>Error al eliminar consulta: " . $conn->error . "</p>";
        }
    }
}

// Leer todas las consultas
$consultas = $conn->query("SELECT * FROM consultas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Consultas</title>
    <style>
        nav {
            background-color: #0056b3; /* Fondo azul oscuro */
            padding: 10px 0;
        }
        nav ul {
            list-style: none; /* Elimina las viñetas */
            margin: 0;
            padding: 0;
            display: flex; /* Muestra los elementos en una fila horizontal */
            justify-content: center; /* Centra los elementos en el menú */
            gap: 20px; /* Espaciado entre las opciones */
        }
        nav ul li {
            margin: 0; /* Asegura que no haya márgenes adicionales */
        }
        nav ul li a {
            color: white; /* Texto blanco */
            text-decoration: none; /* Elimina el subrayado de los enlaces */
            font-size: 16px; /* Tamaño de letra */
            font-weight: bold; /* Texto en negrita */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 4px; /* Bordes ligeramente redondeados */
            transition: background-color 0.3s ease, transform 0.2s ease; /* Animación suave */
        }
        nav ul li a:hover {
            background-color: #003f8a; /* Cambia el fondo al pasar el cursor */
            transform: scale(1.1); /* Amplía ligeramente el botón al pasar el cursor */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container input, .form-container textarea, .form-container button {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Gestión de Consultas</h1>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="consultas.php">Consultas</a></li>
                <li><a href="doctores.php">Doctores</a></li>
                <li><a href="pacientes.php">Pacientes</a></li>
                <li><a href="consultorios.php">Consultorios</a></li>
            </ul>
        </nav>
    </header>
    <!-- Mostrar consultas -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Paciente</th>
                <th>Consultorio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Motivo</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $consultas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id_consulta']; ?></td>
                    <td><?php echo $fila['id_doctor']; ?></td>
                    <td><?php echo $fila['id_paciente']; ?></td>
                    <td><?php echo $fila['id_consultorio']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td><?php echo $fila['hora']; ?></td>
                    <td><?php echo $fila['motivo']; ?></td>
                    <td><?php echo $fila['diagnostico']; ?></td>
                    <td><?php echo $fila['tratamiento']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_consulta" value="<?php echo $fila['id_consulta']; ?>">
                            <button type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulario para Crear/Actualizar consulta -->
    <div class="form-container">
        <form method="POST">
            <input type="hidden" name="id_consulta">
            <input type="text" name="id_doctor" placeholder="ID Doctor" required>
            <input type="text" name="id_paciente" placeholder="ID Paciente" required>
            <input type="text" name="id_consultorio" placeholder="ID Consultorio" required>
            <input type="date" name="fecha" required>
            <input type="time" name="hora" required>
            <textarea name="motivo" placeholder="Motivo" required></textarea>
            <textarea name="diagnostico" placeholder="Diagnóstico" required></textarea>
            <textarea name="tratamiento" placeholder="Tratamiento" required></textarea>
            <button type="submit" name="crear">Crear</button>
            <button type="submit" name="actualizar">Actualizar</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
