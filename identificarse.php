<?php
// ============================================
// PROCESAR FORMULARIO
// ============================================

// --------------------------------------------
// Variables
// --------------------------------------------

$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
$errores = [];

// Comprobarmos que llegan los datos del formularios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // --------------------------------------------
    // COMPROBAR SI LA CUENTA ESTA ACTIVA
    // --------------------------------------------
    $query = $pdo->prepare('SELECT activo, password FROM usuarios WHERE email = :email');

    // Ejecutar consulta
    $query->execute([
        'email' => $email
    ]);

    // Guarda resultado
    $resultado = $query->fetch();
    if ((int) $resultado['activo'] !== 1) {
        $errores[] = 'Tu cuenta aun no esta activa. ¿Has comprobado tu bandeja de correo?';
    } else {
        // --------------------------------------------
        // COMPROBAR SI LA CUENTA ESTA ACTIVA
        // --------------------------------------------
        // Comprobamos si es valida
        if (password_verify($password, $resultado['password'])) {
            // Si son correctas, creamos las sesion
            session_start();
            $_SESSION['email'] = $email;
            // Redireccionamos a la pagina segura
            header('Location: index.php?page=privado');
            die();
        } else {
            $errores[] = 'El email o la contraseña es incorrecta';
        }
    }
}
?>

<h1>Entrar</h1>
<!-- Mostrar errores por HTML -->
<?php if (count($errores) > 0): ?>
<ul class="errores">
    <?php
    foreach ($errores as $error) {
        echo '<li>' . $error . '</li>';
    }
    ?>
</ul>
<?php endif; ?>

<!-- Mensaje de aviso al registrarse -->
<?php if (isset($_REQUEST['registrado'])): ?>
<p>Gracias por registrarte! Revisa tu bandeja de correo para activar la cuenta</p>
<?php endif; ?>

<!-- Mensaje de cuenta activa -->
<?php if (isset($_REQUEST['activada'])) : ?>
<p>Cuenta activada!</p>
<?php endif; ?>

<!-- Formulario de identificacion -->
<form method="post">
    <p><input type="text" name="email" placeholder="Email"></p>
    <p><input type="text" name="password" placeholder="Password"></p>
    <p><input type="submit" value="Entrar"></p>
</form>