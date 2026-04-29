<?php
// ===============================
// CONFIGURACIÓN BASE DE DATOS
// ===============================
$host = "mysql-trainee115.alwaysdata.net";
$user = "trainee115";
$password = "clase1234";
$database = "trainee115_gestionusuariosd";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// ===============================
// CREAR USUARIO
// ===============================
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];

    $sql = "INSERT INTO usuarios (nombre, cedula, telefono) VALUES ('$nombre', '$cedula', '$telefono')";
    $conn->query($sql);
    header("Location: index.php");
}

// ===============================
// ELIMINAR USUARIO
// ===============================
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM usuarios WHERE id=$id");
    header("Location: index.php");
}

// ===============================
// ACTUALIZAR USUARIO
// ===============================
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];

    $sql = "UPDATE usuarios SET nombre='$nombre', cedula='$cedula', telefono='$telefono' WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}

// ===============================
// OBTENER DATOS PARA EDITAR
// ===============================
$editar = false;
$usuarioEditar = null;

if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $resultado = $conn->query("SELECT * FROM usuarios WHERE id=$id");
    $usuarioEditar = $resultado->fetch_assoc();
    $editar = true;
}

// ===============================
// LISTAR USUARIOS
// ===============================
$usuarios = $conn->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 30px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            grid-column: span 3;
            padding: 12px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #007bff;
            color: white;
        }

        .btn-editar {
            background: orange;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-eliminar {
            background: red;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-editar:hover {
            background: darkorange;
        }

        .btn-eliminar:hover {
            background: darkred;
        }

        @media(max-width:768px) {
            form {
                grid-template-columns: 1fr;
            }

            button {
                grid-column: span 1;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestión de Usuarios</h1>

    <form method="POST" id="formularioUsuario">
        <?php if ($editar): ?>
            <input type="hidden" name="id" value="<?php echo $usuarioEditar['id']; ?>">
        <?php endif; ?>

        <input type="text" name="nombre" placeholder="Nombre completo" required
            value="<?php echo $editar ? $usuarioEditar['nombre'] : ''; ?>">

        <input type="text" name="cedula" placeholder="Cédula" required
            value="<?php echo $editar ? $usuarioEditar['cedula'] : ''; ?>">

        <input type="text" name="telefono" placeholder="Teléfono" required
            value="<?php echo $editar ? $usuarioEditar['telefono'] : ''; ?>">

        <?php if ($editar): ?>
            <button type="submit" name="actualizar">Actualizar Usuario</button>
        <?php else: ?>
            <button type="submit" name="crear">Crear Usuario</button>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($fila = $usuarios->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['cedula']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td>
                        <a class="btn-editar" href="?editar=<?php echo $fila['id']; ?>">Editar</a>
                        <a class="btn-eliminar" href="?eliminar=<?php echo $fila['id']; ?>" onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById("formularioUsuario").addEventListener("submit", function(e) {
        let nombre = document.querySelector("input[name='nombre']").value.trim();
        let cedula = document.querySelector("input[name='cedula']").value.trim();
        let telefono = document.querySelector("input[name='telefono']").value.trim();

        if (nombre === "" || cedula === "" || telefono === "") {
            alert("Todos los campos son obligatorios");
            e.preventDefault();
        }

        if (cedula.length < 5) {
            alert("La cédula debe tener al menos 5 caracteres");
            e.preventDefault();
        }

        if (telefono.length < 7) {
            alert("El teléfono debe tener al menos 7 caracteres");
            e.preventDefault();
        }
    });
</script>

</body>
</html>