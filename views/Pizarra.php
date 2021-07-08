<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Pizarra = &$Page;
?>
<!-- partial 
    <iframe id="DocumentFrame"
            title="Onlyoffice"
            width="100%"
            height="1000"
            src=" https://simexamericas.org/OnlyOffice/doceditor.php?ulang=es&nameUser=ANTONIO%20BRAVO&fileID=pizarra.pptx&user=17">
    </iframe>
-->
    <?php
    $file_name = 'pizarra.pptx';
   echo CurrentLanguageID();
    $sql = ExecuteRow("Select concat(nombres,' ',apellidos)  'name'  from users where id_users =".CurrentUserInfo("id_users").";");
    ?>

    <iframe id="DocumentFrame"
            title="Pizara"
            width="100%"
            height="1000"
            src="<?=_URL_STORE?>doceditor.php?ulang=<?php echo CurrentLanguageID()?>&nameUser=<?php echo $sql['name']?>&fileID=<?php echo $file_name?>&user=<? echo CurrentUserInfo("id_users")?>">
    </iframe>


<?= GetDebugMessage() ?>
