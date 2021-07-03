<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatReportsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_reportsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_reportsview = currentForm = new ew.Form("farrowchat_reportsview", "view");
    loadjs.done("farrowchat_reportsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_reports) ew.vars.tables.arrowchat_reports = <?= JsonEncode(GetClientVar("tables", "arrowchat_reports")) ?>;
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
<form name="farrowchat_reportsview" id="farrowchat_reportsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_reports">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_reports_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->report_from->Visible) { // report_from ?>
    <tr id="r_report_from">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_report_from"><?= $Page->report_from->caption() ?></span></td>
        <td data-name="report_from" <?= $Page->report_from->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_from">
<span<?= $Page->report_from->viewAttributes() ?>>
<?= $Page->report_from->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->report_about->Visible) { // report_about ?>
    <tr id="r_report_about">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_report_about"><?= $Page->report_about->caption() ?></span></td>
        <td data-name="report_about" <?= $Page->report_about->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_about">
<span<?= $Page->report_about->viewAttributes() ?>>
<?= $Page->report_about->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->report_chatroom->Visible) { // report_chatroom ?>
    <tr id="r_report_chatroom">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_report_chatroom"><?= $Page->report_chatroom->caption() ?></span></td>
        <td data-name="report_chatroom" <?= $Page->report_chatroom->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_chatroom">
<span<?= $Page->report_chatroom->viewAttributes() ?>>
<?= $Page->report_chatroom->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->report_time->Visible) { // report_time ?>
    <tr id="r_report_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_report_time"><?= $Page->report_time->caption() ?></span></td>
        <td data-name="report_time" <?= $Page->report_time->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_time">
<span<?= $Page->report_time->viewAttributes() ?>>
<?= $Page->report_time->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->working_by->Visible) { // working_by ?>
    <tr id="r_working_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_working_by"><?= $Page->working_by->caption() ?></span></td>
        <td data-name="working_by" <?= $Page->working_by->cellAttributes() ?>>
<span id="el_arrowchat_reports_working_by">
<span<?= $Page->working_by->viewAttributes() ?>>
<?= $Page->working_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->working_time->Visible) { // working_time ?>
    <tr id="r_working_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_working_time"><?= $Page->working_time->caption() ?></span></td>
        <td data-name="working_time" <?= $Page->working_time->cellAttributes() ?>>
<span id="el_arrowchat_reports_working_time">
<span<?= $Page->working_time->viewAttributes() ?>>
<?= $Page->working_time->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->completed_by->Visible) { // completed_by ?>
    <tr id="r_completed_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_completed_by"><?= $Page->completed_by->caption() ?></span></td>
        <td data-name="completed_by" <?= $Page->completed_by->cellAttributes() ?>>
<span id="el_arrowchat_reports_completed_by">
<span<?= $Page->completed_by->viewAttributes() ?>>
<?= $Page->completed_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->completed_time->Visible) { // completed_time ?>
    <tr id="r_completed_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_reports_completed_time"><?= $Page->completed_time->caption() ?></span></td>
        <td data-name="completed_time" <?= $Page->completed_time->cellAttributes() ?>>
<span id="el_arrowchat_reports_completed_time">
<span<?= $Page->completed_time->viewAttributes() ?>>
<?= $Page->completed_time->getViewValue() ?></span>
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
