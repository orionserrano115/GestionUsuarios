<?php
$host = "mysql-trainee115.alwaysdata.net";
$user = "trainee115";
$password = "clase1234";
$database = "trainee115_gestionusuarios";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// CREAR
if (isset($_POST['crear'])) {
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $telefono = trim($_POST['telefono']);

    if ($nombre && $cedula && $telefono) {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, cedula, telefono) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $cedula, $telefono);
        $stmt->execute();
    }

    header("Location: index.php");
    exit();
}

// ELIMINAR
if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $id = (int) $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $telefono = trim($_POST['telefono']);

    if ($nombre && $cedula && $telefono) {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, cedula=?, telefono=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $cedula, $telefono, $id);
        $stmt->execute();
    }

    header("Location: index.php");
    exit();
}

// EDITAR
$editar = false;
$usuarioEditar = null;

if (isset($_GET['editar'])) {
    $id = (int) $_GET['editar'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $usuarioEditar = $resultado->fetch_assoc();
    $editar = true;
}

// LISTAR
$usuarios = $conn->query("SELECT * FROM usuarios ORDER BY created_at DESC");