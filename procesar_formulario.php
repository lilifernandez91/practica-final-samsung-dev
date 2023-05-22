<?php
if ($_POST) {

    //servidor,acceso,contraseña y nombre de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "practica_laboratorio";

    //Crear conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    //Chequear la conexion
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    //Obtener los datos del formulario y limpiarlos
    $nombre = cleanInput($_POST['nombre']);
    $primerapellido = cleanInput($_POST['primerapellido']);
    $segundoapellido = cleanInput($_POST['segundoapellido']);
    $email = cleanInput($_POST['email']);
    $contraseña = cleanInput($_POST['contraseña']);

    //Validar que los campos no estén vacíos
    if (empty($nombre) || empty($primerapellido) || empty($segundoapellido) || empty($email) || empty($contraseña)) {
        echo "Por favor, rellene todos los campos";
        exit;
    }

    //Validar correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Por favor, introduzca un correo electrónico válido";
        exit;
    }

    //Verificar que el correo electrónico no esté registrado en la base de datos
    $sql = "SELECT * FROM registro WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado";
        exit;
    }

    //Validar contraseña
    if (strlen($contraseña) <= 4 || strlen($contraseña) >= 8) {
        echo "La contraseña debe tener entre 4 y 8 caracteres";
        exit;
    }

    //Crear una consulta a la base de datos y guardar en una variable
    $sql = "INSERT INTO registro (nombre, primerapellido, segundoapellido, email, contraseña)
                VALUES('$nombre', '$primerapellido', '$segundoapellido', '$email', '$contraseña')";

    //Consulta a la base de datos para obtener los datos de los usuarios
    $sql = "SELECT * FROM registro";
    $result = $conn->query($sql);

    //Mensaje confirmando creación de registro exitosa, sino que se repita el proceso
    if ($conn->query($sql) === TRUE) {
        echo "Registro completado con éxito";
        echo '<br>';
        echo '<button onclick="consultarUsuarios()">Consulta</button>';
    } else {
        echo "Error al registrar los datos: " . $sql . "<br>" . $conn->error;
    }

    //Cerrar la conexión a la base de datos
    $conn->close();

    //Función para limpiar los datos introducidos por el usuario
    function cleanInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
?>