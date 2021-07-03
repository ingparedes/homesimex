<?php

namespace PHPMaker2021\simexamerica;

// Table
$subgrupo = Container("subgrupo");
?>
<?php if ($subgrupo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_subgrupomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($subgrupo->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <tr id="r_imagen_subgrupo">
            <td class="<?= $subgrupo->TableLeftColumnClass ?>"><?= $subgrupo->imagen_subgrupo->caption() ?></td>
            <td <?= $subgrupo->imagen_subgrupo->cellAttributes() ?>>
<span id="el_subgrupo_imagen_subgrupo">
<span>
<?= GetFileViewTag($subgrupo->imagen_subgrupo, $subgrupo->imagen_subgrupo->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($subgrupo->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <tr id="r_nombre_subgrupo">
            <td class="<?= $subgrupo->TableLeftColumnClass ?>"><?= $subgrupo->nombre_subgrupo->caption() ?></td>
            <td <?= $subgrupo->nombre_subgrupo->cellAttributes() ?>>
<span id="el_subgrupo_nombre_subgrupo">
<span<?= $subgrupo->nombre_subgrupo->viewAttributes() ?>>
<?= $subgrupo->nombre_subgrupo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($subgrupo->descripcion_subgrupo->Visible) { // descripcion_subgrupo ?>
        <tr id="r_descripcion_subgrupo">
            <td class="<?= $subgrupo->TableLeftColumnClass ?>"><?= $subgrupo->descripcion_subgrupo->caption() ?></td>
            <td <?= $subgrupo->descripcion_subgrupo->cellAttributes() ?>>
<span id="el_subgrupo_descripcion_subgrupo">
<span<?= $subgrupo->descripcion_subgrupo->viewAttributes() ?>>
<?= $subgrupo->descripcion_subgrupo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
