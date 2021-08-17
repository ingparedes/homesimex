<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmensajesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fmensajesedit = currentForm = new ew.Form("fmensajesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "mensajes")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.mensajes)
        ew.vars.tables.mensajes = currentTable;
    fmensajesedit.addFields([
        ["id_inyect", [fields.id_inyect.visible && fields.id_inyect.required ? ew.Validators.required(fields.id_inyect.caption) : null], fields.id_inyect.isInvalid],
        ["id_tarea", [fields.id_tarea.visible && fields.id_tarea.required ? ew.Validators.required(fields.id_tarea.caption) : null], fields.id_tarea.isInvalid],
        ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
        ["mensaje", [fields.mensaje.visible && fields.mensaje.required ? ew.Validators.required(fields.mensaje.caption) : null], fields.mensaje.isInvalid],
        ["fechareal_start", [fields.fechareal_start.visible && fields.fechareal_start.required ? ew.Validators.required(fields.fechareal_start.caption) : null, ew.Validators.datetime(109)], fields.fechareal_start.isInvalid],
        ["fechasim_start", [fields.fechasim_start.visible && fields.fechasim_start.required ? ew.Validators.required(fields.fechasim_start.caption) : null, ew.Validators.datetime(109)], fields.fechasim_start.isInvalid],
        ["medios", [fields.medios.visible && fields.medios.required ? ew.Validators.required(fields.medios.caption) : null], fields.medios.isInvalid],
        ["actividad_esperada", [fields.actividad_esperada.visible && fields.actividad_esperada.required ? ew.Validators.required(fields.actividad_esperada.caption) : null], fields.actividad_esperada.isInvalid],
        ["id_actor", [fields.id_actor.visible && fields.id_actor.required ? ew.Validators.required(fields.id_actor.caption) : null], fields.id_actor.isInvalid],
        ["para", [fields.para.visible && fields.para.required ? ew.Validators.required(fields.para.caption) : null], fields.para.isInvalid],
        ["adjunto", [fields.adjunto.visible && fields.adjunto.required ? ew.Validators.fileRequired(fields.adjunto.caption) : null], fields.adjunto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmensajesedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fmensajesedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fmensajesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmensajesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmensajesedit.lists.id_tarea = <?= $Page->id_tarea->toClientList($Page) ?>;
    fmensajesedit.lists.medios = <?= $Page->medios->toClientList($Page) ?>;
    fmensajesedit.lists.id_actor = <?= $Page->id_actor->toClientList($Page) ?>;
    fmensajesedit.lists.para = <?= $Page->para->toClientList($Page) ?>;
    loadjs.done("fmensajesedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    $(document).on("create.editor",(function(e,n){n.settings.height="300px",n.settings.allowedContent=!0,n.settings.extraAllowedContent="iframe[*]",n.settings.toolbarGroups=[{name:"document",groups:["mode"]},{name:"clipboard",groups:["clipboard","undo"]},{name:"basicstyles",groups:["basicstyles","cleanup"]},{name:"paragraph",groups:["list","indent","blocks","align"]},{name:"links"},{name:"tools"},{name:"others"},{name:"oembed"},{name:"insert",groups:["insert"]}]}));
});
</script>
<?php $Page->showPageHeader(); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="../js/flatpickr.js" charset="uft-8"></script>
<script src="../js/flatpickr-locale-es.js" charset="uft-8"></script>
<?php
$Page->showMessage();
?>
<form name="fmensajesedit" id="fmensajesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensajes">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "tareas") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="tareas">
<input type="hidden" name="fk_id_tarea" value="<?= HtmlEncode($Page->id_tarea->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
    <div id="r_id_inyect" class="form-group">
        <label id="elh_mensajes_id_inyect" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_inyect->caption() ?><?= $Page->id_inyect->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_inyect->cellAttributes() ?>>
<span id="el_mensajes_id_inyect">
<span<?= $Page->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_inyect->getDisplayValue($Page->id_inyect->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="x_id_inyect" id="x_id_inyect" value="<?= HtmlEncode($Page->id_inyect->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
    <div id="r_id_tarea" class="form-group">
        <label id="elh_mensajes_id_tarea" for="x_id_tarea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_tarea->caption() ?><?= $Page->id_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tarea->cellAttributes() ?>>
<?php if ($Page->id_tarea->getSessionValue() != "") { ?>
<span id="el_mensajes_id_tarea">
<span<?= $Page->id_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_tarea->getDisplayValue($Page->id_tarea->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_id_tarea" name="x_id_tarea" value="<?= HtmlEncode($Page->id_tarea->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_mensajes_id_tarea">
    <select
        id="x_id_tarea"
        name="x_id_tarea"
        class="form-control ew-select<?= $Page->id_tarea->isInvalidClass() ?>"
        data-select2-id="mensajes_x_id_tarea"
        data-table="mensajes"
        data-field="x_id_tarea"
        data-value-separator="<?= $Page->id_tarea->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_tarea->getPlaceHolder()) ?>"
        <?= $Page->id_tarea->editAttributes() ?>>
        <?= $Page->id_tarea->selectOptionListHtml("x_id_tarea") ?>
    </select>
    <?= $Page->id_tarea->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->id_tarea->getErrorMessage() ?></div>
<?= $Page->id_tarea->Lookup->getParamTag($Page, "p_x_id_tarea") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x_id_tarea']"),
        options = { name: "x_id_tarea", selectId: "mensajes_x_id_tarea", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.id_tarea.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo" class="form-group">
        <label id="elh_mensajes_titulo" for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo->caption() ?><?= $Page->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->titulo->cellAttributes() ?>>
<span id="el_mensajes_titulo">
<input type="<?= $Page->titulo->getInputTextType() ?>" data-table="mensajes" data-field="x_titulo" name="x_titulo" id="x_titulo" size="100" maxlength="100" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" value="<?= $Page->titulo->EditValue ?>"<?= $Page->titulo->editAttributes() ?> aria-describedby="x_titulo_help">
<?= $Page->titulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <div id="r_mensaje" class="form-group">
        <label id="elh_mensajes_mensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mensaje->caption() ?><?= $Page->mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mensaje->cellAttributes() ?>>
<span id="el_mensajes_mensaje">
<?php $Page->mensaje->EditAttrs->appendClass("editor"); ?>
<textarea data-table="mensajes" data-field="x_mensaje" name="x_mensaje" id="x_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->mensaje->getPlaceHolder()) ?>"<?= $Page->mensaje->editAttributes() ?> aria-describedby="x_mensaje_help"><?= $Page->mensaje->EditValue ?></textarea>
<?= $Page->mensaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mensaje->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmensajesedit", "editor"], function() {
	ew.createEditor("fmensajesedit", "x_mensaje", 35, 4, <?= $Page->mensaje->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
    <div id="r_fechareal_start" class="form-group">
        <label id="elh_mensajes_fechareal_start" for="x_fechareal_start" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechareal_start->caption() ?><?= $Page->fechareal_start->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechareal_start->cellAttributes() ?>>
<span id="el_mensajes_fechareal_start">
<input type="<?= $Page->fechareal_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechareal_start" data-format="109" name="x_fechareal_start" id="x_fechareal_start" placeholder="<?= HtmlEncode($Page->fechareal_start->getPlaceHolder()) ?>" value="<?= $Page->fechareal_start->EditValue ?>"<?= $Page->fechareal_start->editAttributes() ?> aria-describedby="x_fechareal_start_help">
<?= $Page->fechareal_start->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechareal_start->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
    <div id="r_fechasim_start" class="form-group">
        <label id="elh_mensajes_fechasim_start" for="x_fechasim_start" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechasim_start->caption() ?><?= $Page->fechasim_start->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechasim_start->cellAttributes() ?>>
<span id="el_mensajes_fechasim_start">
<input type="<?= $Page->fechasim_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechasim_start" data-format="109" name="x_fechasim_start" id="x_fechasim_start" placeholder="<?= HtmlEncode($Page->fechasim_start->getPlaceHolder()) ?>" value="<?= $Page->fechasim_start->EditValue ?>"<?= $Page->fechasim_start->editAttributes() ?> aria-describedby="x_fechasim_start_help">
<?= $Page->fechasim_start->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechasim_start->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->medios->Visible) { // medios ?>
    <div id="r_medios" class="form-group">
        <label id="elh_mensajes_medios" for="x_medios" class="<?= $Page->LeftColumnClass ?>"><?= $Page->medios->caption() ?><?= $Page->medios->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->medios->cellAttributes() ?>>
<span id="el_mensajes_medios">
    <select
        id="x_medios"
        name="x_medios"
        class="form-control ew-select<?= $Page->medios->isInvalidClass() ?>"
        data-select2-id="mensajes_x_medios"
        data-table="mensajes"
        data-field="x_medios"
        data-value-separator="<?= $Page->medios->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->medios->getPlaceHolder()) ?>"
        <?= $Page->medios->editAttributes() ?>>
        <?= $Page->medios->selectOptionListHtml("x_medios") ?>
    </select>
    <?= $Page->medios->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->medios->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x_medios']"),
        options = { name: "x_medios", selectId: "mensajes_x_medios", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.mensajes.fields.medios.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.medios.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->actividad_esperada->Visible) { // actividad_esperada ?>
    <div id="r_actividad_esperada" class="form-group">
        <label id="elh_mensajes_actividad_esperada" for="x_actividad_esperada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->actividad_esperada->caption() ?><?= $Page->actividad_esperada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->actividad_esperada->cellAttributes() ?>>
<span id="el_mensajes_actividad_esperada">
<textarea data-table="mensajes" data-field="x_actividad_esperada" name="x_actividad_esperada" id="x_actividad_esperada" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->actividad_esperada->getPlaceHolder()) ?>"<?= $Page->actividad_esperada->editAttributes() ?> aria-describedby="x_actividad_esperada_help"><?= $Page->actividad_esperada->EditValue ?></textarea>
<?= $Page->actividad_esperada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->actividad_esperada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
    <div id="r_id_actor" class="form-group">
        <label id="elh_mensajes_id_actor" for="x_id_actor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_actor->caption() ?><?= $Page->id_actor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_actor->cellAttributes() ?>>
<span id="el_mensajes_id_actor">
<div class="input-group flex-nowrap">
    <select
        id="x_id_actor"
        name="x_id_actor"
        class="form-control ew-select<?= $Page->id_actor->isInvalidClass() ?>"
        data-select2-id="mensajes_x_id_actor"
        data-table="mensajes"
        data-field="x_id_actor"
        data-value-separator="<?= $Page->id_actor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_actor->getPlaceHolder()) ?>"
        <?= $Page->id_actor->editAttributes() ?>>
        <?= $Page->id_actor->selectOptionListHtml("x_id_actor") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "actor_simulado") && !$Page->id_actor->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_id_actor" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->id_actor->caption() ?>" data-title="<?= $Page->id_actor->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_id_actor',url:'<?= GetUrl("ActorSimuladoAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<?= $Page->id_actor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_actor->getErrorMessage() ?></div>
<?= $Page->id_actor->Lookup->getParamTag($Page, "p_x_id_actor") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x_id_actor']"),
        options = { name: "x_id_actor", selectId: "mensajes_x_id_actor", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.id_actor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
    <div id="r_para" class="form-group">
        <label id="elh_mensajes_para" for="x_para" class="<?= $Page->LeftColumnClass ?>"><?= $Page->para->caption() ?><?= $Page->para->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->para->cellAttributes() ?>>
<span id="el_mensajes_para">
<div class="input-group ew-lookup-list" aria-describedby="x_para_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_para"><?= EmptyValue(strval($Page->para->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->para->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->para->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->para->ReadOnly || $Page->para->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_para[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->para->getErrorMessage() ?></div>
<?= $Page->para->getCustomMessage() ?>
<?= $Page->para->Lookup->getParamTag($Page, "p_x_para") ?>
<input type="hidden" is="selection-list" data-table="mensajes" data-field="x_para" data-type="text" data-multiple="1" data-lookup="1" data-value-separator="<?= $Page->para->displayValueSeparatorAttribute() ?>" name="x_para[]" id="x_para[]" value="<?= $Page->para->CurrentValue ?>"<?= $Page->para->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
    <div id="r_adjunto" class="form-group">
        <label id="elh_mensajes_adjunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->adjunto->caption() ?><?= $Page->adjunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->adjunto->cellAttributes() ?>>
<span id="el_mensajes_adjunto">
<div id="fd_x_adjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->adjunto->title() ?>" data-table="mensajes" data-field="x_adjunto" name="x_adjunto" id="x_adjunto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->adjunto->editAttributes() ?><?= ($Page->adjunto->ReadOnly || $Page->adjunto->Disabled) ? " disabled" : "" ?> aria-describedby="x_adjunto_help">
        <label class="custom-file-label ew-file-label" for="x_adjunto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->adjunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->adjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_adjunto" id= "fn_x_adjunto" value="<?= $Page->adjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x_adjunto" id= "fa_x_adjunto" value="<?= (Post("fa_x_adjunto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_adjunto" id= "fs_x_adjunto" value="200">
<input type="hidden" name="fx_x_adjunto" id= "fx_x_adjunto" value="<?= $Page->adjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_adjunto" id= "fm_x_adjunto" value="<?= $Page->adjunto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_adjunto" id= "fc_x_adjunto" value="<?= $Page->adjunto->UploadMaxFileCount ?>">
</div>
<table id="ft_x_adjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
			let fechaInicial = "<?php echo $fechaInicial ?>";
			let horaInicial = "<?php echo $horaInicial ?>";
			let minInicial = "<?php echo $minInicial ?>";
			let fechaFin = "<?php echo $fechaFin ?>";
			let horaFin = "<?php echo $horaFin ?>";
			let minFin = "<?php echo $minFin ?>";
			flatpickr("#x_fechareal_start",{
				locale: "es",
				enableTime: true,
				dateFormat: "Y-m-d H:i",
				time_24hr: true,
				minDate: fechaInicial + " " + horaInicial + ":" + minInicial,
				maxDate: fechaFin + " " + horaFin + ":" + minFin,
				defaultDate: fechaInicial + " " + horaInicial + ":" + minInicial,
			});
			let fechaIniSimulado = "<?php echo $fechaIniSimulado ?>";
			let horaIniSimulado = "<?php echo $horaIniSimulado ?>";
			let minIniSimulado = "<?php echo $minIniSimulado ?>";
			let fechaFinSimulado = "<?php echo $fechaFinSimulado ?>";
			let horaFinSimulado = "<?php echo $horaFinSimulado ?>";
			let minFinSimulado = "<?php echo $minFinSimulado ?>";
			flatpickr("#x_fechasim_start",{
				locale: "es",
				enableTime: true,
				dateFormat: "Y-m-d H:i",
				time_24hr: true,
				minDate: fechaIniSimulado + " " + horaIniSimulado + ":" + minIniSimulado,
				maxDate: fechaFinSimulado + " " + horaFinSimulado + ":" + minFinSimulado,
				defaultDate: fechaIniSimulado + " " + horaIniSimulado + ":" + minIniSimulado,
			});
	</script>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("mensajes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $('h1').html("<span class='text-muted'>Editar</span> Mensaje");
});
</script>
