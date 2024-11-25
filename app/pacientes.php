<?php
// Conexión a la base de datos
$host = "clinica.cvhmfndeld5j.us-east-1.rds.amazonaws.com";
$user = "admin";
$pass = getenv('BDD_PASS');
$db = "clinica";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de acciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear nuevo paciente
    if (isset($_POST['crear'])) {
        $nombre = $_POST['nombre'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        $sql = "INSERT INTO pacientes (nombre, fecha_nacimiento, telefono, email)
                VALUES ('$nombre', '$fecha_nacimiento', '$telefono', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Paciente creado exitosamente.</p>";
        } else {
            echo "<p>Error al crear paciente: " . $conn->error . "</p>";
        }
    }

    // Actualizar paciente
    if (isset($_POST['actualizar'])) {
        $id_paciente = $_POST['id_paciente'];
        $nombre = $_POST['nombre'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        $sql = "UPDATE pacientes 
                SET nombre = '$nombre', fecha_nacimiento = '$fecha_nacimiento', telefono = '$telefono', email = '$email'
                WHERE id_paciente = '$id_paciente'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Paciente actualizado exitosamente.</p>";
        } else {
            echo "<p>Error al actualizar paciente: " . $conn->error . "</p>";
        }
    }

    // Eliminar paciente
    if (isset($_POST['eliminar'])) {
        $id_paciente = $_POST['id_paciente'];

        $sql = "DELETE FROM pacientes WHERE id_paciente = '$id_paciente'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Paciente eliminado exitosamente.</p>";
        } else {
            echo "<p>Error al eliminar paciente: " . $conn->error . "</p>";
        }
    }
}

// Leer todos los pacientes
$pacientes = $conn->query("SELECT * FROM pacientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Pacientes</title>
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
    <h1>Gestión de Pacientes</h1>
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
    <!-- Mostrar pacientes -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $pacientes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id_paciente']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['fecha_nacimiento']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_paciente" value="<?php echo $fila['id_paciente']; ?>">
                            <button type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulario para Crear/Actualizar paciente -->
    <div class="form-container">
        <form method="POST">
            <input type="hidden" name="id_paciente">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="date" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="email" name="email" placeholder="Email" required>
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
