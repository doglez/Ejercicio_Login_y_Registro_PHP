<?php 
	include('config.php');
	session_start();
	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		echo $password;
		
		$query = $connection->prepare("SELECT * FROM usuario WHERE usuario=:username");
		$query ->bindParam(":username", $username, PDO::PARAM_STR);
		$query ->execute();
		
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		if(!$result){
		echo '<p class="error">La combinación del username y del password es incorrecta!!!!</p>';
		}elseif(password_verify($password, $result['clave'])){
				$_SESSION['user_id']=$result['id_usuario'];
				$_SESSION['Nombre']=$result['usuario'];
				

				echo '<p class="success">Felicitaciones, Ud. se ha logueado!!!!</p>';
				header('Location: paginausuario.php');
			}else{
				echo '<p class="error">La combinación de usuario y password es incorrecta!!!!</p>';
			}
		
	}
?>
<form method="post" action="" name="signin-form">
	<div class="form-element">
    	<label>Username</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
    	<label>Password</label>
        <input type="password" name="password" required />
    </div>
    <button type="submit" name="login" value="login">Log In</button>
</form>
    