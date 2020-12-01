<?php
// --------------------------------------------
// --------------------------------------------
// PROCESAR FORMULARIO
// --------------------------------------------
// --------------------------------------------

// --------------------------------------------
// Funcion para validar 
// --------------------------------------------

/**
 * Metodo que valida si un texto no esta vacio
 * @param {string} - Texto a validar
 * @return {boolean}
*/
function validar_requerido(string $texto): bool
{
    return !(trim($texto == ''));
}
/**
 * Metodo que valida si el texto tienen un formato valido de Email
 * @param {string} - Email
 * @return {boolean}
*/
function validar_email(string $texto): bool
{
    return filter_var($texto, FILTER_VALIDATE_EMAIL);
}
// --------------------------------------------
// Variables
// --------------------------------------------
$errores = [];
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

// Comprobamos si nos llega los datos por POST
if ($_REQUEST['REQUEST_METHOD'] == 'POST') {
    // --------------------------------------------
    // Validaciones
    // --------------------------------------------
    // Email
    if (!validar_requerido($email)) {
        $errores[] = 'El campo Email es obligatorio';
    }
    if (!validar_email($email)) {
        $errores[] = 'El campo Email no tienen un formato valido';
    }

    // Contraseña
    if (!validar_requerido($password)) {
        $errores[] = 'La contraseña es obligatoria';
    }

    /* Verificar que no existe en la base de datos el mismo email */
    // Cuenta cuantos emails existen
    $query = $pdo->prepare('SELECT COUNT(*) AS length FROM usuarios WHERE email = :email');

    // Ejecutar la busqueda
    $query->execute([
        'email'=>$email
    ]);

    // Recoge los resultados
    $resultado = $query->fetch();

    // Comprobar si existe
    if ((int) $resultado['length'] > 0) {
        $errores[] = 'La direccion de email ya esta registrada';
    }

    // --------------------------------------------
    // Crear cuenta
    // --------------------------------------------
    if (count($errores) === 0) {
        /* Registro en la base de datos */
        // Prepara el INSERT
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $nuevoRegistro = $pdo->prepare('INSERT INTO usuarios (nombre, apellido, email, password, activo, token) VALUES (:nombre, :apellido, :email, :password, :activo, :token)');

        // Ejecuta el nuevo registro
        $nuevoRegistro->execute([
            'nombre' => $nombre, 
            'apellido' => $apellido, 
            'email' => $email, 
            'password' => $password, 
            'activo' => $activo, 
            'token' => $token
        ]);

        /* Envio de Email con Token */
        // Cabecera
        $headers = [
            'FROM' => 'dgonzalez.siemi@outlook.com',
            'Content-type' => 'text/plain; charset=utf-8'
        ];

        // variables para el email
        $emailEncode = urlencode($email);
        $tokEncode = urlencode($token);

        // Texto del email
        $textoEmail = "
        Hola!<br>
        Gracias por registrarte en la mejor plataforma de internet, demuestras tu inteligencia. <br>
        para activar entra en el siguiente enlace: <br>
        http://dgolez.com/index.php?page=verificar-cuenta&email=$emailEncode&token=$tokEncode";

        // Envio del email
        mail($email, 'Activa tu cuenta', 'Gracias por suscribirte', $headers);

        header('Location: index.php?page=identificarse&registro=1');
        die();
    }
}
?>

<h1>Registro</h1>
<!-- Mostramos error por HTML -->
<?php if (isset($errores)): ?>
<ul class="errores">
    <?php
    foreach ($errores as $error) {
        echo '<li>' . $error . '</li>';
    }
    ?>
</ul>
<?php endif; ?>

<!-- Formulario -->
<form action="" method="post">
    <div>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre">
    </div>
    <div>
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido">
    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" name="apellido">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" name="password"></div>    
    <div>
        <input type="submit" value="Registrarse">
    </div>
</form>