<?php
require_once 'vistas/includes/header.php';
?>
<!-- Script para el captcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<a href="?controlador=usuario&accion=addUser">Registrarse</a>
<div class="centrar">	
	<div class="container cuerpo text-center">	
		<p><h2><img class="alineadoTextoImagen" src="images//user.png" width="50px"/> Login de usuario:</h2></p>
	</div>
	<div class="container">
		<form  action="?controlador=usuario&accion=login" method="POST">

			<!-- Rellenamos usuario con los valores de las cookies si existiesen -->	
			<label for="name">Usuario:
				<input type="text" name="usuario" class="form-control"
					   value="<?php
					   if (isset($_COOKIE['usuario'])) {
						   echo$_COOKIE['usuario'];
					   }
					   ?>"/> 
			</label>
			<br/>
			<!-- Rellenamos contraseña con los valores de las cookies si existiesen -->	
			<label for="password">Contraseña: 
				<input type="password" name="password" class="form-control" value="<?php
				if (isset($_COOKIE['password'])) {
					echo$_COOKIE['password'];
				}
				?>"/>            
			</label>
			<br/>

			<!-- Captcha -->
			<label for="captcha">Captcha: 
				<div class="g-recaptcha" name= "captcha" data-sitekey="6Lef810gAAAAAChSMQBkS0o4FVLn7TE_Q_iwRo62"></div>
			</label>
			<br/>

			<label><input type="checkbox" name="recordar" <?php
				if (isset($_COOKIE['recordar'])) {
					echo 'checked="true"';
				}
				?>"/>Recuérdame</label>
			<br/>

			<label><input type="checkbox" name="mantener"  <?php
				if (isset($_COOKIE['mantener'])) {
					echo 'checked="true"';
				}
				?>"/>Mantener iniciada la sesión de usuario</label>
			<br/> 

			<?php
			if (isset($_GET['error'])) {
				if ($_GET['error'] == "credenciales") {
					echo '<div class="alert alert-danger" style="margin-top:5px;">' . "Usuario o/y contraseña inválidos. Recuerde marcar el Captcha. <br/>" . '</div>';
				} elseif ($_GET['error'] == "privadas") {
					echo '<div class="alert alert-danger" style="margin-top:5px;">' . "Es necesario loguearse para acceder al resto de páginas del sitio.<br/>" . '</div>';
				}
			}
			?> 
			<input type="submit" value="Enviar" name="submit" class="btn btn-success" />
		</form>
	</div>
</div>  

<?php require_once 'vistas/includes/footer.php' ?>