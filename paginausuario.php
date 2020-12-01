<?php
session_start();
$_SESSION['user_id'];
$username = $_SESSION['Nombre'];

echo "Bienvenido $username";