<?php

require_once 'modelos/categoria.php';

class CategoriaControlador {

	private $modeloCategoria;
	private $mensajes;

	public function __construct() {
		$this->modeloCategoria = new Categoria();
		$this->mensajes = [];
	}

	public function index() {
		include_once 'vistas/login.php';
	}

	//Añadir Categoría
	public function addCategoria() {
		$errores = array();

		if (isset($_POST["submit"])) {

			$nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);

			if (!empty($_POST["nombre"]) && strlen($_POST["nombre"]) <= 40 &&
					!is_numeric($_POST["nombre"])) {
				$nombre_validate = true;
			} else {
				$nombre_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "Los campos no pueden estar vacíos."
				];
				$errores["nombre"] = "No puede ser el nombre de una categoría.";
			}

			if (count($errores) == 0) {
				$resultModelo = $this->modeloCategoria->addCategoria([
					'nombre' => $nombre
				]);
				if ($resultModelo["correcto"]) {
					$this->mensajes[] = [
						"tipo" => "success",
						"mensaje" => "AÑADIDO CORRECTAMENTE."
					];
				} else {
					$this->mensajes[] = [
						"tipo" => "danger",
						"mensaje" => "ALGO SALIÓ MAL AL AÑADIR LA CATEGORÍA <br/>({$resultModelo["error"]})"
					];
				}
			} else {
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "Datos erróneos."
				];
			}
		}
		$parametros = [
			"tituloventana" => "Añadir Categorías",
			"datos" => [
				"nombre" => isset($nombre)
			],
			"mensajes" => $this->mensajes
		];
		//Visualizamos la vista asociada al registro
		include_once 'vistas/categoria/addcategoria.php';
	}

	//Listar Categoría
	public function listarCategoria() {

		try {
			$listaCategorias = $this->modeloCategoria->getCategorias();
			$numeroCategorias = $this->modeloCategoria->getNumeroCategorias();
			$mensajeResultado = "";
			$mensajeResultado2 = "";

			if ($numeroCategorias > 0) {

				$categoriasPorPagina = 5; //Para no tener que introducir muchos usuarios y probar que funciona he puesto solo 3

				if (isset($_GET["pagina"])) {
					$pagina = $_GET["pagina"];
				} else {
					$pagina = 0;
				}
				//Si solo tiene una página
				if ($pagina == 0) {
					$start = 0;
					$pagina = 1;
				} else {
					$start = ($pagina - 1) * $categoriasPorPagina;
				}
				$paginasTotales = ceil($numeroCategorias / $categoriasPorPagina);

				$listaCategorias = $this->modeloCategoria->obtienePaginaCategorias($start, $categoriasPorPagina);
			} else {
				$mensajeResultado2 = '<div class="alert alert-danger">' .
						"Aún NO existe ninguna categoría" . '</div>';
			}

			if ($listaCategorias) {
				$mensajeResultado = '<div class="alert alert-success">' .
						"La consulta se realizó correctamente." . '</div>';
			}
		} catch (PDOException $ex) {
			$mensajeResultado = '<div class="alert alert-danger">' .
					"La consulta no se realizó correctamente." . '</div>';
			die();
		}
		include_once 'vistas/categoria/listacategorias.php';
	}

}
