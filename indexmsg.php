<?php 

 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Tabla dinamica</title>
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="librerias/select2/css/select2.css">

	<script src="librerias/jquery-3.2.1.min.js"></script>
	<script src="librerias/bootstrap/js/bootstrap.js"></script>
	
  <script src="librerias/select2/js/select2.js"></script>

</head>
<body>

	<div class="container">
 		<div id="tabla"></div>
	</div>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
        setInterval(function(){ 
           $('#tabla').load('refresh_msg.php');
           refresh();
        }, 1000);
    });
</script>
