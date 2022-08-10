<?php
	if(isset($_GET['deslogar'])){
		Usuarios::deslogar();
		header('Location: '.INCLUDE_PATH);
	}
	if(isset($_GET['action'])){
	$action = $_GET['action'];
	if($action == ACTION_LIKE){
		Usuarios::executarAcao(ACTION_LIKE,$_GET['id']);
	}else if($action == ACTION_DISLIKE){
		Usuarios::executarAcao(ACTION_DISLIKE,$_GET['id']);

	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bem-vindo <?php echo $_SESSION['nome']; ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link href="<?php echo INCLUDE_PATH; ?>css3/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>fonts-6/css/all.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Keywords" content="conhecer pessoas, encontros">
	<meta name="description" content="O amor da sua vida pode estar aqui">
	<meta charset="utf-8">
	<meta name="author" content="Raul Nascimento Cruz">
</head>
<body>

	<div class="sidebar">
		<div class="topo">
			<h3 style="float: left" >Bem-vindo <?php echo $_SESSION['nome']; ?></h3>
			<a style="float: right" href="<?php echo INCLUDE_PATH ?>?deslogar"><i class="fa-solid fa-right-from-bracket"></i></a>
			<div class="clear"></div>
		</div>

		<div class="btn-coord">
			<button onClick="getLocation()"><i class="fa-solid fa-location-dot"></i> Atualizar localização</button>
		</div>

		<div id="localizacao" class="info-localizacao">
			<p class="lat-text"><?php echo $_SESSION['latitude'] ?></p>
			<p class="long-text"><?php echo $_SESSION['longitude'] ?></p>
			<p>Localização: <?php echo $_SESSION['localizacao']; ?></p>
			
		</div>

		<div class="meus-crush">
			<h1><i class="fa-regular fa-heart"></i> Match:</h1>
			<ul>
				<?php
					$crushs = Usuarios::pegaCrushs();
					foreach ($crushs as $key => $value) {
				?>
					

					<li><?php echo $value['nome'] ?> | 		<span style="display: none;" class="lat-user"><?php echo $value['lat_coord'] ?></span>
					<span style="display: none;" class="long-user"><?php echo $value['long_coord'] ?></span> Distância: <span class="user-distancia"></span></li>

			<?php } ?>
			</ul>
		</div>

		<div class="clear"></div>
	</div>

	<div class="box-usuario-like">
		<div class="box-usuario-nome">
			<?php
				$usuario = Usuarios::pegaUsuarioNovo();
			?>
			<h2><?php echo $usuario['nome']; ?></h2>
			
			<a style="color: #ff1919" href="?action=0&id=<?php echo $usuario['id']; ?>"><i class="fa-solid fa-circle-xmark"></i></a>

			<a style="color: #66bf32" href="?action=1&id=<?php echo $usuario['id']; ?>"><i class="fa-solid fa-circle-check"></i></a>
			

		<div class="clear"></div>
		</div>
	</div><!--box-usuario-like-->

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } 

}

function showPosition(position) {
	$('p.lat-text').html('Latitude: '+ position.coords.latitude);
	$('p.long-text').html('Longitude: '+ position.coords.longitude);

	//Passando via AJAX para atualizar no banco.
	atualizarCoordenadas(position.coords.latitude,position.coords.longitude);
}

function atualizarCoordenadas(latitudePar,longitudePar){
	$.ajax({
		url:'/tinderplug/atualizar-coord.php',
		method:'post',
		data:{latitude:latitudePar,longitude:longitudePar}
	}).done(function(){
	})
}
</script>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
$(function(){

var myLat = $('.lat-text').html();
var myLong = $('.long-text').html();



$('li').each(function(){
	var coord_lat = $(this).find('.lat-user').html();
	var coord_long = $(this).find('.long-user').html();
	var distance =Math.round(getDistanceFromLatLonInKm(myLat,myLong,coord_lat,coord_long) * 100) / 100 ;
	$(this).find('.user-distancia').html(distance);
})

function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}


})

</script>
</body>
</html>