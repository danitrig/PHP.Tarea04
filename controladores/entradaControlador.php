<?php

require_once 'modelos/entrada.php';

class EntradaControlador {

	private $modeloEntrada;
	private $mensajes;

	public function __construct() {
		$this->modeloEntrada = new Entrada();
		$this->mensajes = [];
	}

	public function index() {
		include_once 'vistas/login.php';
	}

	public function addEntrada() {

		$listaCategorias = $this->modeloEntrada->getCategorias();

		$errores = array();

		if (isset($_POST["submit"])) {

			$titulo = filter_var($_POST["titulo"], FILTER_SANITIZE_STRING);
			$descripcion = filter_var($_POST["descripcion"], FILTER_SANITIZE_STRING);
			$categoriaString = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
			$categoria_id = (int) $categoriaString;
			$imagen = null;
			$usuario_id = 10;
			//$usuario_id = $this->modeloEntrada->getIdUsuario($_SESSION['usuario']);

			if (!empty($_POST["titulo"]) && strlen($_POST["titulo"]) <= 40) {
				$titulo_validate = true;
			} else {
				$titulo_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "El título introducido no es válido."
				];
				$errores["titulo"] = "El título introducido no es válido.";
			}

			if (!empty($_POST["descripcion"]) && strlen($_POST["descripcion"]) >= 10) {
				$descripcion_validate = true;
			} else {
				$descripcion_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "Debe escribir al menos 40 caracteres."
				];
				$errores["descripcion"] = "Debe escribir al menos 40 caracteres.";
			}

			if (!empty($_POST["categoria"]) && $categoria_id != 0) {
				$descripcion_validate = true;
			} else {
				$descripcion_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "Seleccione una categoría."
				];
				$errores["descripcion"] = "Seleccione una categoría.";
			}
			if (isset($_FILES["imagen"]) && !empty($_FILES["imagen"]["tmp_name"])) {

				//Comprobamos si existe el directorio upload, sino existe lo creamos así.
				if (!is_dir("uploads")) {
					$dir = mkdir("uploads", 0777, true);
				}//Si existe el directorio movemos el archivo a ese directorio.
				else {
					//Le pasamos el nombre por defecto y le concatenamos time() para que no
					//sobreescriba el archivo si subimos una imagen con el mismo nombre.
					$imagen = time() . " - " . $_FILES["imagen"]["name"];
					//Con esto movemos el fichero que tenemos en la carpeta temporal a la ruta que especificamos.
					$mover = move_uploaded_file($_FILES["imagen"]["tmp_name"], "uploads/" . $imagen);

					if ($mover) {
						$image_validate = true;
					} else {
						$image_validate = false;
						$this->mensajes[] = [
							"tipo" => "danger",
							"mensaje" => "La imagen introducida no es válida."
						];
						$errores["imagen"] = "La imagen introducida no es válida.";
					}
				}
			}
			if (count($errores) == 0) {
				$resultModelo = $this->modeloEntrada->addEntrada([
					'usuario_id' => $usuario_id,
					'categoria_id' => $categoria_id,
					'titulo' => $titulo,
					'descripcion' => $descripcion,
					'imagen' => $imagen
				]);
				if ($resultModelo["correcto"]) {
					$this->mensajes[] = [
						"tipo" => "success",
						"mensaje" => "ENTRADA AÑADIDA CORRECTAMENTE."
					];
				} else {
					$this->mensajes[] = [
						"tipo" => "danger",
						"mensaje" => "ALGO SALIÓ MAL AL REGISTRARSE <br/>({$resultModelo["error"]})"
					];
				}
			} else {
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "Algo Salió Mal."
				];
			}
		}
		$parametros = [
			"tituloventana" => "Añadir Entrada",
			"datos" => [
				"usuario_id" => isset($usuario_id),
				"categoria_id" => isset($categoria_id),
				"titulo" => isset($titulo),
				"descripcion" => isset($descripcion),
				"imagen" => isset($imagen)
			],
			"mensajes" => $this->mensajes
		];
		//Visualizamos la vista asociada al registro de usuarios
		include_once 'vistas/entrada/addentrada.php';
	}

}
