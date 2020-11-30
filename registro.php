<?php
echo 'Hola';

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
    $headers = [
        'FROM' => 'dgonzalez.siemi@outlook.com',
        'Content-type' => 'text/plain; charset=utf-8'
    ];

    
}