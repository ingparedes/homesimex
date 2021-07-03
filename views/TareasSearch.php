<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TareasSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftareassearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    ftareassearch = currentAdvancedSearchForm = new ew.Form("ftareassearch", "search");
    <?php } else { ?>
    ftareassearch = currentForm = new ew.Form("ftareassearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tareas")) ?>,
        fields = currentTable.fields;
    ftareassearch.addFields([
        ["id_tarea", [ew.Validators.integer], fields.id_tarea.isInvalid],
        ["id_escenario", [ew.Validators.integer], fields.id_escenario.isInvalid],
        ["id_grupo", [], fields.id_grupo.isInvalid],
        ["titulo_tarea", [], fields.titulo_tarea.isInvalid],
        ["descripcion_tarea", [], fields.descripcion_tarea.isInvalid],
        ["fechainireal_tarea", [ew.Validators.datetime(109)], fields.fechainireal_tarea.isInvalid],
        ["fechafin_tarea", [ew.Validators.datetime(109)], fields.fechafin_tarea.isInvalid],
        ["fechainisimulado_tarea", [ew.Validators.datetime(109)], fields.fechainisimulado_tarea.isInvalid],
        ["fechafinsimulado_tarea", [ew.Validators.datetime(109)], fields.fechafinsimulado_tarea.isInvalid],
        ["id_tarearelacion", [], fields.id_tarearelacion.isInvalid],
        ["archivo", [], fields.archivo.isInvalid],
        ["id_subgrupo", [ew.Validators.integer], fields.id_subgrupo.isInvalid],
        ["valoracion", [ew.Validators.integer], fields.valoracion.isInvalid],
        ["color", [], fields.color.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        ftareassearch.setInvalid();
    });

    // Validate form
    ftareassearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    ftareassearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftareassearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ftareassearch.lists.id_grupo = <?= $Page->id_grupo->toClientList($Page) ?>;
    ftareassearch.lists.id_tarearelacion = <?= $Page->id_tarearelacion->toClientList($Page) ?>;
    loadjs.done("ftareassearch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftareassearch" id="ftareassearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tareas">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
    <div id="r_id_tarea" class="form-group row">
        <label for="x_id_tarea" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_id_tarea"><?= $Page->id_tarea->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id_tarea" id="z_id_tarea" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tarea->cellAttributes() ?>>
            <span id="el_tareas_id_tarea" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_id_tarea" name="x_id_tarea" id="x_id_tarea" placeholder="<?= HtmlEncode($Page->id_tarea->getPlaceHolder()) ?>" value="<?= $Page->id_tarea->EditValue ?>"<?= $Page->id_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_tarea->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <div id="r_id_escenario" class="form-group row">
        <label for="x_id_escenario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_id_escenario"><?= $Page->id_escenario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id_escenario" id="z_id_escenario" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_escenario->cellAttributes() ?>>
            <span id="el_tareas_id_escenario" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id_escenario->getInputTextType() ?>" data-table="tareas" data-field="x_id_escenario" name="x_id_escenario" id="x_id_escenario" size="30" placeholder="<?= HtmlEncode($Page->id_escenario->getPlaceHolder()) ?>" value="<?= $Page->id_escenario->EditValue ?>"<?= $Page->id_escenario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_escenario->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <div id="r_id_grupo" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_id_grupo"><?= $Page->id_grupo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_id_grupo" id="z_id_grupo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_grupo->cellAttributes() ?>>
            <span id="el_tareas_id_grupo" class="ew-search-field ew-search-field-single">
<template id="tp_x_id_grupo">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="tareas" data-field="x_id_grupo" name="x_id_grupo" id="x_id_grupo"<?= $Page->id_grupo->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_id_grupo" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_id_grupo"
    name="x_id_grupo"
    value="<?= HtmlEncode($Page->id_grupo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_id_grupo"
    data-target="dsl_x_id_grupo"
    data-repeatcolumn="1"
    class="form-control<?= $Page->id_grupo->isInvalidClass() ?>"
    data-table="tareas"
    data-field="x_id_grupo"
    data-value-separator="<?= $Page->id_grupo->displayValueSeparatorAttribute() ?>"
    <?= $Page->id_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_grupo->getErrorMessage(false) ?></div>
<?= $Page->id_grupo->Lookup->getParamTag($Page, "p_x_id_grupo") ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
    <div id="r_titulo_tarea" class="form-group row">
        <label for="x_titulo_tarea" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_titulo_tarea"><?= $Page->titulo_tarea->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_titulo_tarea" id="z_titulo_tarea" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->titulo_tarea->cellAttributes() ?>>
            <span id="el_tareas_titulo_tarea" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_titulo_tarea" name="x_titulo_tarea" id="x_titulo_tarea" size="100" maxlength="100" placeholder="<?= HtmlEncode($Page->titulo_tarea->getPlaceHolder()) ?>" value="<?= $Page->titulo_tarea->EditValue ?>"<?= $Page->titulo_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo_tarea->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_tarea->Visible) { // descripcion_tarea ?>
    <div id="r_descripcion_tarea" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_descripcion_tarea"><?= $Page->descripcion_tarea->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_descripcion_tarea" id="z_descripcion_tarea" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_tarea->cellAttributes() ?>>
            <span id="el_tareas_descripcion_tarea" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->descripcion_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_descripcion_tarea" name="x_descripcion_tarea" id="x_descripcion_tarea" size="50" maxlength="30" placeholder="<?= HtmlEncode($Page->descripcion_tarea->getPlaceHolder()) ?>" value="<?= $Page->descripcion_tarea->EditValue ?>"<?= $Page->descripcion_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descripcion_tarea->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
    <div id="r_fechainireal_tarea" class="form-group row">
        <label for="x_fechainireal_tarea" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_fechainireal_tarea"><?= $Page->fechainireal_tarea->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_fechainireal_tarea" id="z_fechainireal_tarea" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechainireal_tarea->cellAttributes() ?>>
            <span id="el_tareas_fechainireal_tarea" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->fechainireal_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainireal_tarea" data-format="109" name="x_fechainireal_tarea" id="x_fechainireal_tarea" placeholder="<?= HtmlEncode($Page->fechainireal_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechainireal_tarea->EditValue ?>"<?= $Page->fechainireal_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fechainireal_tarea->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
    <div id="r_fechafin_tarea" class="form-group row">
        <label for="x_fechafin_tarea" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_fechafin_tarea"><?= $Page->fechafin_tarea->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_fechafin_tarea" id="z_fechafin_tarea" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafin_tarea->cellAttributes() ?>>
            <span id="el_tareas_fechafin_tarea" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->fechafin_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafin_tarea" data-format="109" name="x_fechafin_tarea" id="x_fechafin_tarea" placeholder="<?= HtmlEncode($Page->fechafin_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechafin_tarea->EditValue ?>"<?= $Page->fechafin_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fechafin_tarea->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
    <div id="r_fechainisimulado_tarea" class="form-group row">
        <label for="x_fechainisimulado_tarea" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_fechainisimulado_tarea"><?= $Page->fechainisimulado_tarea->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_fechainisimulado_tarea" id="z_fechainisimulado_tarea" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechainisimulado_tarea->cellAttributes() ?>>
            <span id="el_tareas_fechainisimulado_tarea" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->fechainisimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainisimulado_tarea" data-format="109" name="x_fechainisimulado_tarea" id="x_fechainisimulado_tarea" placeholder="<?= HtmlEncode($Page->fechainisimulado_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechainisimulado_tarea->EditValue ?>"<?= $Page->fechainisimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fechainisimulado_tarea->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
    <div id="r_fechafinsimulado_tarea" class="form-group row">
        <label for="x_fechafinsimulado_tarea" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_fechafinsimulado_tarea"><?= $Page->fechafinsimulado_tarea->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_fechafinsimulado_tarea" id="z_fechafinsimulado_tarea" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafinsimulado_tarea->cellAttributes() ?>>
            <span id="el_tareas_fechafinsimulado_tarea" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->fechafinsimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-format="109" name="x_fechafinsimulado_tarea" id="x_fechafinsimulado_tarea" placeholder="<?= HtmlEncode($Page->fechafinsimulado_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechafinsimulado_tarea->EditValue ?>"<?= $Page->fechafinsimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fechafinsimulado_tarea->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->id_tarearelacion->Visible) { // id_tarearelacion ?>
    <div id="r_id_tarearelacion" class="form-group row">
        <label for="x_id_tarearelacion" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_id_tarearelacion"><?= $Page->id_tarearelacion->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id_tarearelacion" id="z_id_tarearelacion" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tarearelacion->cellAttributes() ?>>
            <span id="el_tareas_id_tarearelacion" class="ew-search-field ew-search-field-single">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_id_tarearelacion"><?= EmptyValue(strval($Page->id_tarearelacion->AdvancedSearch->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->id_tarearelacion->AdvancedSearch->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->id_tarearelacion->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->id_tarearelacion->ReadOnly || $Page->id_tarearelacion->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_id_tarearelacion',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->id_tarearelacion->getErrorMessage(false) ?></div>
<?= $Page->id_tarearelacion->Lookup->getParamTag($Page, "p_x_id_tarearelacion") ?>
<input type="hidden" is="selection-list" data-table="tareas" data-field="x_id_tarearelacion" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->id_tarearelacion->displayValueSeparatorAttribute() ?>" name="x_id_tarearelacion" id="x_id_tarearelacion" value="<?= $Page->id_tarearelacion->AdvancedSearch->SearchValue ?>"<?= $Page->id_tarearelacion->editAttributes() ?>>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <div id="r_archivo" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_archivo"><?= $Page->archivo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_archivo" id="z_archivo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->archivo->cellAttributes() ?>>
            <span id="el_tareas_archivo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->archivo->getInputTextType() ?>" data-table="tareas" data-field="x_archivo" name="x_archivo" id="x_archivo" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->archivo->getPlaceHolder()) ?>" value="<?= $Page->archivo->EditValue ?>"<?= $Page->archivo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->archivo->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
    <div id="r_id_subgrupo" class="form-group row">
        <label for="x_id_subgrupo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_id_subgrupo"><?= $Page->id_subgrupo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id_subgrupo" id="z_id_subgrupo" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_subgrupo->cellAttributes() ?>>
            <span id="el_tareas_id_subgrupo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id_subgrupo->getInputTextType() ?>" data-table="tareas" data-field="x_id_subgrupo" name="x_id_subgrupo" id="x_id_subgrupo" size="30" placeholder="<?= HtmlEncode($Page->id_subgrupo->getPlaceHolder()) ?>" value="<?= $Page->id_subgrupo->EditValue ?>"<?= $Page->id_subgrupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_subgrupo->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->valoracion->Visible) { // valoracion ?>
    <div id="r_valoracion" class="form-group row">
        <label for="x_valoracion" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_valoracion"><?= $Page->valoracion->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_valoracion" id="z_valoracion" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->valoracion->cellAttributes() ?>>
            <span id="el_tareas_valoracion" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->valoracion->getInputTextType() ?>" data-table="tareas" data-field="x_valoracion" name="x_valoracion" id="x_valoracion" size="30" placeholder="<?= HtmlEncode($Page->valoracion->getPlaceHolder()) ?>" value="<?= $Page->valoracion->EditValue ?>"<?= $Page->valoracion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->valoracion->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <div id="r_color" class="form-group row">
        <label for="x_color" class="<?= $Page->LeftColumnClass ?>"><span id="elh_tareas_color"><?= $Page->color->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_color" id="z_color" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->color->cellAttributes() ?>>
            <span id="el_tareas_color" class="ew-search-field ew-search-field-single">
    <select
        id="x_color"
        name="x_color"
        class="form-control ew-select<?= $Page->color->isInvalidClass() ?>"
        data-select2-id="tareas_x_color"
        data-table="tareas"
        data-field="x_color"
        data-value-separator="<?= $Page->color->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->color->getPlaceHolder()) ?>"
        <?= $Page->color->editAttributes() ?>>
        <?= $Page->color->selectOptionListHtml("x_color") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->color->getErrorMessage(false) ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='tareas_x_color']"),
        options = { name: "x_color", selectId: "tareas_x_color", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.tareas.fields.color.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="location.reload();"><?= $Language->phrase("Reset") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("tareas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
