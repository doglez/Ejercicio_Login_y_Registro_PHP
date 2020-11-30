<?php
try {
    $host = 'localhost';
    $db = 'db_usuarios';
    $username = 'labs';
    $passwd = 'Labs123@';
    $dsn = "mysql:host=$host;dbname=$db";
    return $pdo = new PDO($dsn, $username, $passwd);
} catch (Exception $e) {
    echo "<h3>No se puede conectar a la base de datos</h3>";
    echo "<h3>Mensaje: " . $e->getMessage() . "</h3>";
}