<?php

require_once 'modelos/usuario.php';

class UsuarioControlador {

	private $modeloUsuarios;
	private $mensajes;

	public function __construct() {
		$this->modeloUsuarios = new Usuario();
		$this->mensajes = [];
	}

	public function index() {
		include_once 'vistas/login.php';
	}

	//Añadir usuario
	public function addUser() {
		$errores = array();

		if (isset($_POST["submit"])) {

			$nickname = filter_var($_POST["nickname"], FILTER_SANITIZE_STRING);
			$nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);
			$apellidos = filter_var($_POST["apellidos"], FILTER_SANITIZE_STRING);
			$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
			$password = sha1($_POST['password']);
			$imagen = null;

			//Código para captcha			
			$ip = $_SERVER['REMOTE_ADDR'];
			$captcha = $_POST['g-recaptcha-response'];
			$secretkey = "6Lef810gAAAAAL681MQrN2cG6X5i9-qb1A_jGrTm";

			$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

			$atributos = json_decode($respuesta, TRUE);

			if (!$atributos['success']) {
				$captcha_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "El captcha no es válido."
				];
				$errores["captcha"] = "El captcha no es válido.";
			} else {
				$nickname_validate = true;
			}

			if (!empty($_POST["nickname"]) && strlen($_POST["nickname"]) <= 20
			) {
				$nickname_validate = true;
			} else {
				$nickname_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "El nick introducido no es válido."
				];
				$errores["nickname"] = "El nick introducido no es válido.";
			}

			if (!empty($_POST["nombre"]) && strlen($_POST["nombre"]) <= 20 &&
					!is_numeric($_POST["nombre"]) && !preg_match("/[0-9]/", $_POST["nombre"])
			) {
				$nombre_validate = true;
			} else {
				$nombre_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "El nombre introducido no es válido."
				];
				$errores["nombre"] = "El nombre introducido no es válido.";
			}

			if (!empty($_POST["apellidos"]) && !is_numeric($_POST["apellidos"]) &&
					!preg_match("/[0-9]/", $_POST["apellidos"])) {
				$apellidos_validate = true;
			} else {
				$apellidos_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "Los apellidos introducidos no son válidos."
				];
				$errores["apellidos"] = "Los apellidos introducidos no son válidos.";
			}

			if (!empty($_POST["password"]) && strlen($_POST["password"]) >= 6) {
				$password_validate = true;
			} else {
				$password_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "La contraseña introducida no es válida."
				];
				$errores["password"] = "La contraseña introducida no es válida.";
			}

			if (!empty($_POST["email"]) && preg_match("/^\w+@[a-zA-Z]+\.[a-zA-Z]{2,3}$/", $_POST["email"])) {
				$email_validate = true;
			} else {
				$email_validate = false;
				$this->mensajes[] = [
					"tipo" => "danger",
					"mensaje" => "El correo introducido no es válido."
				];
				$errores["email"] = "El correo introducido no es válido.";
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
				$resultModelo = $this->modeloUsuarios->addUser([
					'nickname' => $nickname,
					'nombre' => $nombre,
					'apellidos' => $apellidos,
					'password' => $password,
					'email' => $email,
					'imagen' => $imagen
				]);
				if ($resultModelo["correcto"]) {
					$this->mensajes[] = [
						"tipo" => "success",
						"mensaje" => "REGISTRO REALIZADO CORRECTAMENTE."
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
					"mensaje" => "Datos de registro de usuario erróneos."
				];
			}
		}
		$parametros = [
			"tituloventana" => "Añadir Usuario",
			"datos" => [
				"nickname" => isset($nickname),
				"nombre" => isset($nombre),
				"apellidos" => isset($apellidos),
				"password" => isset($password),
				"email" => isset($email),
				"imagen" => isset($imagen)
			],
			"mensajes" => $this->mensajes
		];
		//Visualizamos la vista asociada al registro de usuarios
		include_once 'vistas/usuario/adduser.php';
	}

	//Listar usuarios
	public function listarUser() {

		try {
			$listaUsuarios = $this->modeloUsuarios->getUsers();
			$numeroUsuarios = $this->modeloUsuarios->getNumeroUsuarios();
			$mensajeResultado = "";
			$mensajeResultado2 = "";

			if ($numeroUsuarios > 0) {

				$usuariosPorPagina = 5; //Para no tener que introducir muchos usuarios y probar que funciona he puesto solo 3

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
					$start = ($pagina - 1) * $usuariosPorPagina;
				}
				$paginasTotales = ceil($numeroUsuarios / $usuariosPorPagina);

				$listaUsuarios = $this->modeloUsuarios->obtienePaginaUsuarios($start, $usuariosPorPagina);
			} else {
				$mensajeResultado2 = '<div class="alert alert-danger">' .
						"Aún NO existe ningún usuario" . '</div>';
			}

			if ($listaUsuarios) {
				$mensajeResultado = '<div class="alert alert-success">' .
						"La consulta se realizó correctamente." . '</div>';
			}
		} catch (PDOException $ex) {
			$mensajeResultado = '<div class="alert alert-danger">' .
					"La consulta no se realizó correctamente." . '</div>';
			die();
		}
		include_once 'vistas/usuario/listausuarios.php';
	}

	//Login
	public function login() {

		if (isset($_POST["submit"])) {

			$nickname = filter_var($_POST["usuario"], FILTER_SANITIZE_STRING);
			$password = sha1($_POST['password']);

			//Código para captcha			
			$ip = $_SERVER['REMOTE_ADDR'];
			$captcha = $_POST['g-recaptcha-response'];
			$secretkey = "6Lef810gAAAAAL681MQrN2cG6X5i9-qb1A_jGrTm";
			$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
			$atributos = json_decode($respuesta, TRUE);

			if ((isset($_POST['usuario']) && isset($_POST['password'])) && (!empty($_POST['usuario']) && !empty($_POST['password']) && $atributos['success'])) {

				$usuario = $this->modeloUsuarios->login($nickname, $password);

				if ($usuario) {
					//En este caso iniciamos sesión
					session_start();
					$_SESSION['logueado'] = $_POST['usuario'];
					$_SESSION['usuario'] = $_POST['usuario'];

					if (isset($_POST['recordar']) && ($_POST['recordar'] == "on")) {
						//Si se selecciona recordar creamos las 2 cookies (usuario y contraseña)
						setcookie('usuario', $_POST['usuario'], time() + (7 * 24 * 60 * 60)); //Días x Horas x Minutos * Milisegundos
						setcookie('password', $_POST['password'], time() + (7 * 24 * 60 * 60)); //Días x Horas x Minutos * Milisegundos
						//Cookie para marcar recordar en caso que lo hayamos hecho anteriormente.
						setcookie('recordar', $_POST['recordar'], time() + (7 * 24 * 60 * 60));
					} else {
						//Si NO se seleccciona las eliminamos.
						if (isset($_COOKIE['usuario'])) {
							setcookie('usuario', "");
						}
						if (isset($_COOKIE['password'])) {
							setcookie('password', "");
						}
						if (isset($_COOKIE['recordar'])) {
							setcookie('recordar', "");
						}
					}
					//Para mantener abierta la sesión añadimos esto:
					if (isset($_POST['mantener']) && ($_POST['mantener'] == "on")) {
						// Creamos una cookie para la sesión si marcamos la opción
						setcookie('mantener', $_POST['usuario'], time() + (7 * 24 * 60 * 60));
					} else {
						// Borramos la cookie si no está marcada
						if (isset($_COOKIE['mantener'])) {
							setcookie('mantener', "");
						}
					}
					//Página a la que redireccionamos si se accede correctamente con nuestras credenciales
					header("Location: index.php?controlador=usuario&accion=listarUser");
				}
			} else {
				//En caso de datos incorrectos vamos a login y le pasamos por GET el error DATOS.
				header("Location: index.php?controlador=usuario&accion=login&error=credenciales");
			}
		}
		include_once 'vistas/usuario/login.php';
	}

	public function detalleUser() {

		$idusuario = $_GET["id"];

		try {
			$usuarioMostrar = $this->modeloUsuarios->detalleUser($idusuario);

			if ($usuarioMostrar) {
				$mensajeResultado = '<div class="alert alert-success">' .
						"La consulta se realizó correctamente." . '</div>';
			}
		} catch (PDOException $ex) {
			$mensajeResultado = '<div class="alert alert-danger">' .
					"La consulta no se realizó correctamente." . '</div>';
			die();
		}
		include_once 'vistas/usuario/detalle.php';
	}

}
