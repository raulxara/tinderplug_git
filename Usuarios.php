<?php

	class Usuarios
	{
		
		public static function verificarLogin($login,$senha){
			$verifica = MySql::conectar()->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
			$verifica->execute(array($login,$senha));

			if($verifica->rowCount() == 1){
				return true;
			}else{
				return false;
			}
		}

		public static function pegaCrushs(){
			$crushs = array();
			$gostei = MySql::conectar()->prepare("SELECT * FROM likes WHERE user_from = ? AND action = 1");
			$gostei->execute(array($_SESSION['id']));

			$gostei = $gostei->fetchAll();
			foreach ($gostei as $key => $value) {
				$gostaramDeVolta = MySql::conectar()->prepare("SELECT * FROM likes WHERE user_to = ? AND user_from = ? AND action = 1");
				$gostaramDeVolta->execute(array($_SESSION['id'],$value['user_to']));
				if($gostaramDeVolta->rowCount() == 1){
					//É crush!
					$infoCrush = MySql::conectar()->prepare("SELECT * FROM usuarios WHERE id = ?");
					$infoCrush->execute(array($value['user_to']));
					$crushs[] = $infoCrush->fetch();
				}
			}

			return $crushs;
		}

		public static function startSession($login,$id){
			$_SESSION['login'] = $login;
			$_SESSION['id'] = $id;
			//Pegar restante das informações:
			$info = MySql::conectar()->prepare("SELECT * FROM usuarios WHERE id = ?");
			$info->execute(array($id));
			$info = $info->fetch();
			$_SESSION['nome'] = $info['nome'];
			$_SESSION['localizacao'] = $info['localizacao'];
			$_SESSION['latitude'] = $info['lat_coord'];
			$_SESSION['longitude'] = $info['long_coord'];
			$_SESSION['sexo'] = $info['sexo'];
		}

		public static function getUserId($email){
			$id = \MySql::conectar()->prepare("SELECT id FROM usuarios WHERE email = ?");
			$id->execute(array($email));

			$id = $id->fetch()['id'];

			return $id;
		}

		public static function deslogar(){
			unset($_SESSION['login']);
			unset($_SESSION['id']);
			unset($_SESSION['nome']);

			session_destroy();
		}

		public static function executarAcao($acao,$usuarioId){
			$verifica = MySql::conectar()->prepare("SELECT * FROM likes WHERE user_from = ? AND user_to = ?");
			$verifica->execute(array($_SESSION['id'],$usuarioId));
			if($verifica->rowCount() >= 1){
				return;
			}else{
				$inserirAcao = MySql::conectar()->prepare("INSERT INTO likes VALUES (null,?,?,?)");
				$inserirAcao->execute(array($_SESSION['id'],$usuarioId,$acao));
			}
		}

		public static function pegaUsuarioNovo(){
			if($_SESSION['sexo'] == 'masculino'){
				$pegaUsuarioRandom = MySql::conectar()->prepare("SELECT * FROM usuarios WHERE sexo != 'masculino' ORDER BY RAND() LIMIT 1");
				$pegaUsuarioRandom->execute();
				$pegaUsuarioRandom = $pegaUsuarioRandom->fetch();
				return $pegaUsuarioRandom;
			}else{
				$pegaUsuarioRandom = MySql::conectar()->prepare("SELECT * FROM usuarios WHERE sexo != 'feminino' ORDER BY RAND() LIMIT 1");
				$pegaUsuarioRandom->execute();
				$pegaUsuarioRandom = $pegaUsuarioRandom->fetch();
				return $pegaUsuarioRandom;
			}
		}
		
	}
?>