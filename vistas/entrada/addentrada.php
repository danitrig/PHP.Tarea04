<?php
require_once 'vistas/includes/header.php';
?>

<h2>Crear Nuevo Entrada</h2>

<?php foreach ($parametros["mensajes"] as $mensaje) : ?> 
	<div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
<?php endforeach; ?>

<form action="?controlador=entrada&accion=addEntrada" method="POST" enctype="multipart/form-data">

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

	<label for="categoria">Categoría:
		<select name="categoria">
			<option value="">Seleccione:</option>
			<?php foreach ($listaCategorias as $row => $fila): ?>
				<option value="<?= $fila["id"] ?>"><?= $fila["nombre"] ?></option>
			<?php endforeach; ?>
		</select>    
	</label>
    </br>
	
	<input id="prodId" name="prodId" type="hidden" value="xm234jq">

	<!-- Descripción -->
    <label for="descripcion">Descripción:
        <textarea name="descripcion" class="form-control"></textarea>
    </label>
    </br>

    <input type="submit" value="Enviar" name="submit" class="btn btn-success" />


</form>

<?php require_once 'vistas/includes/footer.php' ?>