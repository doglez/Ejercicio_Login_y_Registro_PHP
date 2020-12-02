<?php
require 'config.php';

$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT id_usuario, usuario, fnac FROM usuario;";

$stmt = $connection->prepare($sql);
$stmt->execute();


foreach ($stmt->fetchAll() as $row) {
    $fecha = DateTime::createFromFormat('Y-m-d', $row['fnac']);
    $hoy = new DateTime('now');

    $diferencia = $hoy->diff($fecha);

    echo $row['nombre'] . "<br>";
    echo $fecha->format('d/m/y') . '<br>';
    echo $diferencia->format('%y años') . '<br>';
}