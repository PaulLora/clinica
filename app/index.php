<?php
// Conexión a la base de datos
$host = "clinica.cvhmfndeld5j.us-east-1.rds.amazonaws.com";
$user = "admin"; // Usuario por defecto en XAMPP
$pass = getenv('BDD_PASS');// Contraseña vacía por defecto
$db = "clinica"; // Cambiar al nombre de tu base de datos
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultas SQL para obtener un paciente, un doctor, un consultorio y una consulta
$paciente = $conn->query("SELECT * FROM pacientes LIMIT 1")->fetch_assoc();
$doctor = $conn->query("SELECT * FROM doctores LIMIT 1")->fetch_assoc();
$consultorio = $conn->query("SELECT * FROM consultorios LIMIT 1")->fetch_assoc();
$consulta = $conn->query("SELECT * FROM consultas LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica - Resumen</title>
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
            padding: 0;
            background-color: #f5f5f5;
        }
        header, footer {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin: 0 0 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Clínica - Resumen de Información</h1>
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

    <!-- Contenido -->
    <div class="container">
        <!-- Paciente -->
        <div class="card">
            <h3>Paciente</h3>
            <p><strong>Nombre:</strong> <?php echo $paciente['nombre']; ?></p>
            <p><strong>Género:</strong> <?php echo $paciente['genero']; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $paciente['telefono']; ?></p>
        </div>

        <!-- Doctor -->
        <div class="card">
            <h3>Doctor</h3>
            <p><strong>Nombre:</strong> <?php echo $doctor['nombre']; ?></p>
            <p><strong>Especialidad:</strong> <?php echo $doctor['especialidad']; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $doctor['telefono']; ?></p>
        </div>

        <!-- Consultorio -->
        <div class="card">
            <h3>Consultorio</h3>
            <p><strong>Nombre:</strong> <?php echo $consultorio['nombre']; ?></p>
        </div>

        <!-- Consulta -->
        <div class="card">
            <h3>Consulta</h3>
            <p><strong>Fecha:</strong> <?php echo $consulta['fecha']; ?></p>
            <p><strong>Motivo:</strong> <?php echo $consulta['motivo']; ?></p>
            <p><strong>Diagnóstico:</strong> <?php echo $consulta['diagnostico']; ?></p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Clínica - Todos los derechos reservados.</p>
    </footer>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
