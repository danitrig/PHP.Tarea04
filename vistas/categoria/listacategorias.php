<?php require 'vistas/includes/header.php' ?>

<body class="cuerpo">
	<div class="container centrar">
		<div class="container cuerpo text-left">
			<p><h2><img class="alineadoTextoImagen" src= "images/user.png"width="50px"/>
				Base de Datos de Categorías</h2></p>
			<a href="pdf.php" class="btn btn-primary">Imprimir PDF</a>
		</div>
		</br>
		<?php echo $mensajeResultado ?>
		<?php echo $mensajeResultado2 ?>

		<table class="table table-striped">
			
				<h4>Nombre</h4>
			
			<?php foreach ($listaCategorias as $row => $fila): ?>
				<tr>
					<td><?= $fila["nombre"] ?> </td>		
					<td style="text-align-last: end">
						<a href="ver.php?id=<?= $fila['id'] ?>" class="btn btn-success">Ver</a>
						<a href="edit.php?id=<?= $fila['id'] ?>" class="btn btn-warning">Editar</a>
						<a href="delete.php?id=<?= $fila['id'] ?>" class="btn btn-danger">Eliminar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php if ($numeroCategorias > 0) { ?>
			<!--Usamos la paginación de boopstrap-->
			<ul class="pagination">
				<?php
				if ($pagina == 1) {
					echo '<li><a class="page-link"><</a></li>';
				} else {
					echo '<li><a class="page-link" href="?controlador=categoria&accion=listarCategoria&pagina=' . ($pagina - 1) . '"><</a></li>';
				}

				for ($i = 1; $i <= $paginasTotales; $i++) {

					if ($pagina == $i) {
						echo '<li><a class="page-link">' . $i . '</a></li>';
					} else {
						echo '<li><a class="page-link" href="?controlador=categoria&accion=listarCategoria&pagina=' . $i . '">' . $i . '</a></li>';
					}
				}
				if ($pagina == $paginasTotales) {
					echo '<li><a class="page-link">></a></li>';
				} else {
					echo '<li><a class="page-link" href="?controlador=categoria&accion=listarCategoria&pagina=' . ($pagina + 1) . '">></a></li>';
				}
				?>
			</ul>
		<?php } ?>

	</div>
</body>
</html>
<?php require 'vistas/includes/footer.php'; ?>