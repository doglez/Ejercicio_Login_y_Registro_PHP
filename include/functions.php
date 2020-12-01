<?php
// Funcion para mostrar la pagina
function ShowPage($page)
{
    if (isset($_GET['page'])) {
        $modulo = $_GET['page'] . ".php";
        if (file_exists($modulo)) {
            $page = $_GET['page'];
        } else {
            $page = '404';
        }
    } else {
        $page = 'login';
    }
    return include($page . '.php');
}


// Funcion validacion de login
function ValidacionLogin($emailFormulario, $passFormulario)
{
    // Comprombacion de que los datos llegan por medio del POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Base de datos ficticia
        $db = [
            'email'=>'danilo.j.gonzalez@gmail.com',
            'password'=>password_hash('123',PASSWORD_BCRYPT)
        ];
        // Variables del formulario
        $emailFormulario = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
        $passFormulario = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

        // Validacion de que los datos son correctos
        if ($db['email'] == $emailFormulario && password_verify($passFormulario, $db['password'])) {
            session_start();
            $_SESSION['email'] = $emailFormulario;
            return header('Location: index.php?page=privado');
            die();
        }
    }
}

// Funcion de sesion habierta
function SesionHabierta($email)
{
    session_start();
    if (!isset($_SESSION['email'])) {
        return header('Location: index.php?page=identificarse');
        die();
    }
}


// Funcion para cerrar la sesion
function CierraSesion()
{
    session_start();
    session_destroy();
    return header('Location: index.php');
}

// Funcion para recuperar contraseña
function RecuperaPassword($email)
{
    // Generacion del tocken seguro con OpenSSL
    $tocketnSeguro = bin2hex(openssl_random_pseudo_bytes(16));

    // Mensaje del correo
    $mensaje = "
    <html>
        <head>
            <title>Recuperacion de Contraseña</title>
        </head>
        <body>
            <a href=\"ejemplo.php?tocken=$tocketnSeguro\">Pulsa aqui para cambiar el password</a>
        </body>
    </html>
    ";

    // Define que nuestro mensaje sera de tipo: HTML. Y la direccion del emisor
    $headers = [
        'MIME-Version'=>'1.0',
        'Content-type'=>'text/html; charset=utf-8',
        'From'=>'danilo.j.gonzalez@gmail.com'
    ];

    // Lo envia
    return mail('danilo.j.gonzalez@gmail.com', 'Recuperar Contraseña', $mensaje, $headers);
}