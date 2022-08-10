<?php  

	class MySql{

		private static $pdo;

		public static function conectar(){
			if(is_null(self::$pdo)){
				self::$pdo = new PDO('mysql:host=localhost;dbname=tinderplug','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}

			return self::$pdo;
		}
	}

?>