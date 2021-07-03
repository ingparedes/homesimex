<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TblTaskView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftbl_taskview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ftbl_taskview = currentForm = new ew.Form("ftbl_taskview", "view");
    loadjs.done("ftbl_taskview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.tbl_task) ew.vars.tables.tbl_task = <?= JsonEncode(GetClientVar("tables", "tbl_task")) ?>;
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
<form name="ftbl_taskview" id="ftbl_taskview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tbl_task">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tbl_task_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_tbl_task_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <tr id="r_title">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tbl_task_title"><?= $Page->title->caption() ?></span></td>
        <td data-name="title" <?= $Page->title->cellAttributes() ?>>
<span id="el_tbl_task_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tbl_task_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el_tbl_task_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->project_name->Visible) { // project_name ?>
    <tr id="r_project_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tbl_task_project_name"><?= $Page->project_name->caption() ?></span></td>
        <td data-name="project_name" <?= $Page->project_name->cellAttributes() ?>>
<span id="el_tbl_task_project_name">
<span<?= $Page->project_name->viewAttributes() ?>>
<?= $Page->project_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <tr id="r_status_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tbl_task_status_id"><?= $Page->status_id->caption() ?></span></td>
        <td data-name="status_id" <?= $Page->status_id->cellAttributes() ?>>
<span id="el_tbl_task_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?= $Page->status_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tbl_task_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_tbl_task_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
    <tr id="r_id_users">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tbl_task_id_users"><?= $Page->id_users->caption() ?></span></td>
        <td data-name="id_users" <?= $Page->id_users->cellAttributes() ?>>
<span id="el_tbl_task_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
