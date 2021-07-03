<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fgruposearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fgruposearch = currentAdvancedSearchForm = new ew.Form("fgruposearch", "search");
    <?php } else { ?>
    fgruposearch = currentForm = new ew.Form("fgruposearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "grupo")) ?>,
        fields = currentTable.fields;
    fgruposearch.addFields([
        ["id_escenario", [], fields.id_escenario.isInvalid],
        ["id_grupo", [ew.Validators.integer], fields.id_grupo.isInvalid],
        ["imgen_grupo", [], fields.imgen_grupo.isInvalid],
        ["nombre_grupo", [], fields.nombre_grupo.isInvalid],
        ["descripcion_grupo", [], fields.descripcion_grupo.isInvalid],
        ["color", [], fields.color.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fgruposearch.setInvalid();
    });

    // Validate form
    fgruposearch.validate = function () {
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
    fgruposearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fgruposearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fgruposearch.lists.id_escenario = <?= $Page->id_escenario->toClientList($Page) ?>;
    loadjs.done("fgruposearch");
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
<form name="fgruposearch" id="fgruposearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="grupo">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <div id="r_id_escenario" class="form-group row">
        <label for="x_id_escenario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_grupo_id_escenario"><?= $Page->id_escenario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id_escenario" id="z_id_escenario" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_escenario->cellAttributes() ?>>
            <span id="el_grupo_id_escenario" class="ew-search-field">
    <select
        id="x_id_escenario"
        name="x_id_escenario"
        class="form-control ew-select<?= $Page->id_escenario->isInvalidClass() ?>"
        data-select2-id="grupo_x_id_escenario"
        data-table="grupo"
        data-field="x_id_escenario"
        data-value-separator="<?= $Page->id_escenario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_escenario->getPlaceHolder()) ?>"
        <?= $Page->id_escenario->editAttributes() ?>>
        <?= $Page->id_escenario->selectOptionListHtml("x_id_escenario") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->id_escenario->getErrorMessage(false) ?></div>
<?= $Page->id_escenario->Lookup->getParamTag($Page, "p_x_id_escenario") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='grupo_x_id_escenario']"),
        options = { name: "x_id_escenario", selectId: "grupo_x_id_escenario", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.grupo.fields.id_escenario.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <div id="r_id_grupo" class="form-group row">
        <label for="x_id_grupo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_grupo_id_grupo"><?= $Page->id_grupo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id_grupo" id="z_id_grupo" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_grupo->cellAttributes() ?>>
            <span id="el_grupo_id_grupo" class="ew-search-field">
<input type="<?= $Page->id_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_id_grupo" name="x_id_grupo" id="x_id_grupo" placeholder="<?= HtmlEncode($Page->id_grupo->getPlaceHolder()) ?>" value="<?= $Page->id_grupo->EditValue ?>"<?= $Page->id_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_grupo->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
    <div id="r_imgen_grupo" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_grupo_imgen_grupo"><?= $Page->imgen_grupo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_imgen_grupo" id="z_imgen_grupo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->imgen_grupo->cellAttributes() ?>>
            <span id="el_grupo_imgen_grupo" class="ew-search-field">
<input type="<?= $Page->imgen_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x_imgen_grupo" id="x_imgen_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->imgen_grupo->getPlaceHolder()) ?>" value="<?= $Page->imgen_grupo->EditValue ?>"<?= $Page->imgen_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->imgen_grupo->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
    <div id="r_nombre_grupo" class="form-group row">
        <label for="x_nombre_grupo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_grupo_nombre_grupo"><?= $Page->nombre_grupo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_nombre_grupo" id="z_nombre_grupo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombre_grupo->cellAttributes() ?>>
            <span id="el_grupo_nombre_grupo" class="ew-search-field">
<input type="<?= $Page->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x_nombre_grupo" id="x_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_grupo->EditValue ?>"<?= $Page->nombre_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre_grupo->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_grupo->Visible) { // descripcion_grupo ?>
    <div id="r_descripcion_grupo" class="form-group row">
        <label for="x_descripcion_grupo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_grupo_descripcion_grupo"><?= $Page->descripcion_grupo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_descripcion_grupo" id="z_descripcion_grupo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_grupo->cellAttributes() ?>>
            <span id="el_grupo_descripcion_grupo" class="ew-search-field">
<input type="<?= $Page->descripcion_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_descripcion_grupo" name="x_descripcion_grupo" id="x_descripcion_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->descripcion_grupo->getPlaceHolder()) ?>" value="<?= $Page->descripcion_grupo->EditValue ?>"<?= $Page->descripcion_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descripcion_grupo->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <div id="r_color" class="form-group row">
        <label for="x_color" class="<?= $Page->LeftColumnClass ?>"><span id="elh_grupo_color"><?= $Page->color->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_color" id="z_color" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->color->cellAttributes() ?>>
            <span id="el_grupo_color" class="ew-search-field">
<input type="<?= $Page->color->getInputTextType() ?>" data-table="grupo" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->color->getPlaceHolder()) ?>" value="<?= $Page->color->EditValue ?>"<?= $Page->color->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->color->getErrorMessage(false) ?></div>
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
    ew.addEventHandlers("grupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
