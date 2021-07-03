<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatTrayiconsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_trayiconslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    farrowchat_trayiconslist = currentForm = new ew.Form("farrowchat_trayiconslist", "list");
    farrowchat_trayiconslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("farrowchat_trayiconslist");
});
var farrowchat_trayiconslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    farrowchat_trayiconslistsrch = currentSearchForm = new ew.Form("farrowchat_trayiconslistsrch");

    // Dynamic selection lists

    // Filters
    farrowchat_trayiconslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farrowchat_trayiconslistsrch");
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
<form name="farrowchat_trayiconslistsrch" id="farrowchat_trayiconslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farrowchat_trayiconslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="arrowchat_trayicons">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> arrowchat_trayicons">
<form name="farrowchat_trayiconslist" id="farrowchat_trayiconslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_trayicons">
<div id="gmp_arrowchat_trayicons" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_arrowchat_trayiconslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_id" class="arrowchat_trayicons_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_name" class="arrowchat_trayicons_name"><?= $Page->renderSort($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
        <th data-name="icon" class="<?= $Page->icon->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_icon" class="arrowchat_trayicons_icon"><?= $Page->renderSort($Page->icon) ?></div></th>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
        <th data-name="location" class="<?= $Page->location->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_location" class="arrowchat_trayicons_location"><?= $Page->renderSort($Page->location) ?></div></th>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
        <th data-name="target" class="<?= $Page->target->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_target" class="arrowchat_trayicons_target"><?= $Page->renderSort($Page->target) ?></div></th>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
        <th data-name="width" class="<?= $Page->width->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_width" class="arrowchat_trayicons_width"><?= $Page->renderSort($Page->width) ?></div></th>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
        <th data-name="height" class="<?= $Page->height->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_height" class="arrowchat_trayicons_height"><?= $Page->renderSort($Page->height) ?></div></th>
<?php } ?>
<?php if ($Page->tray_width->Visible) { // tray_width ?>
        <th data-name="tray_width" class="<?= $Page->tray_width->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_tray_width" class="arrowchat_trayicons_tray_width"><?= $Page->renderSort($Page->tray_width) ?></div></th>
<?php } ?>
<?php if ($Page->tray_name->Visible) { // tray_name ?>
        <th data-name="tray_name" class="<?= $Page->tray_name->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_tray_name" class="arrowchat_trayicons_tray_name"><?= $Page->renderSort($Page->tray_name) ?></div></th>
<?php } ?>
<?php if ($Page->tray_location->Visible) { // tray_location ?>
        <th data-name="tray_location" class="<?= $Page->tray_location->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_tray_location" class="arrowchat_trayicons_tray_location"><?= $Page->renderSort($Page->tray_location) ?></div></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th data-name="active" class="<?= $Page->active->headerCellClass() ?>"><div id="elh_arrowchat_trayicons_active" class="arrowchat_trayicons_active"><?= $Page->renderSort($Page->active) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_arrowchat_trayicons", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->icon->Visible) { // icon ?>
        <td data-name="icon" <?= $Page->icon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_icon">
<span<?= $Page->icon->viewAttributes() ?>>
<?= $Page->icon->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->location->Visible) { // location ?>
        <td data-name="location" <?= $Page->location->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_location">
<span<?= $Page->location->viewAttributes() ?>>
<?= $Page->location->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->target->Visible) { // target ?>
        <td data-name="target" <?= $Page->target->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_target">
<span<?= $Page->target->viewAttributes() ?>>
<?= $Page->target->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->width->Visible) { // width ?>
        <td data-name="width" <?= $Page->width->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_width">
<span<?= $Page->width->viewAttributes() ?>>
<?= $Page->width->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->height->Visible) { // height ?>
        <td data-name="height" <?= $Page->height->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_height">
<span<?= $Page->height->viewAttributes() ?>>
<?= $Page->height->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tray_width->Visible) { // tray_width ?>
        <td data-name="tray_width" <?= $Page->tray_width->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_tray_width">
<span<?= $Page->tray_width->viewAttributes() ?>>
<?= $Page->tray_width->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tray_name->Visible) { // tray_name ?>
        <td data-name="tray_name" <?= $Page->tray_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_tray_name">
<span<?= $Page->tray_name->viewAttributes() ?>>
<?= $Page->tray_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tray_location->Visible) { // tray_location ?>
        <td data-name="tray_location" <?= $Page->tray_location->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_tray_location">
<span<?= $Page->tray_location->viewAttributes() ?>>
<?= $Page->tray_location->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->active->Visible) { // active ?>
        <td data-name="active" <?= $Page->active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_active">
<span<?= $Page->active->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
</div></span>
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
    ew.addEventHandlers("arrowchat_trayicons");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
