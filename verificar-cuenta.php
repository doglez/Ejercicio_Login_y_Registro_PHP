<?php
// --------------------------------------------
// Variables
// --------------------------------------------
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';

// --------------------------------------------
// COMPROBAR SI SON CORRECTO LOS DATOS
// --------------------------------------------
// Preparar el SELECT para obtener la contraseña almacenada del usuario
$query = $pdo->prepare('SELECT COUNT(*) AS length FROM usuarios WHERE email = :email AND token = :token  AND activo = 0');

// Ejecutar la consulta
$query->execute([
    'email' => $email,
    'token' => $token
]);
$resultado = $query->fetch();

// Existe el usuario con el token
if ((bool) $resultado['length']) {
    // --------------------------------------------
    // ACTIVAR CUENTA
    // --------------------------------------------
    // Preparar la actualizacion
    $actualizacion = $pdo->prepare('UPDATE usuarios SET activo = 1 WHERE email = :email');
    // Ejecutar la actualizacion
    $actualizacion->execute([
        'email' => $email
    ]);
    
    // --------------------------------------------
    // REDIRECCIONAR A IDENTIFICACION
    // --------------------------------------------
    header('Location: index.php?page=identificarse&activada=1');
    die();
}

// No es un usuario valido 
header('Location: index.php?page=identificarse');
die();