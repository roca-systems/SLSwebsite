<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "Admin", "usuarios");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$contrasena = $_POST['contrasena'];

// Consultar la base de datos para obtener el número de carpeta del usuario
$sql = "SELECT id FROM usuarios WHERE nombre = '$nombre' AND contrasena = '$contrasena'";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Usuario autenticado correctamente
    $fila = $resultado->fetch_assoc();
    $id = $fila['id'];
    
    // Ruta de la carpeta del usuario
    $ruta_carpeta = "facturas/$id";

    // Verificar si la carpeta existe
    if (is_dir($ruta_carpeta)) {
        // Obtener lista de archivos en la carpeta
        $archivos = scandir($ruta_carpeta);
        
        // Mostrar lista de archivos
        echo "<h2>Archivos en la carpeta:</h2>";
        echo "<ul>";
        foreach ($archivos as $archivo) {
            if ($archivo != "." && $archivo != "..") {
                $ruta_archivo = "$ruta_carpeta/$archivo";
                echo "<li><a href='$ruta_archivo'>$archivo</a></li>";
            }
        }
        echo "</ul>";
    } else {
        echo "La carpeta no existe.";
    }
} else {
    // Usuario no encontrado o credenciales incorrectas
    echo "Usuario o contraseña incorrectos.";
}

// Cerrar conexión
$conexion->close();
?>
