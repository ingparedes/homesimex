<?php
//require_once($_SERVER['DOCUMENT_ROOT'] . "/simexamerica-chat/defines.php");


try {
	$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DB . '', '' . USER . '', '' . PASS . '');
	echo "Conectado correctamente";
} catch (PDOException $error) {
	echo 'Error de Conexión: ' . $error->getMessage();
} 

/*

class BD
{
	private static $conn;

	public function __construct()
	{
	}

	public static function conn()
	{
		if (is_null(self::$conn)) {
			self::$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DB . '', '' . USER . '', '' . PASS . '');
		}

		return self::$conn;
	}
}
*/