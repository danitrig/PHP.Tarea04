<?php
require_once 'vistas/includes/header.php';
?>
<a href="?controlador=usuario&accion=login">Inicio de Sesión</a>

<h2>Crear Nuevo Usuario</h2>

<?php foreach ($parametros["mensajes"] as $mensaje) : ?> 
	<div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
<?php endforeach; ?>

<form action="?controlador=usuario&accion=addUser" method="POST" enctype="multipart/form-data">

	<!-- NICK -->
    <label for="nombre">Nickname:
        <input type="text" name="nickname" class="form-control"/>
    </label>
	</br>

	<!-- Nombre -->
    <label for="nombre">Nombre:
        <input type="text" name="nombre" class="form-control" />
    </label>
	</br>

	<!-- Apellidos -->
    <label for="apellidos">Apellidos: 
        <input type="text" name="apellidos" class="form-control"/>
    </label>
    </br>

	<!-- Correo -->
    <label for="email">Correo Electrónico:
        <input type="email" name="email" class="form-control"/>
    </label>
    </br>

	<!-- Contraseña -->
    <label for="password">Contraseña:
        <input type="password" name="password" class="form-control" />
    </label>
    </br>

	<!-- Imagen -->
    <label for="image">Imagen:
        <input type="file" name="imagen" class="form-control" />
    </label>
    </br>

    <input type="submit" value="Enviar" name="submit" class="btn btn-success" />


</form>

<?php require_once 'vistas/includes/footer.php' ?>