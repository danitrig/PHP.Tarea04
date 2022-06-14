<?php

class Entrada {

	//Referencia a la base de datos
	private $conexion;
//Conexión			
	private $host = 'localhost';
	private $db = 'bd_blog';
	private $user = 'root';
	private $pass = '';

//Constructor de la clase
	public function __construct() {
		$this->conectar();
	}

//Realizar conexión a la base de datos. Devolverá TRUE o FALSE
	public function conectar() {
		try {
			$this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
			$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return true;
		} catch (PDOException $ex) {
			return $ex->getMessage();
		}
	}

	//Conocer si estamos conectados o no. Devolverá True o False
	public function estaConectado() {
		if ($this->conexion) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//Método para añadir Entradas
	public function addEntrada($datos) {
		$return = [
			"correcto" => FALSE,
			"error" => NULL
		];

		try {
			//Inicializamos la transacción
			$this->conexion->beginTransaction();
			//Definimos la instrucción SQL parametrizada 
			$sql = "INSERT INTO entradas(titulo, imagen, descripcion, usuario_id, categoria_id)
                         VALUES (:titulo,:imagen,:descripcion, :usuario_id, :categoria_id)";
			// Preparamos la consulta...
			$query = $this->conexion->prepare($sql);
			// y la ejecutamos indicando los valores que tendría cada parámetro
			$query->execute([
				'titulo' => $datos["titulo"],
				'imagen' => $datos["imagen"],
				'descripcion' => $datos["descripcion"],
				'usuario_id' => $datos["usuario_id"],
				'categoria_id' => $datos["categoria_id"],
			]);
			//Supervisamos si la inserción se realizó correctamente... 
			if ($query) {
				$this->conexion->commit(); // commit() confirma los cambios realizados durante la transacción
				$return["correcto"] = TRUE;
			}// o no :(
		} catch (PDOException $ex) {
			$this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
			$return["error"] = $ex->getMessage();
			//die();
		}
		return $return;
	}
/*
	public function getIdUsuario($nick) {
		$sql = "SELECT id FROM usuarios where nick = '{$nick}'";
		// Ejecutamos (conexion es el nombre de la conexión a la base de datos)
		$resultsquery = $this->conexion->query($sql);
		$usuario = $resultsquery->fetch();

		$id = $usuario["id"];

		return $id;
	}*/

	public function getEntrada() {

		$sql = "SELECT * FROM entradas";
		// Ejecutamos (conexion es el nombre de la conexión a la base de datos)
		$resultsquery = $this->conexion->query($sql);

		return $resultsquery;
	}

	//Paginación
	public function getNumeroEntradas() {
		$numeroEntradas = $this->conexion->query("SELECT FOUND_ROWS() as total");
		$numeroEntradas = $numeroEntradas->fetch()['total'];

		return $numeroEntradas;
	}

	public function obtienePaginaEntradas($start, $entradasPorPagina, $orden) {
		$sql = "SELECT * FROM entradas order by id {$orden} LIMIT {$start}, {$entradasPorPagina};";
		$resultsquery = $this->conexion->query($sql);

		return $resultsquery;
	}

}
