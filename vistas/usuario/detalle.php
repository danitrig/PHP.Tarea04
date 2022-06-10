<?php require 'vistas/includes/header.php' ?>
<?php echo $mensajeResultado ?>

<?php
if ($usuarioMostrar["imagen"] != null) {
	echo '<h5>Imagen de perfil: </h5>';
	?>
	<img src="uploads/<?php echo $usuarioMostrar["imagen"] ?>" width="250" />
<?php } ?>
<h5>ID:</h5>
<a><?php echo $usuarioMostrar["id"] ?> </a>
<h5>Nick:</h5>
<a><?php echo $usuarioMostrar["nick"] ?> </a>
<h5>Nombre:</h5>
<a><?php echo $usuarioMostrar["nombre"] ?> </a>
<h5>Apellidos:</h5>
<a><?php echo $usuarioMostrar["apellidos"] ?> </a>
<h5>Correo:</h5>
<a><?php echo $usuarioMostrar["email"] ?> </a>
<h5>Password:</h5>
<a><?php echo $usuarioMostrar["password"] ?> </a>
</br>
<a href="index.php?controlador=usuario&accion=listarUser" class="btn btn-success">Volver</a>

<?php require 'vistas/includes/footer.php'; ?>