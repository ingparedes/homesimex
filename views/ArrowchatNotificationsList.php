<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatNotificationsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_notificationslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    farrowchat_notificationslist = currentForm = new ew.Form("farrowchat_notificationslist", "list");
    farrowchat_notificationslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("farrowchat_notificationslist");
});
var farrowchat_notificationslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    farrowchat_notificationslistsrch = currentSearchForm = new ew.Form("farrowchat_notificationslistsrch");

    // Dynamic selection lists

    // Filters
    farrowchat_notificationslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farrowchat_notificationslistsrch");
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
<form name="farrowchat_notificationslistsrch" id="farrowchat_notificationslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farrowchat_notificationslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="arrowchat_notifications">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> arrowchat_notifications">
<form name="farrowchat_notificationslist" id="farrowchat_notificationslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_notifications">
<div id="gmp_arrowchat_notifications" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_arrowchat_notificationslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_arrowchat_notifications_id" class="arrowchat_notifications_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->to_id->Visible) { // to_id ?>
        <th data-name="to_id" class="<?= $Page->to_id->headerCellClass() ?>"><div id="elh_arrowchat_notifications_to_id" class="arrowchat_notifications_to_id"><?= $Page->renderSort($Page->to_id) ?></div></th>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
        <th data-name="author_id" class="<?= $Page->author_id->headerCellClass() ?>"><div id="elh_arrowchat_notifications_author_id" class="arrowchat_notifications_author_id"><?= $Page->renderSort($Page->author_id) ?></div></th>
<?php } ?>
<?php if ($Page->author_name->Visible) { // author_name ?>
        <th data-name="author_name" class="<?= $Page->author_name->headerCellClass() ?>"><div id="elh_arrowchat_notifications_author_name" class="arrowchat_notifications_author_name"><?= $Page->renderSort($Page->author_name) ?></div></th>
<?php } ?>
<?php if ($Page->misc1->Visible) { // misc1 ?>
        <th data-name="misc1" class="<?= $Page->misc1->headerCellClass() ?>"><div id="elh_arrowchat_notifications_misc1" class="arrowchat_notifications_misc1"><?= $Page->renderSort($Page->misc1) ?></div></th>
<?php } ?>
<?php if ($Page->misc2->Visible) { // misc2 ?>
        <th data-name="misc2" class="<?= $Page->misc2->headerCellClass() ?>"><div id="elh_arrowchat_notifications_misc2" class="arrowchat_notifications_misc2"><?= $Page->renderSort($Page->misc2) ?></div></th>
<?php } ?>
<?php if ($Page->misc3->Visible) { // misc3 ?>
        <th data-name="misc3" class="<?= $Page->misc3->headerCellClass() ?>"><div id="elh_arrowchat_notifications_misc3" class="arrowchat_notifications_misc3"><?= $Page->renderSort($Page->misc3) ?></div></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th data-name="type" class="<?= $Page->type->headerCellClass() ?>"><div id="elh_arrowchat_notifications_type" class="arrowchat_notifications_type"><?= $Page->renderSort($Page->type) ?></div></th>
<?php } ?>
<?php if ($Page->alert_read->Visible) { // alert_read ?>
        <th data-name="alert_read" class="<?= $Page->alert_read->headerCellClass() ?>"><div id="elh_arrowchat_notifications_alert_read" class="arrowchat_notifications_alert_read"><?= $Page->renderSort($Page->alert_read) ?></div></th>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <th data-name="user_read" class="<?= $Page->user_read->headerCellClass() ?>"><div id="elh_arrowchat_notifications_user_read" class="arrowchat_notifications_user_read"><?= $Page->renderSort($Page->user_read) ?></div></th>
<?php } ?>
<?php if ($Page->alert_time->Visible) { // alert_time ?>
        <th data-name="alert_time" class="<?= $Page->alert_time->headerCellClass() ?>"><div id="elh_arrowchat_notifications_alert_time" class="arrowchat_notifications_alert_time"><?= $Page->renderSort($Page->alert_time) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_arrowchat_notifications", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->to_id->Visible) { // to_id ?>
        <td data-name="to_id" <?= $Page->to_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_to_id">
<span<?= $Page->to_id->viewAttributes() ?>>
<?= $Page->to_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->author_id->Visible) { // author_id ?>
        <td data-name="author_id" <?= $Page->author_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_author_id">
<span<?= $Page->author_id->viewAttributes() ?>>
<?= $Page->author_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->author_name->Visible) { // author_name ?>
        <td data-name="author_name" <?= $Page->author_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_author_name">
<span<?= $Page->author_name->viewAttributes() ?>>
<?= $Page->author_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->misc1->Visible) { // misc1 ?>
        <td data-name="misc1" <?= $Page->misc1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_misc1">
<span<?= $Page->misc1->viewAttributes() ?>>
<?= $Page->misc1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->misc2->Visible) { // misc2 ?>
        <td data-name="misc2" <?= $Page->misc2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_misc2">
<span<?= $Page->misc2->viewAttributes() ?>>
<?= $Page->misc2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->misc3->Visible) { // misc3 ?>
        <td data-name="misc3" <?= $Page->misc3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_misc3">
<span<?= $Page->misc3->viewAttributes() ?>>
<?= $Page->misc3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->type->Visible) { // type ?>
        <td data-name="type" <?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->alert_read->Visible) { // alert_read ?>
        <td data-name="alert_read" <?= $Page->alert_read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_alert_read">
<span<?= $Page->alert_read->viewAttributes() ?>>
<?= $Page->alert_read->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user_read->Visible) { // user_read ?>
        <td data-name="user_read" <?= $Page->user_read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<?= $Page->user_read->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->alert_time->Visible) { // alert_time ?>
        <td data-name="alert_time" <?= $Page->alert_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_alert_time">
<span<?= $Page->alert_time->viewAttributes() ?>>
<?= $Page->alert_time->getViewValue() ?></span>
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
    ew.addEventHandlers("arrowchat_notifications");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
