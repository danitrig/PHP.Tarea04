<?php require 'vistas/includes/header.php' ?>

<body class="cuerpo">
	<div class="container centrar">
		<div class="container cuerpo text-left">
			<p><h2><img class="alineadoTextoImagen" src= "images/user.png"width="50px"/>
				Base de Datos de Entradas</h2></p>
			<a href="vistas/entrada/pdf.php" class="btn btn-primary">Imprimir PDF</a>

		</div>
		</br>
		<?php echo $mensajeResultado ?>
		<?php echo $mensajeResultado2 ?>
		<?php echo $mensajeResultado3 ?>

		<a >Ordenar por fecha: </a>
		<a href="?controlador=entrada&accion=listarEntradas&pagina=1&orden=ASC">Ascendente</a>
		<a href="?controlador=entrada&accion=listarEntradas&pagina=1&orden=DESC">Descendente</a>


		<table class="table table-striped">
			<tr>
				<th>Fecha</th>
				<th>ID Categoría</th>
				<th>Título</th>
				<th>Descripcion</th>
				<th>Imagen</th>
				<th>Operaciones</th>
			</tr>
			<?php foreach ($listaEntradas as $row => $fila): ?>
				<tr>
					<td><?= $fila["fecha"] ?> </td>
					<td><?= $fila["categoria_id"] ?> </td>
					<td><?= $fila["titulo"] ?> </td>
					<td><?= $fila["descripcion"] ?> </td>			
					<td><?php
						if ($fila["imagen"] != null) {
							echo '<img src="uploads/' . $fila["imagen"] . '" width="60" /></br>' . $fila['imagen'];
						}
						?>
					</td>
					<td style="text-align-last: end">
						<a href="index.php?controlador=usuario&accion=detalleUser&id=<?= $fila['id'] ?>" class="btn btn-success">Ver</a>
						<a href="index.php?controlador=usuario&accion=editUser&id=<?= $fila['id'] ?>" class="btn btn-warning">Editar</a>
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
							Eliminar
						</button>

						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										¿Estás seguro de eliminar definitivamente?
									</div>
									<div class="modal-footer">
										<a href="" class="btn btn-success">Cancelar</a>
										<a href="index.php?controlador=usuario&accion=deleteUser&id=<?= $fila['id'] ?>" class="btn btn-danger" >Eliminar</a>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php if ($numeroEntradas > 0) { ?>
			<!--Usamos la paginación de boopstrap-->
			<ul class="pagination">
				<?php
				if ($pagina == 1) {
					echo '<li><a class="page-link"><</a></li>';
				} else {
					echo '<li><a class="page-link" href="?controlador=entrada&accion=listarEntradas&pagina=' . ($pagina - 1) . '&orden=' . $orden . '"><</a></li>';
				}

				for ($i = 1; $i <= $paginasTotales; $i++) {

					if ($pagina == $i) {
						echo '<li><a class="page-link">' . $i . '</a></li>';
					} else {
						echo '<li><a class="page-link" href="?controlador=entrada&accion=listarEntradas&pagina=' . $i . '&orden=' . $orden . '">' . $i . '</a></li>';
					}
				}
				if ($pagina == $paginasTotales) {
					echo '<li><a class="page-link">></a></li>';
				} else {
					echo '<li><a class="page-link" href="?controlador=entrada&accion=listarEntradas&pagina=' . ($pagina + 1) . '&orden=' . $orden . '">></a></li>';
				}
				?>
			</ul>
		<?php } ?>

	</div>
</body>
</html>
<?php require 'vistas/includes/footer.php'; ?>