<?php
// backend.php
// ===============================
// CONFIGURACIÓN BASE DE DATOS
// ===============================
$host = "mysql-trainee115.alwaysdata.net";
$user = "trainee115";
$password = "clase1234";
$database = "trainee115_gestionusuarios";

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
    exit();
}

// ===============================
// ELIMINAR USUARIO
// ===============================
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM usuarios WHERE id=$id");
    header("Location: index.php");
    exit();
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
    exit();
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
$usuarios = $conn->query("SELECT * FROM usuarios ORDER BY created_at DESC");
?>