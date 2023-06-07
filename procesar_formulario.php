<?php
if ($_POST) {

    //si el usuario ha introducido datos, se guardan en variables
    $name = $_POST['name'];
    $firstLastName = $_POST['last-name-one'];
    $secondLastName = $_POST['last-name-two'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    //servidor,acceso,contraseña y nombre de la base de datos
    $servername = "localhost";
    $username = "root";
    $passwordDb = "";
    $dbname = "laboratorio";

    try {
        //Crear conexión a la base de datos
        $conn = new mysqli($servername, $username, $passwordDb, $dbname);

        //Chequear la conexion
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        //Validar correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Por favor, introduzca un correo electrónico válido";

            // link a la página de registro
            echo "<a href='/practica-final/html/formulario.html' style='color: blue; font-size: 20px; margin-left:8px'>Volver al formulario</a>";
            exit;
        }

        //Validar contraseña que tenga entre 4 y 8
        if (strlen($password) < 4 || strlen($password) > 8) {
            echo "La contraseña debe tener entre 4 y 8 caracteres";

            // link a la página de registro
            echo "<a href='/practica-final/html/formulario.html' style='color: blue; font-size: 20px; margin-left:8px'>Volver al formulario</a>";
            exit;
        }

        //Verificar que el correo electrónico no esté registrado en la base de datos
        $sql = $conn->prepare("SELECT * FROM registro WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->fetch_assoc()) {
            echo "El correo electrónico ya está registrado";
            $sql->close();
            // link a la página de inicio
            echo "<a href='/practica-final/html/inicio.html' style='color: blue; font-size: 20px; margin-left:8px'>Volver a la página de inicio</a>";
            exit;
        }

        //Encriptar la contraseña
        $password = password_hash($password, PASSWORD_DEFAULT);

        //Crear una consulta a la base de datos y guardar en una variable
        $sql = "INSERT INTO registro (nombre, primer_apellido, segundo_apellido, email, login, password) 
            VALUES ('$name', '$firstLastName', '$secondLastName', '$email', '$login', '$password')";

        //Mensaje confirmando creación de registro exitosa, sino que se repita el proceso
        if ($conn->query($sql) === TRUE) {
            header("Location: /practica-final/html/registro.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        //Cerrar la conexión a la base de datos
        $conn->close();

    } catch (mysqli_sql_exception $e) {
        //Si no se ha podido conectar a la base de datos, mostrar mensaje de error
        echo "Error de conexión a la base de datos " . $e->getMessage();
    }
}
?>