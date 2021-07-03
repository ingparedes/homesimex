<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatReportsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_reportslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    farrowchat_reportslist = currentForm = new ew.Form("farrowchat_reportslist", "list");
    farrowchat_reportslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("farrowchat_reportslist");
});
var farrowchat_reportslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    farrowchat_reportslistsrch = currentSearchForm = new ew.Form("farrowchat_reportslistsrch");

    // Dynamic selection lists

    // Filters
    farrowchat_reportslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farrowchat_reportslistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="farrowchat_reportslistsrch" id="farrowchat_reportslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farrowchat_reportslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="arrowchat_reports">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> arrowchat_reports">
<form name="farrowchat_reportslist" id="farrowchat_reportslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_reports">
<div id="gmp_arrowchat_reports" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_arrowchat_reportslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_arrowchat_reports_id" class="arrowchat_reports_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->report_from->Visible) { // report_from ?>
        <th data-name="report_from" class="<?= $Page->report_from->headerCellClass() ?>"><div id="elh_arrowchat_reports_report_from" class="arrowchat_reports_report_from"><?= $Page->renderSort($Page->report_from) ?></div></th>
<?php } ?>
<?php if ($Page->report_about->Visible) { // report_about ?>
        <th data-name="report_about" class="<?= $Page->report_about->headerCellClass() ?>"><div id="elh_arrowchat_reports_report_about" class="arrowchat_reports_report_about"><?= $Page->renderSort($Page->report_about) ?></div></th>
<?php } ?>
<?php if ($Page->report_chatroom->Visible) { // report_chatroom ?>
        <th data-name="report_chatroom" class="<?= $Page->report_chatroom->headerCellClass() ?>"><div id="elh_arrowchat_reports_report_chatroom" class="arrowchat_reports_report_chatroom"><?= $Page->renderSort($Page->report_chatroom) ?></div></th>
<?php } ?>
<?php if ($Page->report_time->Visible) { // report_time ?>
        <th data-name="report_time" class="<?= $Page->report_time->headerCellClass() ?>"><div id="elh_arrowchat_reports_report_time" class="arrowchat_reports_report_time"><?= $Page->renderSort($Page->report_time) ?></div></th>
<?php } ?>
<?php if ($Page->working_by->Visible) { // working_by ?>
        <th data-name="working_by" class="<?= $Page->working_by->headerCellClass() ?>"><div id="elh_arrowchat_reports_working_by" class="arrowchat_reports_working_by"><?= $Page->renderSort($Page->working_by) ?></div></th>
<?php } ?>
<?php if ($Page->working_time->Visible) { // working_time ?>
        <th data-name="working_time" class="<?= $Page->working_time->headerCellClass() ?>"><div id="elh_arrowchat_reports_working_time" class="arrowchat_reports_working_time"><?= $Page->renderSort($Page->working_time) ?></div></th>
<?php } ?>
<?php if ($Page->completed_by->Visible) { // completed_by ?>
        <th data-name="completed_by" class="<?= $Page->completed_by->headerCellClass() ?>"><div id="elh_arrowchat_reports_completed_by" class="arrowchat_reports_completed_by"><?= $Page->renderSort($Page->completed_by) ?></div></th>
<?php } ?>
<?php if ($Page->completed_time->Visible) { // completed_time ?>
        <th data-name="completed_time" class="<?= $Page->completed_time->headerCellClass() ?>"><div id="elh_arrowchat_reports_completed_time" class="arrowchat_reports_completed_time"><?= $Page->renderSort($Page->completed_time) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_arrowchat_reports", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->report_from->Visible) { // report_from ?>
        <td data-name="report_from" <?= $Page->report_from->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_from">
<span<?= $Page->report_from->viewAttributes() ?>>
<?= $Page->report_from->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->report_about->Visible) { // report_about ?>
        <td data-name="report_about" <?= $Page->report_about->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_about">
<span<?= $Page->report_about->viewAttributes() ?>>
<?= $Page->report_about->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->report_chatroom->Visible) { // report_chatroom ?>
        <td data-name="report_chatroom" <?= $Page->report_chatroom->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_chatroom">
<span<?= $Page->report_chatroom->viewAttributes() ?>>
<?= $Page->report_chatroom->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->report_time->Visible) { // report_time ?>
        <td data-name="report_time" <?= $Page->report_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_report_time">
<span<?= $Page->report_time->viewAttributes() ?>>
<?= $Page->report_time->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->working_by->Visible) { // working_by ?>
        <td data-name="working_by" <?= $Page->working_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_working_by">
<span<?= $Page->working_by->viewAttributes() ?>>
<?= $Page->working_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->working_time->Visible) { // working_time ?>
        <td data-name="working_time" <?= $Page->working_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_working_time">
<span<?= $Page->working_time->viewAttributes() ?>>
<?= $Page->working_time->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->completed_by->Visible) { // completed_by ?>
        <td data-name="completed_by" <?= $Page->completed_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_completed_by">
<span<?= $Page->completed_by->viewAttributes() ?>>
<?= $Page->completed_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->completed_time->Visible) { // completed_time ?>
        <td data-name="completed_time" <?= $Page->completed_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_reports_completed_time">
<span<?= $Page->completed_time->viewAttributes() ?>>
<?= $Page->completed_time->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("arrowchat_reports");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
