<?php
//servidor,acceso,contraseña y nombre de la base de datos
$servername = "localhost";
$username = "root";
$passwordDb = "";
$dbname = "laboratorio";

//Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $passwordDb, $dbname);

//Chequear la conexion
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear una consulta a la base de datos que muestre todos los registros y guardar en una variable
$sql = $conn->prepare("SELECT * FROM registro");
$sql->execute();
$result = $sql->get_result();
while ($row = $result->fetch_assoc()) {
    // Acceda a columnas individuales de la fila
    $id = $row['id'];
    $nombre = $row['nombre'];
    $primer_apellido = $row['primer_apellido'];
    $segundo_apellido = $row['segundo_apellido'];
    $email = $row['email'];
    $login = $row['login'];
    $password = $row['password'];

    // Imprimir los resultados
    echo "ID: $id<br>";
    echo "Nombre: $nombre<br>";
    echo "Primer Apellido: $primer_apellido<br>";
    echo "Segundo Apellido: $segundo_apellido<br>";
    echo "Email: $email<br>";
    echo "Login: $login<br>";
    echo "Password: $password<br>";
    echo "<br>";
}

// Link para volver a la página de inicio
echo "<a href='/practica-final/html/inicio.html' style='color: blue; text-decoration: none; font-size: 20px'>Volver a la página de inicio</a>";
?>