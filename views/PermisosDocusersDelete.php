<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocusersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpermisos_docusersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpermisos_docusersdelete = currentForm = new ew.Form("fpermisos_docusersdelete", "delete");
    loadjs.done("fpermisos_docusersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.permisos_docusers) ew.vars.tables.permisos_docusers = <?= JsonEncode(GetClientVar("tables", "permisos_docusers")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpermisos_docusersdelete" id="fpermisos_docusersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_docusers">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id_permisiosuser->Visible) { // id_permisiosuser ?>
        <th class="<?= $Page->id_permisiosuser->headerCellClass() ?>"><span id="elh_permisos_docusers_id_permisiosuser" class="permisos_docusers_id_permisiosuser"><?= $Page->id_permisiosuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
        <th class="<?= $Page->id_file->headerCellClass() ?>"><span id="elh_permisos_docusers_id_file" class="permisos_docusers_id_file"><?= $Page->id_file->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
        <th class="<?= $Page->tipo_permiso->headerCellClass() ?>"><span id="elh_permisos_docusers_tipo_permiso" class="permisos_docusers_tipo_permiso"><?= $Page->tipo_permiso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><span id="elh_permisos_docusers_id_users" class="permisos_docusers_id_users"><?= $Page->id_users->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_created->Visible) { // date_created ?>
        <th class="<?= $Page->date_created->headerCellClass() ?>"><span id="elh_permisos_docusers_date_created" class="permisos_docusers_date_created"><?= $Page->date_created->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id_permisiosuser->Visible) { // id_permisiosuser ?>
        <td <?= $Page->id_permisiosuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_docusers_id_permisiosuser" class="permisos_docusers_id_permisiosuser">
<span<?= $Page->id_permisiosuser->viewAttributes() ?>>
<?= $Page->id_permisiosuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
        <td <?= $Page->id_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_docusers_id_file" class="permisos_docusers_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<?= $Page->id_file->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
        <td <?= $Page->tipo_permiso->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_docusers_tipo_permiso" class="permisos_docusers_tipo_permiso">
<span<?= $Page->tipo_permiso->viewAttributes() ?>>
<?= $Page->tipo_permiso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <td <?= $Page->id_users->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_docusers_id_users" class="permisos_docusers_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_created->Visible) { // date_created ?>
        <td <?= $Page->date_created->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_docusers_date_created" class="permisos_docusers_date_created">
<span<?= $Page->date_created->viewAttributes() ?>>
<?= $Page->date_created->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
