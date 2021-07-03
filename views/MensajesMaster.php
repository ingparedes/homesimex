<?php

namespace PHPMaker2021\simexamerica;

// Table
$mensajes = Container("mensajes");
?>
<?php if ($mensajes->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_mensajesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($mensajes->id_inyect->Visible) { // id_inyect ?>
        <tr id="r_id_inyect">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->id_inyect->caption() ?></td>
            <td <?= $mensajes->id_inyect->cellAttributes() ?>>
<span id="el_mensajes_id_inyect">
<span<?= $mensajes->id_inyect->viewAttributes() ?>>
<?= $mensajes->id_inyect->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mensajes->titulo->Visible) { // titulo ?>
        <tr id="r_titulo">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->titulo->caption() ?></td>
            <td <?= $mensajes->titulo->cellAttributes() ?>>
<span id="el_mensajes_titulo">
<span<?= $mensajes->titulo->viewAttributes() ?>>
<?php if (!EmptyString($mensajes->titulo->TooltipValue) && $mensajes->titulo->linkAttributes() != "") { ?>
<a<?= $mensajes->titulo->linkAttributes() ?>><?= $mensajes->titulo->getViewValue() ?></a>
<?php } else { ?>
<?= $mensajes->titulo->getViewValue() ?>
<?php } ?>
<span id="tt_mensajes_x_titulo" class="d-none">
<?= $mensajes->titulo->TooltipValue ?>
</span></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mensajes->mensaje->Visible) { // mensaje ?>
        <tr id="r_mensaje">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->mensaje->caption() ?></td>
            <td <?= $mensajes->mensaje->cellAttributes() ?>>
<span id="el_mensajes_mensaje">
<span<?= $mensajes->mensaje->viewAttributes() ?>>
<?= $mensajes->mensaje->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mensajes->fechareal_start->Visible) { // fechareal_start ?>
        <tr id="r_fechareal_start">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->fechareal_start->caption() ?></td>
            <td <?= $mensajes->fechareal_start->cellAttributes() ?>>
<span id="el_mensajes_fechareal_start">
<span<?= $mensajes->fechareal_start->viewAttributes() ?>>
<?= $mensajes->fechareal_start->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mensajes->fechasim_start->Visible) { // fechasim_start ?>
        <tr id="r_fechasim_start">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->fechasim_start->caption() ?></td>
            <td <?= $mensajes->fechasim_start->cellAttributes() ?>>
<span id="el_mensajes_fechasim_start">
<span<?= $mensajes->fechasim_start->viewAttributes() ?>>
<?= $mensajes->fechasim_start->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mensajes->id_actor->Visible) { // id_actor ?>
        <tr id="r_id_actor">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->id_actor->caption() ?></td>
            <td <?= $mensajes->id_actor->cellAttributes() ?>>
<span id="el_mensajes_id_actor">
<span<?= $mensajes->id_actor->viewAttributes() ?>>
<?= $mensajes->id_actor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mensajes->para->Visible) { // para ?>
        <tr id="r_para">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->para->caption() ?></td>
            <td <?= $mensajes->para->cellAttributes() ?>>
<span id="el_mensajes_para">
<span<?= $mensajes->para->viewAttributes() ?>>
<?= $mensajes->para->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mensajes->adjunto->Visible) { // adjunto ?>
        <tr id="r_adjunto">
            <td class="<?= $mensajes->TableLeftColumnClass ?>"><?= $mensajes->adjunto->caption() ?></td>
            <td <?= $mensajes->adjunto->cellAttributes() ?>>
<span id="el_mensajes_adjunto">
<span<?= $mensajes->adjunto->viewAttributes() ?>>
<?php if (!EmptyString($mensajes->adjunto->getViewValue()) && $mensajes->adjunto->linkAttributes() != "") { ?>
<a<?= $mensajes->adjunto->linkAttributes() ?>><?= $mensajes->adjunto->getViewValue() ?></a>
<?php } else { ?>
<?= $mensajes->adjunto->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
