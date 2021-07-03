<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TblTaskDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftbl_taskdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ftbl_taskdelete = currentForm = new ew.Form("ftbl_taskdelete", "delete");
    loadjs.done("ftbl_taskdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.tbl_task) ew.vars.tables.tbl_task = <?= JsonEncode(GetClientVar("tables", "tbl_task")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftbl_taskdelete" id="ftbl_taskdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tbl_task">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_tbl_task_id" class="tbl_task_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <th class="<?= $Page->title->headerCellClass() ?>"><span id="elh_tbl_task_title" class="tbl_task_title"><?= $Page->title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->project_name->Visible) { // project_name ?>
        <th class="<?= $Page->project_name->headerCellClass() ?>"><span id="elh_tbl_task_project_name" class="tbl_task_project_name"><?= $Page->project_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <th class="<?= $Page->status_id->headerCellClass() ?>"><span id="elh_tbl_task_status_id" class="tbl_task_status_id"><?= $Page->status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_tbl_task_created_at" class="tbl_task_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><span id="elh_tbl_task_id_users" class="tbl_task_id_users"><?= $Page->id_users->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tbl_task_id" class="tbl_task_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <td <?= $Page->title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tbl_task_title" class="tbl_task_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->project_name->Visible) { // project_name ?>
        <td <?= $Page->project_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tbl_task_project_name" class="tbl_task_project_name">
<span<?= $Page->project_name->viewAttributes() ?>>
<?= $Page->project_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <td <?= $Page->status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tbl_task_status_id" class="tbl_task_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?= $Page->status_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tbl_task_created_at" class="tbl_task_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <td <?= $Page->id_users->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tbl_task_id_users" class="tbl_task_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
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
