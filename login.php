<?php
ValidacionLogin($emailFormulario, $passFormulario);
?>

<form method="post">
    <p>
        <input type="text" name="email" placeholder="Email">
    </p>
    <p>
        <input type="password" name="password" placeholder="Contraseña">
    </p>
    <p>
        <input type="submit" value="Entrar">
        <input type="button" onclick="window.location.href='index.php?page=recuperar_password'" value="Recuerar Contraseña">  
        <input type="button" onclick="window.location.href='index.php?page=registro'" value="Registrarse">            
    </p>
</form>