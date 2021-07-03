<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchatlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    farrowchatlist = currentForm = new ew.Form("farrowchatlist", "list");
    farrowchatlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("farrowchatlist");
});
var farrowchatlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    farrowchatlistsrch = currentSearchForm = new ew.Form("farrowchatlistsrch");

    // Dynamic selection lists

    // Filters
    farrowchatlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farrowchatlistsrch");
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
<form name="farrowchatlistsrch" id="farrowchatlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farrowchatlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="arrowchat">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> arrowchat">
<form name="farrowchatlist" id="farrowchatlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat">
<div id="gmp_arrowchat" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_arrowchatlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_arrowchat_id" class="arrowchat_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->_from->Visible) { // from ?>
        <th data-name="_from" class="<?= $Page->_from->headerCellClass() ?>"><div id="elh_arrowchat__from" class="arrowchat__from"><?= $Page->renderSort($Page->_from) ?></div></th>
<?php } ?>
<?php if ($Page->to->Visible) { // to ?>
        <th data-name="to" class="<?= $Page->to->headerCellClass() ?>"><div id="elh_arrowchat_to" class="arrowchat_to"><?= $Page->renderSort($Page->to) ?></div></th>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
        <th data-name="sent" class="<?= $Page->sent->headerCellClass() ?>"><div id="elh_arrowchat_sent" class="arrowchat_sent"><?= $Page->renderSort($Page->sent) ?></div></th>
<?php } ?>
<?php if ($Page->read->Visible) { // read ?>
        <th data-name="read" class="<?= $Page->read->headerCellClass() ?>"><div id="elh_arrowchat_read" class="arrowchat_read"><?= $Page->renderSort($Page->read) ?></div></th>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <th data-name="user_read" class="<?= $Page->user_read->headerCellClass() ?>"><div id="elh_arrowchat_user_read" class="arrowchat_user_read"><?= $Page->renderSort($Page->user_read) ?></div></th>
<?php } ?>
<?php if ($Page->direction->Visible) { // direction ?>
        <th data-name="direction" class="<?= $Page->direction->headerCellClass() ?>"><div id="elh_arrowchat_direction" class="arrowchat_direction"><?= $Page->renderSort($Page->direction) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_arrowchat", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_arrowchat_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_from->Visible) { // from ?>
        <td data-name="_from" <?= $Page->_from->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat__from">
<span<?= $Page->_from->viewAttributes() ?>>
<?= $Page->_from->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->to->Visible) { // to ?>
        <td data-name="to" <?= $Page->to->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_to">
<span<?= $Page->to->viewAttributes() ?>>
<?= $Page->to->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sent->Visible) { // sent ?>
        <td data-name="sent" <?= $Page->sent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_sent">
<span<?= $Page->sent->viewAttributes() ?>>
<?= $Page->sent->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->read->Visible) { // read ?>
        <td data-name="read" <?= $Page->read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_read">
<span<?= $Page->read->viewAttributes() ?>>
<?= $Page->read->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user_read->Visible) { // user_read ?>
        <td data-name="user_read" <?= $Page->user_read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_user_read_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->user_read->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->user_read->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_user_read_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->direction->Visible) { // direction ?>
        <td data-name="direction" <?= $Page->direction->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_direction">
<span<?= $Page->direction->viewAttributes() ?>>
<?= $Page->direction->getViewValue() ?></span>
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
    ew.addEventHandlers("arrowchat");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
