<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocusersView = &$Page;
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
<form name="fpermisos_docusersview" id="fpermisos_docusersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_docusers">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id_file->Visible) { // id_file ?>
    <tr id="r_id_file">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_docusers_id_file"><template id="tpc_permisos_docusers_id_file"><?= $Page->id_file->caption() ?></template></span></td>
        <td data-name="id_file" <?= $Page->id_file->cellAttributes() ?>>
<template id="tpx_permisos_docusers_id_file" class="permisos_docusersview">
<?php
$id = CurrentPage()->id_file->CurrentValue;
$filex = Executerow("SELECT file_name FROM archivos_doc WHERE id_file = '".$id."';");
echo $filex['0'];
?>
</template>
<template id="tpx_permisos_docusers_id_file"><span id="el_permisos_docusers_id_file">
<span<?= $Page->id_file->viewAttributes() ?>><slot name="tpx_permisos_docusers_id_file"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
    <tr id="r_tipo_permiso">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_docusers_tipo_permiso"><template id="tpc_permisos_docusers_tipo_permiso"><?= $Page->tipo_permiso->caption() ?></template></span></td>
        <td data-name="tipo_permiso" <?= $Page->tipo_permiso->cellAttributes() ?>>
<template id="tpx_permisos_docusers_tipo_permiso"><span id="el_permisos_docusers_tipo_permiso">
<span<?= $Page->tipo_permiso->viewAttributes() ?>>
<?= $Page->tipo_permiso->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_permisos_docusersview" class="ew-custom-template"></div>
<template id="tpm_permisos_docusersview">
<div id="ct_PermisosDocusersView"><?php
$sql = ExecuteRow("Select concat(nombres,' ',apellidos)  'name'  from users where id_users =".CurrentUserID().";");
?>
<div> <strong> <?= $Page->id_file->caption() ?></strong>:<slot class="ew-slot" name="tpx_permisos_docusers_id_file"></slot></div>
<div> <strong><?= $Page->tipo_permiso->caption() ?></strong>  : <slot class="ew-slot" name="tpx_permisos_docusers_tipo_permiso"></slot></div>
<a class="btn btn-primary ew-btn" target="_blank" href="http://190.85.49.114:8181/doceditor.php?nameUser=<?=$sql['name']?>&fileID=<?=$filex['file_name']?>&user=<?=$filex['id_users']?><?=($Page->tipo_permiso->CurrentValue<>'1' )?'&action=view&type=desktop':''?>">Abrir en otro tab</a>
<div class="embed-responsive embed-responsive-16by9">
     <iframe id="DocumentFrame"
     		class="embed-responsive-item"
            src="http://190.85.49.114:8181/doceditor.php?nameUser=<?=$sql['name']?>&fileID=<?=$filex['file_name']?>&user=<?=$filex['id_users']?><?=($Page->tipo_permiso->CurrentValue<>'1' )?'&action=view&type=desktop':''?>" allowfullscreen >
    </iframe>
<div> 
</div>
</template>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_permisos_docusersview", "tpm_permisos_docusersview", "permisos_docusersview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
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
