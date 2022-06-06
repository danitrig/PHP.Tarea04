<?php

class Usuario {

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

	//Método para añadir usuarios
	public function addUser($datos) {
		$return = [
			"correcto" => FALSE,
			"error" => NULL
		];

		try {
			//Inicializamos la transacción
			$this->conexion->beginTransaction();
			//Definimos la instrucción SQL parametrizada 
			$sql = "INSERT INTO usuarios(nick,nombre,apellidos,email,password,imagen)
                         VALUES (:nick,:nombre,:apellidos,:email,:password,:imagen)";
			// Preparamos la consulta...
			$query = $this->conexion->prepare($sql);
			// y la ejecutamos indicando los valores que tendría cada parámetro
			$query->execute([
				'nick' => $datos["nickname"],
				'nombre' => $datos["nombre"],
				'apellidos' => $datos["apellidos"],
				'email' => $datos["email"],
				'password' => $datos["password"],
				'imagen' => $datos["imagen"]
			]); //Supervisamos si la inserción se realizó correctamente... 
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

	public function getUsers() {

		$sql = "SELECT * FROM usuarios";
		// Ejecutamos (conexion es el nombre de la conexión a la base de datos)
		$resultsquery = $this->conexion->query($sql);

		return $resultsquery;
	}

	//Paginación
	public function getNumeroUsuarios() {
		$numeroUsuarios = $this->conexion->query("SELECT FOUND_ROWS() as total");
		$numeroUsuarios = $numeroUsuarios->fetch()['total'];

		return $numeroUsuarios;
	}

	public function obtienePaginaUsuarios($start, $usuariosPorPagina) {
		$sql = "SELECT * FROM usuarios order by id DESC LIMIT {$start}, {$usuariosPorPagina};";
		$resultsquery = $this->conexion->query($sql);

		return $resultsquery;
	}

	//Eliminar usuarios
	public function deletetUser($id) {

		$sql = "DELETE FROM usuarios WHERE idusuario=:idusuario";
		$query = $this->conexion->prepare($sql);
		$query->execute(['idusuario' => $idusuario]);

		return $query;
	}

	public function editUser($idusuario, $nombre, $apellidos, $biografia, $email, $password, $image) {

		$sql = "UPDATE usuarios SET nombre= :nombre, apellidos=:apellidos, biografia=:biografia, email= :email, password= :password,image= :image WHERE idusuario= :idusuario";

		//Preparación
		$query = $conexion->prepare($sql);
		//Ejecución
		$query->execute([
			'idusuario' => $idusuario,
			'nombre' => $nombre,
			'apellidos' => $apellidos,
			'biografia' => $biografia,
			'email' => $email,
			'password' => $password,
			'image' => $image
		]);

		return $query;
	}

	public function login($nick, $pass) {

		$sql = "SELECT * FROM usuarios where nick = '{$nick}' and password = '{$pass}'";
		
		$resultsquery = $this->conexion->query($sql);
		
		$cuenta_col = $resultsquery->rowCount();
		
		if ($cuenta_col == 1) {
			return true;
		} else {
			return false;
		}
	}

}
