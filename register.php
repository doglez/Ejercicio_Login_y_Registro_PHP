<?php //https://code.tutsplus.com/es/tutorials/create-a-php-login-form--cms-33261
include('config.php');
session_start();

if(isset($_POST['register'])){
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_hash = password_hash($password, PASSWORD_DEFAULT);//campo mayor a 72 chr
	
	$query = $connection->prepare("SELECT * FROM usuario WHERE email = :email");
	$query->bindParam(":email", $email);
	$query->execute();
	
	if($query->rowCount() >0){
		echo '<p class="error">The email adress is already registered!</p>';
	}
	
	if($query->rowCount()==0){
		$query = $connection->prepare("INSERT INTO usuario(USUARIO,CLAVE,EMAIL) VALUES (:username, :password_hash, :email)");
		$query ->bindParam(":username", $username);
		$query ->bindParam(":password_hash", $password_hash);
		$query ->bindParam(":email", $email);
		$result = $query->execute();		
		if($result){
			echo '<p class="sucess">Your registration was succesfull!</p>';
		}else{
			echo '<p class="error">Something went wrong!</p>';
		}
	}
}

?>


<form method="post" action="" name="registro-usuarios">
	<div class="form-element">
		<label>Username</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
    	<label>Email</label>
        <input type="email" name="email" required />
    </div>
    <div class="form-element">
    	<label>Password</label>
        <input type="password" name="password" required />
    </div>
    <button type="submit" name="register" value="register">Register</button>
</form>
 