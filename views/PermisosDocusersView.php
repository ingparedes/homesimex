<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocusersView = &$Page;

/**
 * Servidor de almacenamiento/OnlyOffice
 */

define('_URL_STORE','https://simexamericas.org/OnlyOffice/');


$sql = ExecuteRow("Select concat(nombres,' ',apellidos)  'name'  from users where id_users =".CurrentUserID().";");

?>
<?php if (!$Page->isExport()) { ?>


<script>
var currentForm, currentPageID;
var fpermisos_docusersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpermisos_docusersview = currentForm = new ew.Form("fpermisos_docusersview", "view");
    loadjs.done("fpermisos_docusersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.permisos_docusers) ew.vars.tables.permisos_docusers = <?= JsonEncode(GetClientVar("tables", "permisos_docusers")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpermisos_docusersview" id="fpermisos_docusersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_docusers">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_permisiosuser->Visible) { // id_permisiosuser ?>
    <tr id="r_id_permisiosuser">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_docusers_id_permisiosuser"><?= $Page->id_permisiosuser->caption() ?></span></td>
        <td data-name="id_permisiosuser" <?= $Page->id_permisiosuser->cellAttributes() ?>>
<span id="el_permisos_docusers_id_permisiosuser">
<span<?= $Page->id_permisiosuser->viewAttributes() ?>>
<?= $Page->id_permisiosuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
    <tr id="r_id_file">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_docusers_id_file"><?= $Page->id_file->caption() ?></span></td>
        <td data-name="id_file" <?= $Page->id_file->cellAttributes() ?>>
<span id="el_permisos_docusers_id_file">
<span<?= $Page->id_file->viewAttributes() ?>><?php
$id = CurrentPage()->id_file->CurrentValue;
$filex = ExecuteRow("SELECT id_users,file_name FROM archivos_doc WHERE id_file = '".$id."';");

echo $filex['file_name'];
?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
    <tr id="r_tipo_permiso">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_docusers_tipo_permiso"><?= $Page->tipo_permiso->caption() ?></span></td>
        <td data-name="tipo_permiso" <?= $Page->tipo_permiso->cellAttributes() ?>>
<span id="el_permisos_docusers_tipo_permiso">
<span<?= $Page->tipo_permiso->viewAttributes() ?>>

<?= $Page->tipo_permiso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
    <tr id="r_id_users">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_docusers_id_users"><?= $Page->id_users->caption() ?></span></td>
        <td data-name="id_users" <?= $Page->id_users->cellAttributes() ?>>
<span id="el_permisos_docusers_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>

<?php if ($Page->date_created->Visible) { // date_created ?>
    <tr id="r_date_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_docusers_date_created"><?= $Page->date_created->caption() ?></span></td>
        <td data-name="date_created" <?= $Page->date_created->cellAttributes() ?>>
<span id="el_permisos_docusers_date_created">
<span<?= $Page->date_created->viewAttributes() ?>>
<?= $Page->date_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
    <a class="btn btn-primary ew-btn" target="_blank" href="<?=_URL_STORE?>doceditor.php?ulang=<?=CurrentLanguageID()?>&nameUser=<?=$sql['name']?>&fileID=<?=$filex['file_name']?>&user=<?=$filex['id_users']?><?=($Page->tipo_permiso->CurrentValue<>'1' )?'&action=view&type=desktop':''?>">Abrir en otro tab</a>

    <iframe id="DocumentFrame"
            title="Onlyoffice"
            width="100%"
            height="1000"
            src="<?=_URL_STORE?>doceditor.php?ulang=<?=CurrentLanguageID()?>&nameUser=<?=$sql['name']?>&fileID=<?=$filex['file_name']?>&user=<?=$filex['id_users']?><?=($Page->tipo_permiso->CurrentValue<>'1' )?'&action=view&type=desktop':''?>">
    </iframe>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
