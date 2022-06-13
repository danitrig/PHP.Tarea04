<?php require 'vistas/includes/header.php' ?>

<body class="cuerpo">
	<div class="container centrar">

		</br>

		<h2>Editar Usuario:  
			<?php
			echo $usuarioEditar["id"] . " - " . $usuarioEditar["nombre"] .
			" " . $usuarioEditar["apellidos"];
			?>
		</h2>
		<form action="" method="POST" enctype="multipart/form-data">

			<!-- Nick -->
			<label for="nickname">Nick:
				<input type="text" name="nickname" class="form-control" 

					   <?php $this->mantenerValores($usuarioEditar, "nick") ?>/>
					   <?php echo $this->mostrarErrores($errores, "nick"); ?>
			</label>
			</br>

			<!-- Nombre -->
			<label for="nombre">Nombre:
				<input type="text" name="nombre" class="form-control" 

					   <?php $this->mantenerValores($usuarioEditar, "nombre") ?>/>
					   <?php echo $this->mostrarErrores($errores, "nombre"); ?>
			</label>
			</br>

			<!-- Apellidos -->
			<label for="apellidos">Apellidos: 
				<input type="text" name="apellidos" class="form-control" 
					   <?php $this->mantenerValores($usuarioEditar, "apellidos") ?>/>
					   <?php echo $this->mostrarErrores($errores, "apellidos"); ?>
			</label>
			</br>

			<!-- Correo -->
			<label for="email">Correo Electrónico:
				<input type="email" name="email" class="form-control"
					   <?php $this->mantenerValores($usuarioEditar, "email") ?>/>
					   <?php echo $this->mostrarErrores($errores, "email"); ?>
			</label>
			</br>

			<!-- Contraseña -->
			<label for="password">Contraseña:
				<input type="password" name="password" class="form-control" />
				<?php echo $this->mostrarErrores($errores, "password"); ?>
			</label>
			</br>

			<!-- Imagen -->
			<label for="image">Imagen de perfil: </br>
				<?php if ($usuarioEditar["imagen"] != null) { ?>
					<img src="uploads/<?php echo $usuarioEditar["imagen"] ?>" width="250" />
				<?php } ?>

				<input type="file" name="image" class="form-control" />
			</label>
			</br>

			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
				Editar
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Confirmar Cambios</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							¿Estás seguro de realizar los cambios?
						</div>
						<div class="modal-footer">
							<a href="index.php?controlador=usuario&accion=listarUser" class="btn btn-danger">Volver</a>
							<input type="submit" value="Editar" name="submit" class="btn btn-success" />
						</div>
					</div>
				</div>
			</div>


			<a href="index.php?controlador=usuario&accion=listarUser" class="btn btn-danger">Volver</a>

		</form>
	</div>
</body>
</html>
<?php require 'vistas/includes/footer.php'; ?>