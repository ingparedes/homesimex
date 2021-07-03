<?php

namespace PHPMaker2021\simexamerica;

// Table
$grupo = Container("grupo");
?>
<?php if ($grupo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_grupomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($grupo->imgen_grupo->Visible) { // imgen_grupo ?>
        <tr id="r_imgen_grupo">
            <td class="<?= $grupo->TableLeftColumnClass ?>"><?= $grupo->imgen_grupo->caption() ?></td>
            <td <?= $grupo->imgen_grupo->cellAttributes() ?>>
<span id="el_grupo_imgen_grupo">
<span>
<?= GetFileViewTag($grupo->imgen_grupo, $grupo->imgen_grupo->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($grupo->nombre_grupo->Visible) { // nombre_grupo ?>
        <tr id="r_nombre_grupo">
            <td class="<?= $grupo->TableLeftColumnClass ?>"><?= $grupo->nombre_grupo->caption() ?></td>
            <td <?= $grupo->nombre_grupo->cellAttributes() ?>>
<span id="el_grupo_nombre_grupo">
<span<?= $grupo->nombre_grupo->viewAttributes() ?>>
<?= $grupo->nombre_grupo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($grupo->descripcion_grupo->Visible) { // descripcion_grupo ?>
        <tr id="r_descripcion_grupo">
            <td class="<?= $grupo->TableLeftColumnClass ?>"><?= $grupo->descripcion_grupo->caption() ?></td>
            <td <?= $grupo->descripcion_grupo->cellAttributes() ?>>
<span id="el_grupo_descripcion_grupo">
<span<?= $grupo->descripcion_grupo->viewAttributes() ?>>
<?= $grupo->descripcion_grupo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($grupo->color->Visible) { // color ?>
        <tr id="r_color">
            <td class="<?= $grupo->TableLeftColumnClass ?>"><?= $grupo->color->caption() ?></td>
            <td <?= $grupo->color->cellAttributes() ?>>
<span id="el_grupo_color">
<span<?= $grupo->color->viewAttributes() ?>><div class="card" style="max-width: 6rem; background-color: <?php echo CurrentPage()->color->CurrentValue; ?>;">
    <div class="card-body">
  </div>
</div>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
