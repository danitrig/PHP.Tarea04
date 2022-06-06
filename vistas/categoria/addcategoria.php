<?php
require_once 'includes/header.php';
?>

<h2>Crear Nuevo Categoría</h2>

<?php foreach ($parametros["mensajes"] as $mensaje) : ?> 
	<div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
<?php endforeach; ?>

<form action="index.php?accion=addcategoria" method="POST" enctype="multipart/form-data">

	<!-- Nombre -->
    <label for="nombre">Nombre:
        <input type="text" name="nombre" class="form-control" />
    </label>
	</br>

    <input type="submit" value="Enviar" name="submit" class="btn btn-success" />


</form>

<?php require_once 'includes/footer.php' ?>