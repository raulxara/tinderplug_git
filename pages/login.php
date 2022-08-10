<?php  

	if(isset($_SESSION['login'])){
		header('Location: '.INCLUDE_PATH.'home');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>TinderPlug</title>
	<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link href="<?php echo INCLUDE_PATH; ?>css3/style.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Keywords" content="conhecer pessoas, encontros">
	<meta name="description" content="O amor da sua vida pode estar aqui">
	<meta charset="utf-8">
	<meta name="author" content="Raul Nascimento Cruz">
	
</head>
<body>

	<?php
	if(isset($_POST['acao'])){
		if(Usuarios::verificarLogin($_POST['login'],$_POST['senha'])){
			$getId = Usuarios::getUserId($_POST['login']);
			Usuarios::startSession($_POST['login'],$getId);
			header('Location: '.INCLUDE_PATH.'home');
		}else{
			echo '<script>alert("Usuário inválido!")</script>';
			//header('Location: '.INCLUDE_PATH.'login');
		}
	}
?>

	<div class="login">
		<div class="center">
			<h1>TinderPlug</h1>
			<form method="post">
				<input type="text" name="login" placeholder="E-mail">
				<br>
				<input type="password" name="senha" placeholder="Senha">
				<br>
				<input type="submit" name="acao" value="Entrar">
			</form>
		<div class="clear"></div>
		</div>
	</div>


</body>
</html>