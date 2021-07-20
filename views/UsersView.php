<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UsersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fusersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fusersview = currentForm = new ew.Form("fusersview", "view");
    loadjs.done("fusersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.users) ew.vars.tables.users = <?= JsonEncode(GetClientVar("tables", "users")) ?>;
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
<form name="fusersview" id="fusersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha" <?= $Page->fecha->cellAttributes() ?>>
<span id="el_users_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
    <tr id="r_nombres">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_nombres"><?= $Page->nombres->caption() ?></span></td>
        <td data-name="nombres" <?= $Page->nombres->cellAttributes() ?>>
<span id="el_users_nombres">
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
    <tr id="r_apellidos">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_apellidos"><?= $Page->apellidos->caption() ?></span></td>
        <td data-name="apellidos" <?= $Page->apellidos->cellAttributes() ?>>
<span id="el_users_apellidos">
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->escenario->Visible) { // escenario ?>
    <tr id="r_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_escenario"><?= $Page->escenario->caption() ?></span></td>
        <td data-name="escenario" <?= $Page->escenario->cellAttributes() ?>>
<span id="el_users_escenario">
<span<?= $Page->escenario->viewAttributes() ?>>
<?= $Page->escenario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
    <tr id="r_grupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_grupo"><?= $Page->grupo->caption() ?></span></td>
        <td data-name="grupo" <?= $Page->grupo->cellAttributes() ?>>
<span id="el_users_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
    <tr id="r_subgrupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_subgrupo"><?= $Page->subgrupo->caption() ?></span></td>
        <td data-name="subgrupo" <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el_users_subgrupo">
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
    <tr id="r_perfil">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_perfil"><?= $Page->perfil->caption() ?></span></td>
        <td data-name="perfil" <?= $Page->perfil->cellAttributes() ?>>
<span id="el_users_perfil">
<span<?= $Page->perfil->viewAttributes() ?>>
<?= $Page->perfil->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
    <tr id="r_telefono">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_telefono"><?= $Page->telefono->caption() ?></span></td>
        <td data-name="telefono" <?= $Page->telefono->cellAttributes() ?>>
<span id="el_users_telefono">
<span<?= $Page->telefono->viewAttributes() ?>>
<?= $Page->telefono->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
    <tr id="r_pais">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_pais"><?= $Page->pais->caption() ?></span></td>
        <td data-name="pais" <?= $Page->pais->cellAttributes() ?>>
<span id="el_users_pais">
<span<?= $Page->pais->viewAttributes() ?>>
<?= $Page->pais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pw->Visible) { // pw ?>
    <tr id="r_pw">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_pw"><?= $Page->pw->caption() ?></span></td>
        <td data-name="pw" <?= $Page->pw->cellAttributes() ?>>
<span id="el_users_pw">
<span<?= $Page->pw->viewAttributes() ?>>
<?= $Page->pw->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_estado"><?= $Page->estado->caption() ?></span></td>
        <td data-name="estado" <?= $Page->estado->cellAttributes() ?>>
<span id="el_users_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->organizacion->Visible) { // organizacion ?>
    <tr id="r_organizacion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_organizacion"><?= $Page->organizacion->caption() ?></span></td>
        <td data-name="organizacion" <?= $Page->organizacion->cellAttributes() ?>>
<span id="el_users_organizacion">
<span<?= $Page->organizacion->viewAttributes() ?>>
<?= $Page->organizacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
    <tr id="r_img_user">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_img_user"><?= $Page->img_user->caption() ?></span></td>
        <td data-name="img_user" <?= $Page->img_user->cellAttributes() ?>>
<span id="el_users_img_user">
<span>
<?= GetFileViewTag($Page->img_user, $Page->img_user->getViewValue(), false) ?>
</span>
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
