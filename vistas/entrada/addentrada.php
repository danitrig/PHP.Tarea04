<?php
require_once 'includes/header.php';
?>

<h2>Crear Nuevo Entrada</h2>

<?php foreach ($parametros["mensajes"] as $mensaje) : ?> 
	<div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
<?php endforeach; ?>

<form action="index.php?accion=addentrada" method="POST" enctype="multipart/form-data">

	<!-- Título -->
    <label for="titulo">Título:
        <input type="text" name="titulo" class="form-control" />
    </label>
	</br>

	<!-- Imagen -->
    <label for="image">Imagen:
        <input type="file" name="imagen" class="form-control" />
    </label>
    </br>
	
	<!-- Descripción -->
    <label for="descripcion">Descripción:
        <textarea name="descripcion" class="form-control"></textarea>
    </label>
    </br>

    <input type="submit" value="Enviar" name="submit" class="btn btn-success" />


</form>

<?php require_once 'includes/footer.php' ?>