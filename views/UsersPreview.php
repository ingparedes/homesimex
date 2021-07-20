<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UsersPreview = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid users"><!-- .card -->
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
<?php if ($Page->id_users->Visible) { // id_users ?>
    <?php if ($Page->SortUrl($Page->id_users) == "") { ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><?= $Page->id_users->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_users->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_users->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_users->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_users->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <?php if ($Page->SortUrl($Page->fecha) == "") { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><?= $Page->fecha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fecha->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fecha->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fecha->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fecha->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
    <?php if ($Page->SortUrl($Page->nombres) == "") { ?>
        <th class="<?= $Page->nombres->headerCellClass() ?>"><?= $Page->nombres->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nombres->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nombres->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->nombres->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nombres->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->nombres->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
    <?php if ($Page->SortUrl($Page->apellidos) == "") { ?>
        <th class="<?= $Page->apellidos->headerCellClass() ?>"><?= $Page->apellidos->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->apellidos->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->apellidos->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->apellidos->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->apellidos->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->apellidos->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
    <?php if ($Page->SortUrl($Page->grupo) == "") { ?>
        <th class="<?= $Page->grupo->headerCellClass() ?>"><?= $Page->grupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->grupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->grupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->grupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->grupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->grupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
    <?php if ($Page->SortUrl($Page->subgrupo) == "") { ?>
        <th class="<?= $Page->subgrupo->headerCellClass() ?>"><?= $Page->subgrupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->subgrupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->subgrupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->subgrupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->subgrupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->subgrupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
    <?php if ($Page->SortUrl($Page->perfil) == "") { ?>
        <th class="<?= $Page->perfil->headerCellClass() ?>"><?= $Page->perfil->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->perfil->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->perfil->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->perfil->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->perfil->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->perfil->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <?php if ($Page->SortUrl($Page->_email) == "") { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><?= $Page->_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->_email->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->_email->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->_email->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->_email->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
    <?php if ($Page->SortUrl($Page->telefono) == "") { ?>
        <th class="<?= $Page->telefono->headerCellClass() ?>"><?= $Page->telefono->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->telefono->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->telefono->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->telefono->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->telefono->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->telefono->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
    <?php if ($Page->SortUrl($Page->pais) == "") { ?>
        <th class="<?= $Page->pais->headerCellClass() ?>"><?= $Page->pais->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pais->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->pais->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->pais->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->pais->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->pais->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <?php if ($Page->SortUrl($Page->estado) == "") { ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><?= $Page->estado->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->estado->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->estado->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->estado->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->estado->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->organizacion->Visible) { // organizacion ?>
    <?php if ($Page->SortUrl($Page->organizacion) == "") { ?>
        <th class="<?= $Page->organizacion->headerCellClass() ?>"><?= $Page->organizacion->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->organizacion->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->organizacion->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->organizacion->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->organizacion->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->organizacion->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
    <?php if ($Page->SortUrl($Page->img_user) == "") { ?>
        <th class="<?= $Page->img_user->headerCellClass() ?>"><?= $Page->img_user->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->img_user->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->img_user->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->img_user->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->img_user->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->img_user->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->id_users->Visible) { // id_users ?>
        <!-- id_users -->
        <td<?= $Page->id_users->cellAttributes() ?>>
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <!-- fecha -->
        <td<?= $Page->fecha->cellAttributes() ?>>
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <!-- nombres -->
        <td<?= $Page->nombres->cellAttributes() ?>>
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <!-- apellidos -->
        <td<?= $Page->apellidos->cellAttributes() ?>>
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <!-- grupo -->
        <td<?= $Page->grupo->cellAttributes() ?>>
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <!-- subgrupo -->
        <td<?= $Page->subgrupo->cellAttributes() ?>>
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
        <!-- perfil -->
        <td<?= $Page->perfil->cellAttributes() ?>>
<span<?= $Page->perfil->viewAttributes() ?>>
<?= $Page->perfil->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <!-- email -->
        <td<?= $Page->_email->cellAttributes() ?>>
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
        <!-- telefono -->
        <td<?= $Page->telefono->cellAttributes() ?>>
<span<?= $Page->telefono->viewAttributes() ?>>
<?= $Page->telefono->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
        <!-- pais -->
        <td<?= $Page->pais->cellAttributes() ?>>
<span<?= $Page->pais->viewAttributes() ?>>
<?= $Page->pais->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <!-- estado -->
        <td<?= $Page->estado->cellAttributes() ?>>
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->organizacion->Visible) { // organizacion ?>
        <!-- organizacion -->
        <td<?= $Page->organizacion->cellAttributes() ?>>
<span<?= $Page->organizacion->viewAttributes() ?>>
<?= $Page->organizacion->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
        <!-- img_user -->
        <td<?= $Page->img_user->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->img_user, $Page->img_user->getViewValue(), false) ?>
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
