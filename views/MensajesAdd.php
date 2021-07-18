<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesAdd = &$Page;
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
var currentForm, currentPageID;
var fmensajesadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fmensajesadd = currentForm = new ew.Form("fmensajesadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "mensajes")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.mensajes)
        ew.vars.tables.mensajes = currentTable;
    fmensajesadd.addFields([
        ["id_tarea", [fields.id_tarea.visible && fields.id_tarea.required ? ew.Validators.required(fields.id_tarea.caption) : null], fields.id_tarea.isInvalid],
        ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
        ["mensaje", [fields.mensaje.visible && fields.mensaje.required ? ew.Validators.required(fields.mensaje.caption) : null], fields.mensaje.isInvalid],
        ["fechareal_start", [fields.fechareal_start.visible && fields.fechareal_start.required ? ew.Validators.required(fields.fechareal_start.caption) : null, ew.Validators.datetime(109)], fields.fechareal_start.isInvalid],
        ["fechasim_start", [fields.fechasim_start.visible && fields.fechasim_start.required ? ew.Validators.required(fields.fechasim_start.caption) : null, ew.Validators.datetime(109)], fields.fechasim_start.isInvalid],
        ["medios", [fields.medios.visible && fields.medios.required ? ew.Validators.required(fields.medios.caption) : null], fields.medios.isInvalid],
        ["actividad_esperada", [fields.actividad_esperada.visible && fields.actividad_esperada.required ? ew.Validators.required(fields.actividad_esperada.caption) : null], fields.actividad_esperada.isInvalid],
        ["id_actor", [fields.id_actor.visible && fields.id_actor.required ? ew.Validators.required(fields.id_actor.caption) : null], fields.id_actor.isInvalid],
        ["para", [fields.para.visible && fields.para.required ? ew.Validators.required(fields.para.caption) : null], fields.para.isInvalid],
        ["adjunto", [fields.adjunto.visible && fields.adjunto.required ? ew.Validators.required(fields.adjunto.caption) : null], fields.adjunto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmensajesadd,
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
    fmensajesadd.validate = function () {
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
    fmensajesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmensajesadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmensajesadd.lists.id_tarea = <?= $Page->id_tarea->toClientList($Page) ?>;
    fmensajesadd.lists.medios = <?= $Page->medios->toClientList($Page) ?>;
    fmensajesadd.lists.id_actor = <?= $Page->id_actor->toClientList($Page) ?>;
    fmensajesadd.lists.para = <?= $Page->para->toClientList($Page) ?>;
    fmensajesadd.lists.adjunto = <?= $Page->adjunto->toClientList($Page) ?>;
    loadjs.done("fmensajesadd");
});
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
loadjs.ready("head", function () {
    // Client script
    $(document).on("create.editor",(function(e,n){n.settings.height="300px",n.settings.allowedContent=!0,n.settings.extraAllowedContent="iframe[*]",n.settings.toolbarGroups=[{name:"document",groups:["mode"]},{name:"clipboard",groups:["clipboard","undo"]},{name:"basicstyles",groups:["basicstyles","cleanup"]},{name:"paragraph",groups:["list","indent","blocks","align"]},{name:"links"},{name:"tools"},{name:"others"},{name:"oembed"},{name:"insert",groups:["insert"]}]}));
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmensajesadd" id="fmensajesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensajes">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "tareas") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="tareas">
<input type="hidden" name="fk_id_tarea" value="<?= HtmlEncode($Page->id_tarea->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
    <div id="r_id_tarea" class="form-group row">
        <label id="elh_mensajes_id_tarea" for="x_id_tarea" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_id_tarea"><?= $Page->id_tarea->caption() ?><?= $Page->id_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tarea->cellAttributes() ?>>
<?php if ($Page->id_tarea->getSessionValue() != "") { ?>
<template id="tpx_mensajes_id_tarea"><span id="el_mensajes_id_tarea">
<span<?= $Page->id_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_tarea->getDisplayValue($Page->id_tarea->ViewValue))) ?>"></span>
</span></template>
<input type="hidden" id="x_id_tarea" name="x_id_tarea" value="<?= HtmlEncode($Page->id_tarea->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<template id="tpx_mensajes_id_tarea"><span id="el_mensajes_id_tarea">
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
</span></template>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo" class="form-group row">
        <label id="elh_mensajes_titulo" for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_titulo"><?= $Page->titulo->caption() ?><?= $Page->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->titulo->cellAttributes() ?>>
<template id="tpx_mensajes_titulo"><span id="el_mensajes_titulo">
<input type="<?= $Page->titulo->getInputTextType() ?>" data-table="mensajes" data-field="x_titulo" name="x_titulo" id="x_titulo" size="100" maxlength="100" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" value="<?= $Page->titulo->EditValue ?>"<?= $Page->titulo->editAttributes() ?> aria-describedby="x_titulo_help">
<?= $Page->titulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <div id="r_mensaje" class="form-group row">
        <label id="elh_mensajes_mensaje" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_mensaje"><?= $Page->mensaje->caption() ?><?= $Page->mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mensaje->cellAttributes() ?>>
<template id="tpx_mensajes_mensaje"><span id="el_mensajes_mensaje">
<?php $Page->mensaje->EditAttrs->appendClass("editor"); ?>
<textarea data-table="mensajes" data-field="x_mensaje" name="x_mensaje" id="x_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->mensaje->getPlaceHolder()) ?>"<?= $Page->mensaje->editAttributes() ?> aria-describedby="x_mensaje_help"><?= $Page->mensaje->EditValue ?></textarea>
<?= $Page->mensaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mensaje->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmensajesadd", "editor"], function() {
	ew.createEditor("fmensajesadd", "x_mensaje", 35, 4, <?= $Page->mensaje->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
    <div id="r_fechareal_start" class="form-group row">
        <label id="elh_mensajes_fechareal_start" for="x_fechareal_start" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_fechareal_start"><?= $Page->fechareal_start->caption() ?><?= $Page->fechareal_start->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechareal_start->cellAttributes() ?>>
<template id="tpx_mensajes_fechareal_start"><span id="el_mensajes_fechareal_start">
<input type="<?= $Page->fechareal_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechareal_start" data-format="109" name="x_fechareal_start" id="x_fechareal_start" placeholder="<?= HtmlEncode($Page->fechareal_start->getPlaceHolder()) ?>" value="<?= $Page->fechareal_start->EditValue ?>"<?= $Page->fechareal_start->editAttributes() ?> aria-describedby="x_fechareal_start_help">
<?= $Page->fechareal_start->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechareal_start->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
    <div id="r_fechasim_start" class="form-group row">
        <label id="elh_mensajes_fechasim_start" for="x_fechasim_start" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_fechasim_start"><?= $Page->fechasim_start->caption() ?><?= $Page->fechasim_start->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechasim_start->cellAttributes() ?>>
<template id="tpx_mensajes_fechasim_start"><span id="el_mensajes_fechasim_start">
<input type="<?= $Page->fechasim_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechasim_start" data-format="109" name="x_fechasim_start" id="x_fechasim_start" placeholder="<?= HtmlEncode($Page->fechasim_start->getPlaceHolder()) ?>" value="<?= $Page->fechasim_start->EditValue ?>"<?= $Page->fechasim_start->editAttributes() ?> aria-describedby="x_fechasim_start_help">
<?= $Page->fechasim_start->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechasim_start->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->medios->Visible) { // medios ?>
    <div id="r_medios" class="form-group row">
        <label id="elh_mensajes_medios" for="x_medios" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_medios"><?= $Page->medios->caption() ?><?= $Page->medios->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->medios->cellAttributes() ?>>
<template id="tpx_mensajes_medios"><span id="el_mensajes_medios">
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
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->actividad_esperada->Visible) { // actividad_esperada ?>
    <div id="r_actividad_esperada" class="form-group row">
        <label id="elh_mensajes_actividad_esperada" for="x_actividad_esperada" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_actividad_esperada"><?= $Page->actividad_esperada->caption() ?><?= $Page->actividad_esperada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->actividad_esperada->cellAttributes() ?>>
<template id="tpx_mensajes_actividad_esperada"><span id="el_mensajes_actividad_esperada">
<textarea data-table="mensajes" data-field="x_actividad_esperada" name="x_actividad_esperada" id="x_actividad_esperada" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->actividad_esperada->getPlaceHolder()) ?>"<?= $Page->actividad_esperada->editAttributes() ?> aria-describedby="x_actividad_esperada_help"><?= $Page->actividad_esperada->EditValue ?></textarea>
<?= $Page->actividad_esperada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->actividad_esperada->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
    <div id="r_id_actor" class="form-group row">
        <label id="elh_mensajes_id_actor" for="x_id_actor" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_id_actor"><?= $Page->id_actor->caption() ?><?= $Page->id_actor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_actor->cellAttributes() ?>>
<template id="tpx_mensajes_id_actor"><span id="el_mensajes_id_actor">
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
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
    <div id="r_para" class="form-group row">
        <label id="elh_mensajes_para" for="x_para" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_para"><?= $Page->para->caption() ?><?= $Page->para->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->para->cellAttributes() ?>>
<template id="tpx_mensajes_para"><span id="el_mensajes_para">
    <select
        id="x_para[]"
        name="x_para[]"
        class="form-control ew-select<?= $Page->para->isInvalidClass() ?>"
        data-select2-id="mensajes_x_para[]"
        data-table="mensajes"
        data-field="x_para"
        multiple
        size="1"
        data-value-separator="<?= $Page->para->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->para->getPlaceHolder()) ?>"
        <?= $Page->para->editAttributes() ?>>
        <?= $Page->para->selectOptionListHtml("x_para[]") ?>
    </select>
    
    <?= $Page->para->getCustomMessage() ?>
    <!--MIGUEL MODAL PARA-->
    <button type="button" class="btn btn-default ew-add-opt-btn w-0 rounded-right " data-toggle="modal" data-target="#modalPara"><i class="fas fa-plus ew-icon"></i></button>
<div class="modal fade" id="modalPara" tabiendex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleMddalLabel">Seleccion de destinatarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <div class="modal-body" id="vue-admin">
            
            
                <div class="form-group m-3">
                    <label for="selectgrupo">Grupo</label>
                    <select class="form-control" id="selectgrupo">
                    <option value="">Seleccione un Grupo</option>    
                        <option v-for="grupo in grupos" v-bind:value="grupo.id">{{grupo.nombre}} </option>
                    </select>
                </div>
                <div class="form-group m-3" >
                    <label for="selectsubgrupo">Sub-Grupo</label>
                    <select class="form-control" id="selectsubgrupo">
                    <option value="">Seleccione un SubGrupo</option>
                    <option v-for="subgrupo in subgrupos" v-bind:value="subgrupo.id">{{subgrupo.nombre}} </option>
                    </select>
                </div>
                <div class="form-group m-3 mb-5">
                    <label for="selectparticipante">Participante</label>
                    <select class="js-example-basic-multiple" name="states[]" multiple="multiple" id="para[]">
                        <option value="">Seleccione un participante</option>
                        <option v-for="participante in participantes" v-bind:value="participante.id">{{participante.nombre}} </option>
                </select>
                    
                </div>
               
<script>$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});</script>
</div>
            <div class="modal-footer">
                <button type="button" onclick="guardarPara();" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
    function guardarPara() {
        //document.getElementById('x_para[]')=document.getElementById('para[]');
        var obj = document.getElementById('para[]');
        if (obj.selectedIndex==-1) return;
    for (var i=0; opt=obj.options[i]; i++)
        if (opt.selected) {
            var valor=opt.value; // almacenar value
            var txt=obj.options[i].text; // almacenar el texto
            obj.options[i]=null; // borrar el item si está seleccionado
            var obj2 = document.getElementById('x_para[]');
            var opc = new Option(txt,valor);    
            //alert(opc);
            eval(obj2.options[obj2.options.length]=opc);    
        } 
        
    }
    
    var app = new Vue({
        el: '#vue-admin',
        data: {
            grupos: [],
            subgrupos:[],
            participantes:[]
        }
    });
    function removerOpciones(id){
        let Selector=document.getElementById(id);
        var i,L=Selector.options.length-1;
        for(i=L;i>=0;i--){
            Selector.remove(i);
        }
    }
    llenarGrupos();
    function llenarGrupos(){
        $.ajax({
            url: "inject/filtroGSg.php?funcion=grupo&idUser="+<?php echo CurrentUserID();?>,
            success: function (es) {
                console.log(es);
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                        let add = {
                            "id":respuesta[i].id,
                            "nombre":respuesta[i].nombre
                        };
                        app.grupos.push(add);
                    
                }
                 
            },
            error: function (e) {
                console.log(e);
            }
        });
        
    }
    const selectElement = document.querySelector('#selectgrupo');

    selectElement.addEventListener('change', (event) => {
        llenarSubGrupos(event.target.value);
        llenarParticipanteG(event.target.value);
    });
    const selectElementS = document.querySelector('#selectsubgrupo');
    selectElementS.addEventListener('change', (event) => {
        llenarParticipanteSG(event.target.value);
    });
   

    function llenarSubGrupos(id){
        app.subgrupos=[];
        $.ajax({
            url: "inject/filtroGSg.php?funcion=Subgrupo&idUser=0&idGrupo="+id,
            success: function (es) {
                if(es=="Vacio")
                {
                    console.log("No existen subgrupos asociados");
                }
                else{
                    console.log(es);
                    let respuesta = JSON.parse(es);
                    for(let i = 0;i < respuesta.length;i++){
                            let add = {
                                "nombre":respuesta[i].nombre,
                                "id":respuesta[i].id
                            };
                            app.subgrupos.push(add);   
                    }
                }
                
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function llenarParticipanteG(id){
        app.participantes=[];
        $.ajax({
            url: "inject/filtroGSg.php?funcion=participanteG&idUser=0&id="+id,
            success: function (es) {
                if(es=="Vacio")
                {
                    console.log("No existen participantes asociados al grupo");
                }
                else{
                    console.log(es);
                    let respuesta = JSON.parse(es);
                    for(let i = 0;i < respuesta.length;i++){
                            let add = {
                                "nombre":respuesta[i].nombre,
                                "id":respuesta[i].id
                            };
                            app.participantes.push(add);   
                    }
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function llenarParticipanteSG(id){
        $.ajax({
            url: "inject/filtroGSg.php?funcion=participanteSG&id="+id,
            success: function (es) {
                if(es=="Vacio")
                {
                    console.log("No existen participantes asociados al Subgrupo");
                }
                else{
                    app.participantes=[];
                    let respuesta = JSON.parse(es);
                    for(let i = 0;i < respuesta.length;i++){
                            let add = {
                                "nombre":respuesta[i].nombre,
                                "id":respuesta[i].id
                            };
                            app.participantes.push(add);   
                    }
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
        
    </script>
    
    <div class="invalid-feedback"><?= $Page->para->getErrorMessage() ?></div>
<?= $Page->para->Lookup->getParamTag($Page, "p_x_para") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x_para[]']"),
        options = { name: "x_para[]", selectId: "mensajes_x_para[]", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.multiple = true;
    options.closeOnSelect = false;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.para.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>

</div></div>
       <button type="button" class="btn btn-default" data-toggle="modal" data-target="modalPara">+</button> 
    </div>
<?php } ?>

<?php if ($Page->adjunto->Visible) { // adjunto ?>
    <div id="r_adjunto" class="form-group row">
        <label id="elh_mensajes_adjunto" for="x_adjunto" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_mensajes_adjunto"><?= $Page->adjunto->caption() ?><?= $Page->adjunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->adjunto->cellAttributes() ?>>
<template id="tpx_mensajes_adjunto"><span id="el_mensajes_adjunto">
<div class="input-group flex-nowrap">
    <select
        id="x_adjunto[]"
        name="x_adjunto[]"
        class="form-control ew-select<?= $Page->adjunto->isInvalidClass() ?>"
        data-select2-id="mensajes_x_adjunto[]"
        data-table="mensajes"
        data-field="x_adjunto"
        multiple
        size="1"
        data-value-separator="<?= $Page->adjunto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->adjunto->getPlaceHolder()) ?>"
        <?= $Page->adjunto->editAttributes() ?>>
        <?= $Page->adjunto->selectOptionListHtml("x_adjunto[]") ?>
    </select>
    
    <?php if (AllowAdd(CurrentProjectID() . "archivos_doc") && !$Page->adjunto->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_adjunto" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->adjunto->caption() ?>" data-title="<?= $Page->adjunto->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_adjunto',url:'<?= GetUrl("ArchivosDocAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<?= $Page->adjunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->adjunto->getErrorMessage() ?></div>
<?= $Page->adjunto->Lookup->getParamTag($Page, "p_x_adjunto") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x_adjunto[]']"),
        options = { name: "x_adjunto[]", selectId: "mensajes_x_adjunto[]", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.multiple = true;
    options.closeOnSelect = false;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.adjunto.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_mensajesadd" class="ew-custom-template"></div>
<template id="tpm_mensajesadd">
<div id="ct_MensajesAdd"><?php
	$idTarea = Container("tareas")->id_tarea->CurrentValue;
//var_dump(Db());

//$dbconn = Db();
    //Log("Row Inserted");
    //Recibe Grupo-id
	$nombretarea = ExecuteRow("SELECT titulo_tarea,DATE_FORMAT(fechainireal_tarea, '%Y/%m/%d'), DATE_FORMAT(fechafin_tarea, '%Y/%m/%d') as fecha  FROM tareas  WHERE id_tarea = '".$idTarea."';");
?>
<div class="callout callout-primary">
  <h4>Tarea: <?php echo $nombretarea[0];  ?>  </h4>
 <p>Fecha inicio real: <?php echo $nombretarea[1]  ?> Fecha fin real: <?php echo $nombretarea[2];  ?> </p>
</div>
	<div id="r_titulo" class="form-group">
        <label for="x_titulo" class="col-sm-2 col-form-label"><?= $Page->titulo->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_titulo"></slot></div>
    </div>
 <div id="r_mensaje" class="form-group">
        <label for="x_mensaje" class="col-sm-2 col-form-label"><?= $Page->mensaje->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_mensaje"></slot></div> 
    </div>a
 <div class = "row">
    <div id="r_fechareal_start" class="form-group">
        <label for="x_fechareal_start" class="col-sm-2 col-form-label"><?= $Page->fechareal_start->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_fechareal_start"></slot></div>
    </div>
    <div id="r_fechasim_start" class="form-group">
        <label for="x_fechasim_start" class="col-sm-2 col-form-label"><?= $Page->fechasim_start->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_fechasim_start"></slot></div>
    </div>
 </div>
 <div class = "row">
 	    <div id="r_para" class="form-group">
        <label for="x_para" class="col-sm-2 col-form-label"><?= $Page->para->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_para"></slot></div>
    </div>
        <div id="r_id_actor" class="form-group">
        <label for="x_id_actor" class="col-sm-2 col-form-label"><?= $Page->id_actor->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_id_actor"></slot></div>
    </div>
   </div>
    <div id="r_actividad_esperada" class="form-group">
        <label for="x_actividad_esperada" class="col-sm-2 col-form-label"><?= $Page->actividad_esperada->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_actividad_esperada"></slot></div>
    </div>
   <div class = "row">
    <div id="r_medios" class="form-group">
        <label for="x_medios" class="col-sm-2 col-form-label"><?= $Page->medios->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_medios"></slot></div>
    </div>
    <div id="r_adjunto" class="form-group">
        <label for="x_adjunto" class="col-sm-2 col-form-label"><?= $Page->adjunto->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_mensajes_adjunto"></slot></div>
    </div>
</div>
   <?php
	$fecha = ExecuteRow("SELECT t.fechainireal_tarea, t.fechafin_tarea FROM tareas t WHERE t.id_tarea = '".$idTarea."';");
	$fechaSim = ExecuteRow("SELECT fechaini_simulado, fechafin_simulado FROM escenario e INNER JOIN tareas t ON e.id_escenario = t.id_escenario WHERE t.id_tarea = '".$idTarea."';" );
	$fechaInicial = date("Y-m-d", strtotime($fecha[0]));
	$horaInicial = date("H", strtotime($fecha[0]));
	$minInicial = date("i", strtotime($fecha[0]));
	$fechaFin = date("Y-m-d", strtotime($fecha[1]));
	$horaFin = date("H", strtotime($fecha[1]));
	$minFin = date("i", strtotime($fecha[1]));
	$fechaIniSimulado = date("Y-m-d", strtotime($fechaSim[0]));
	$horaIniSimulado = date("H", strtotime($fechaSim[0]));
	$minIniSimulado = date("i", strtotime($fechaSim[0]));
	$fechaFinSimulado = date("Y-m-d", strtotime($fechaSim[0]));
	$horaFinSimulado = date("H", strtotime($fechaSim[0]));
	$minFinSimulado = date("i", strtotime($fechaSim[0]));	
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
</div>
</template>
<?php
    if (in_array("resmensaje", explode(",", $Page->getCurrentDetailTable())) && $resmensaje->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("resmensaje", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ResmensajeGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_mensajesadd", "tpm_mensajesadd", "mensajesadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("mensajes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("label#elh_mensajes_id_tareas").remove(),$("label#elh_mensajes_titulo").remove(),$("label#elh_mensajes_mensaje").remove(),$("label#elh_mensajes_fechareal_start").remove(),$("label#elh_mensajes_fechasim_start").remove(),$("label#elh_mensajes_medios").remove(),$("label#elh_mensajes_id_actor").remove(),$("label#elh_mensajes_para").remove(),$("label#elh_mensajes_adjunto").remove(),$("label#elh_mensajes_actividad_esperada").remove(),$("<input>").attr({id:"bnt1",name:"xxxx",value:"",type:"hidden"}).appendTo("form"),$("#btn-action").after('&nbsp; <button class="btn btn-info ew-btn"  name="btn" id="btn" type="submit"  onclick="this.form.xxxx.value=1"> Grabar y nuevo </button>');
});
</script>
