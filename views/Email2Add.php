<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Email2Add = &$Page;
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
var currentForm, currentPageID;
var $ = jQuery;
var femail2add;
loadjs.ready("head", function () {
   
    $('.text-dark').text("Reenviar");
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    femail2add = currentForm = new ew.Form("femail2add", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "email2")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.email2)
        ew.vars.tables.email2 = currentTable;
    femail2add.addFields([
        ["sender_userid", [fields.sender_userid.visible && fields.sender_userid.required ? ew.Validators.required(fields.sender_userid.caption) : null], fields.sender_userid.isInvalid],
        ["copy_sender", [fields.copy_sender.visible && fields.copy_sender.required ? ew.Validators.required(fields.copy_sender.caption) : null], fields.copy_sender.isInvalid],
        ["sujeto", [fields.sujeto.visible && fields.sujeto.required ? ew.Validators.required(fields.sujeto.caption) : null], fields.sujeto.isInvalid],
        ["id_mensaje", [fields.id_mensaje.visible && fields.id_mensaje.required ? ew.Validators.required(fields.id_mensaje.caption) : null], fields.id_mensaje.isInvalid],
        ["mensaje", [fields.mensaje.visible && fields.mensaje.required ? ew.Validators.required(fields.mensaje.caption) : null], fields.mensaje.isInvalid],
        ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.fileRequired(fields.archivo.caption) : null], fields.archivo.isInvalid],
        ["reciever_userid", [fields.reciever_userid.visible && fields.reciever_userid.required ? ew.Validators.required(fields.reciever_userid.caption) : null], fields.reciever_userid.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = femail2add,
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
    femail2add.validate = function () {
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
    femail2add.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femail2add.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    femail2add.lists.sender_userid = <?= $Page->sender_userid->toClientList($Page) ?>;
    femail2add.lists.copy_sender = <?= $Page->copy_sender->toClientList($Page) ?>;
    loadjs.done("femail2add");
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
<form name="femail2add" id="femail2add" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="id_mensaje" id="id_mensaje" value="<?php echo $_GET['IdResMsg'] ?>">
<input type="hidden" name="t" value="email2">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div" ><!-- page* -->
<?php if ($Page->sender_userid->Visible) { // sender_userid ?>
    <div id="r_sender_userid" class="form-group row">
        <label id="elh_email2_sender_userid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sender_userid->caption() ?><?= $Page->sender_userid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sender_userid->cellAttributes() ?>>
<span id="el_email2_sender_userid">
    
    
    <div id="vue-P">
                    <select class="js-example-basic-multiple1 form-control ew-select <?= $Page->sender_userid->isInvalidClass() ?>"  multiple="multiple" id="x_sender_userid[]"
        name="x_sender_userid[]" data-select2-id="email2_x_sender_userid[]"
        data-table="email2"
        data-field="x_sender_userid" data-placeholder="<?= HtmlEncode($Page->sender_userid->getPlaceHolder()) ?>">
                        <option v-for="participante in participantesP" v-bind:value="participante.id">{{participante.nombre}} </option>
                    </select>
                    
    <!-- Miguel filtro-->
    <button type="button" data-toggle="dropdown" id="botonEstado" class="btn btn-ligth dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"></span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item " href="#" onclick=""></a>
                            <a class="dropdown-item " href="#" onclick="busquedaFiltrada('1',1);">ExCon General</a>
                            <a class="dropdown-item " href="#" onclick="busquedaFiltrada('2',1);">Excon Grupo</a>
                            <a class="dropdown-item " href="#" onclick="busquedaFiltrada('3',1);">Participante</a>
                        </div>
    </div>
    
    <?= $Page->sender_userid->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->sender_userid->getErrorMessage() ?></div>
<?= $Page->sender_userid->Lookup->getParamTag($Page, "p_x_sender_userid") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='email2_x_sender_userid[]']"),
        options = { name: "x_sender_userid[]", selectId: "email2_x_sender_userid[]", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 3;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.email2.fields.sender_userid.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->copy_sender->Visible) { // copy_sender ?>
    <div id="r_copy_sender" class="form-group row">
        <label id="elh_email2_copy_sender" class="<?= $Page->LeftColumnClass ?>"><?= $Page->copy_sender->caption() ?><?= $Page->copy_sender->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->copy_sender->cellAttributes() ?>>
<span id="el_email2_copy_sender">
    <select
     hidden
        id="x_copy_sender[]"
        name="x_copy_sender[]"
        class="form-control ew-select"
        data-dropdown
        multiple
        size="1"
        data-value-separator="<?= $Page->copy_sender->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->copy_sender->getPlaceHolder()) ?>">
    </select>
    <div id="vue-C">
                    <select class="js-example-basic-multiple <?= $Page->copy_sender->isInvalidClass() ?>"  multiple="multiple" id="x_copy_sender[]"
        name="x_copy_sender[]" data-select2-id="email2_x_copy_sender[]" data-table="email2"
        data-field="x_copy_sender" data-placeholder="<?= HtmlEncode($Page->copy_sender->getPlaceHolder()) ?>">
                        <option v-for="participante in participantesC" v-bind:value="participante.id">{{participante.nombre}} </option>
                    </select>
                    
    <!-- Miguel filtro-->
    <button type="button" data-toggle="dropdown" id="botonEstado" class="btn btn-ligth dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"></span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item " href="#" onclick=""></a>
                            <a class="dropdown-item " href="#" onclick="busquedaFiltrada('1',2);">ExCon General</a>
                            <a class="dropdown-item " href="#" onclick="busquedaFiltrada('2',2);">Excon Grupo</a>
                            <a class="dropdown-item " href="#" onclick="busquedaFiltrada('3',2);">Participante</a>
                        </div>
    </div>
    <script>$(document).ready(function() {
        $('.js-example-basic-multiple').select2();
});</script>
<script>$(document).ready(function() {
        $('.js-example-basic-multiple1').select2();
});

var app = new Vue({
        el: '#vue-P',
        data: {
            participantesP:[]
        }
    });
    var appC = new Vue({
        el: '#vue-C',
        data: {
            participantesC:[]
        }
    });
    llenar();
    function llenar(){
        $.ajax({
            url: "inject/obtenerUsuarios.php?perfil="+0,
            success: function (es) {
                console.log(es);
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                        let add = {
                            "id":respuesta[i].id,
                            "nombre":respuesta[i].nombre
                        };
                        app.participantesP.push(add);
                        appC.participantesC.push(add);
                    
                }
                 
            },
            error: function (e) {
                console.log(e);
            }
        });
        
    }
    function busquedaFiltrada(perfil,campo) {
        if(campo=='1')
        {
            app.participantesP=[];
                }
            else{
                appC.participantesC=[];
        }
                        
        $.ajax({
            url: "inject/obtenerUsuarios.php?perfil="+perfil,
            success: function (es) {
                console.log(es);
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                        let add = {
                            "id":respuesta[i].id,
                            "nombre":respuesta[i].nombre
                        };
                        if(campo=='1')
                        {
                            app.participantesP.push(add);
                        }
                        else{
                            appC.participantesC.push(add);
                        }     
                }
                 
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    </script>

    <?= $Page->copy_sender->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->copy_sender->getErrorMessage() ?></div>
<?= $Page->copy_sender->Lookup->getParamTag($Page, "p_x_copy_sender") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='email2_x_copy_sender[]']"),
        options = { name: "x_copy_sender[]", selectId: "email2_x_copy_sender[]", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 3;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.email2.fields.copy_sender.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
    <div id="r_sujeto" class="form-group row">
        <label id="elh_email2_sujeto" for="x_sujeto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sujeto->caption() ?><?= $Page->sujeto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sujeto->cellAttributes() ?>>
<span id="el_email2_sujeto">
<input type="<?= $Page->sujeto->getInputTextType() ?>" data-table="email2" data-field="x_sujeto" name="x_sujeto" id="x_sujeto" size="60" maxlength="60" placeholder="<?= HtmlEncode($Page->sujeto->getPlaceHolder()) ?>" value="<?= $Page->sujeto->EditValue ?>"<?= $Page->sujeto->editAttributes() ?> aria-describedby="x_sujeto_help">
<?= $Page->sujeto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sujeto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <div id="r_mensaje" class="form-group row">
        <label id="elh_email2_mensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mensaje->caption() ?><?= $Page->mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mensaje->cellAttributes() ?>>
<span id="el_email2_mensaje">
<?php $Page->mensaje->EditAttrs->appendClass("editor"); ?>
<textarea data-table="email2" data-field="x_mensaje" name="x_mensaje" id="x_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->mensaje->getPlaceHolder()) ?>"<?= $Page->mensaje->editAttributes() ?> aria-describedby="x_mensaje_help"><?= $Page->mensaje->EditValue ?></textarea>
<?= $Page->mensaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mensaje->getErrorMessage() ?></div>
<script>
loadjs.ready(["femail2add", "editor"], function() {
	ew.createEditor("femail2add", "x_mensaje", 0, 0, <?= $Page->mensaje->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>

<?php if ($Page->archivo->Visible) { // archivo ?>
    <div id="r_archivo" class="form-group row">
        <label id="elh_email2_archivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->archivo->caption() ?><?= $Page->archivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->archivo->cellAttributes() ?>>
<span id="el_email2_archivo">
<div id="fd_x_archivo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->archivo->title() ?>" data-table="email2" data-field="x_archivo" name="x_archivo" id="x_archivo" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->archivo->editAttributes() ?><?= ($Page->archivo->ReadOnly || $Page->archivo->Disabled) ? " disabled" : "" ?> aria-describedby="x_archivo_help">
        <label class="custom-file-label ew-file-label" for="x_archivo"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->archivo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->archivo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_archivo" id= "fn_x_archivo" value="<?= $Page->archivo->Upload->FileName ?>">
<input type="hidden" name="fa_x_archivo" id= "fa_x_archivo" value="0">
<input type="hidden" name="x_id_mensaje" id="x_id_mensaje" value="<?php echo $_GET['IdResMsg'] ?>">
<input type="hidden" name="fs_x_archivo" id= "fs_x_archivo" value="100">
<input type="hidden" name="fx_x_archivo" id= "fx_x_archivo" value="<?= $Page->archivo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_archivo" id= "fm_x_archivo" value="<?= $Page->archivo->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_archivo" id= "fc_x_archivo" value="<?= $Page->archivo->UploadMaxFileCount ?>">

</div>
<table id="ft_x_archivo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("email2");
});
</script>

<script>
loadjs.ready("load", function () {
    // Startup script
    
    $("label#elh_email2_sender_userid").remove(),$("label#elh_email2_sujeto").remove(),$("label#elh_email2_mensaje").remove(),$("label#elh_email2_copy_sender").remove(),$("label#elh_email2_archivo").remove(),$("h4").text("Nuevo Correo");var a=ew.vars.v,fec=ew.vars.fecha,aped=ew.vars.ape,namep=ew.vars.nom,titulo=ew.vars.titles,cuerpo=ew.vars.bodys,idresponder=ew.vars.idm,idrenviar=ew.vars.re;if(void 0!==idrenviar&&idrenviar&&($("#x_sujeto").val("Fwd: "+titulo),$("#x_mensaje").html(" ---------- Forwarded message --------- <br> De: "+namep+" "+aped+"<br> Fecha: "+fec+"<br>"+cuerpo)),void 0!==idresponder&&idresponder){var archivo=ew.vars.arch,remi=ew.vars.remitente;$("#x_sujeto").val("Re: "+titulo),$("#id_mensaje"),$("#x_mensaje").html("La Fecha "+fec+" <strong>"+namep+" "+aped+" </strong> Escribió: <br>----------"+cuerpo)}$("#btn-action").html("Enviar"),$(".ew-submit").html("Enviar");
});
</script>
