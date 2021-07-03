<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatReportsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_reportsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_reportsdelete = currentForm = new ew.Form("farrowchat_reportsdelete", "delete");
    loadjs.done("farrowchat_reportsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_reports) ew.vars.tables.arrowchat_reports = <?= JsonEncode(GetClientVar("tables", "arrowchat_reports")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_reportsdelete" id="farrowchat_reportsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_reports">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_reports_id" class="arrowchat_reports_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->report_from->Visible) { // report_from ?>
        <th class="<?= $Page->report_from->headerCellClass() ?>"><span id="elh_arrowchat_reports_report_from" class="arrowchat_reports_report_from"><?= $Page->report_from->caption() ?></span></th>
<?php } ?>
<?php if ($Page->report_about->Visible) { // report_about ?>
        <th class="<?= $Page->report_about->headerCellClass() ?>"><span id="elh_arrowchat_reports_report_about" class="arrowchat_reports_report_about"><?= $Page->report_about->caption() ?></span></th>
<?php } ?>
<?php if ($Page->report_chatroom->Visible) { // report_chatroom ?>
        <th class="<?= $Page->report_chatroom->headerCellClass() ?>"><span id="elh_arrowchat_reports_report_chatroom" class="arrowchat_reports_report_chatroom"><?= $Page->report_chatroom->caption() ?></span></th>
<?php } ?>
<?php if ($Page->report_time->Visible) { // report_time ?>
        <th class="<?= $Page->report_time->headerCellClass() ?>"><span id="elh_arrowchat_reports_report_time" class="arrowchat_reports_report_time"><?= $Page->report_time->caption() ?></span></th>
<?php } ?>
<?php if ($Page->working_by->Visible) { // working_by ?>
        <th class="<?= $Page->working_by->headerCellClass() ?>"><span id="elh_arrowchat_reports_working_by" class="arrowchat_reports_working_by"><?= $Page->working_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->working_time->Visible) { // working_time ?>
        <th class="<?= $Page->working_time->headerCellClass() ?>"><span id="elh_arrowchat_reports_working_time" class="arrowchat_reports_working_time"><?= $Page->working_time->caption() ?></span></th>
<?php } ?>
<?php if ($Page->completed_by->Visible) { // completed_by ?>
        <th class="<?= $Page->completed_by->headerCellClass() ?>"><span id="elh_arrowchat_reports_completed_by" class="arrowchat_reports_completed_by"><?= $Page->completed_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->completed_time->Visible) { // completed_time ?>
        <th class="<?= $Page->completed_time->headerCellClass() ?>"><span id="elh_arrowchat_reports_completed_time" class="arrowchat_reports_completed_time"><?= $Page->completed_time->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_id" class="arrowchat_reports_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->report_from->Visible) { // report_from ?>
        <td <?= $Page->report_from->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_from" class="arrowchat_reports_report_from">
<span<?= $Page->report_from->viewAttributes() ?>>
<?= $Page->report_from->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->report_about->Visible) { // report_about ?>
        <td <?= $Page->report_about->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_about" class="arrowchat_reports_report_about">
<span<?= $Page->report_about->viewAttributes() ?>>
<?= $Page->report_about->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->report_chatroom->Visible) { // report_chatroom ?>
        <td <?= $Page->report_chatroom->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_chatroom" class="arrowchat_reports_report_chatroom">
<span<?= $Page->report_chatroom->viewAttributes() ?>>
<?= $Page->report_chatroom->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->report_time->Visible) { // report_time ?>
        <td <?= $Page->report_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_time" class="arrowchat_reports_report_time">
<span<?= $Page->report_time->viewAttributes() ?>>
<?= $Page->report_time->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->working_by->Visible) { // working_by ?>
        <td <?= $Page->working_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_working_by" class="arrowchat_reports_working_by">
<span<?= $Page->working_by->viewAttributes() ?>>
<?= $Page->working_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->working_time->Visible) { // working_time ?>
        <td <?= $Page->working_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_working_time" class="arrowchat_reports_working_time">
<span<?= $Page->working_time->viewAttributes() ?>>
<?= $Page->working_time->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->completed_by->Visible) { // completed_by ?>
        <td <?= $Page->completed_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_completed_by" class="arrowchat_reports_completed_by">
<span<?= $Page->completed_by->viewAttributes() ?>>
<?= $Page->completed_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->completed_time->Visible) { // completed_time ?>
        <td <?= $Page->completed_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_completed_time" class="arrowchat_reports_completed_time">
<span<?= $Page->completed_time->viewAttributes() ?>>
<?= $Page->completed_time->getViewValue() ?></span>
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
