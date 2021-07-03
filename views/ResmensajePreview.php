<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ResmensajePreview = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid resmensaje"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_resmensaje->Visible) { // id_resmensaje ?>
    <?php if ($Page->SortUrl($Page->id_resmensaje) == "") { ?>
        <th class="<?= $Page->id_resmensaje->headerCellClass() ?>"><?= $Page->id_resmensaje->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_resmensaje->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_resmensaje->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_resmensaje->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_resmensaje->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_resmensaje->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
    <?php if ($Page->SortUrl($Page->id_users) == "") { ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><?= $Page->id_users->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_users->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_users->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_users->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_users->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
    <?php if ($Page->SortUrl($Page->id_inyect) == "") { ?>
        <th class="<?= $Page->id_inyect->headerCellClass() ?>"><?= $Page->id_inyect->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_inyect->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_inyect->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_inyect->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_inyect->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_inyect->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->resadjunto->Visible) { // resadjunto ?>
    <?php if ($Page->SortUrl($Page->resadjunto) == "") { ?>
        <th class="<?= $Page->resadjunto->headerCellClass() ?>"><?= $Page->resadjunto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->resadjunto->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->resadjunto->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->resadjunto->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->resadjunto->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->resadjunto->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->id_resmensaje->Visible) { // id_resmensaje ?>
        <!-- id_resmensaje -->
        <td<?= $Page->id_resmensaje->cellAttributes() ?>>
<span<?= $Page->id_resmensaje->viewAttributes() ?>>
<?= $Page->id_resmensaje->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <!-- id_users -->
        <td<?= $Page->id_users->cellAttributes() ?>>
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <!-- id_inyect -->
        <td<?= $Page->id_inyect->cellAttributes() ?>>
<span<?= $Page->id_inyect->viewAttributes() ?>>
<?= $Page->id_inyect->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->resadjunto->Visible) { // resadjunto ?>
        <!-- resadjunto -->
        <td<?= $Page->resadjunto->cellAttributes() ?>>
<span<?= $Page->resadjunto->viewAttributes() ?>>
<?= GetFileViewTag($Page->resadjunto, $Page->resadjunto->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
