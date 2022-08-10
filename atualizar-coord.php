<?php
	session_start();

	include('MySql.php');
	if(!isset($_SESSION['id'])){
		die();
	}
	$idUsuario = $_SESSION['id'];
	$lat = $_POST['latitude'];
	$long = $_POST['longitude'];

	$atualizar = \MySql::conectar()->prepare("UPDATE usuarios SET lat_coord = ?,long_coord = ? WHERE id = $idUsuario");
	$atualizar->execute(array($lat,$long));

?>