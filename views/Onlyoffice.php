<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Onlyoffice = &$Page;
?>
<?php
$id_user = CurrentUserID();

$sql = ExecuteRow("Select nombres, apellidos from users where id_users ='".$id_user."';");
echo "id_usuario ".$id_user."<br>"; 
echo $sql[0];

?>


<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="http://localhost/home/subir/" allowfullscreen></iframe>
</div>

<?= GetDebugMessage() ?>
