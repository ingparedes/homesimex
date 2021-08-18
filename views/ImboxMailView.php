<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ImboxMailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fimbox_mailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fimbox_mailview = currentForm = new ew.Form("fimbox_mailview", "view");
    loadjs.done("fimbox_mailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.imbox_mail) ew.vars.tables.imbox_mail = <?= JsonEncode(GetClientVar("tables", "imbox_mail")) ?>;
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
<form name="fimbox_mailview" id="fimbox_mailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="imbox_mail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id_email->Visible) { // id_email ?>
    <tr id="r_id_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_id_email"><template id="tpc_imbox_mail_id_email"><?= $Page->id_email->caption() ?></template></span></td>
        <td data-name="id_email" <?= $Page->id_email->cellAttributes() ?>>
<template id="tpx_imbox_mail_id_email"><span id="el_imbox_mail_id_email">
<span<?= $Page->id_email->viewAttributes() ?>>
<?= $Page->id_email->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sender_userid->Visible) { // sender_userid ?>
    <tr id="r_sender_userid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_sender_userid"><template id="tpc_imbox_mail_sender_userid"><?= $Page->sender_userid->caption() ?></template></span></td>
        <td data-name="sender_userid" <?= $Page->sender_userid->cellAttributes() ?>>
<template id="tpx_imbox_mail_sender_userid"><span id="el_imbox_mail_sender_userid">
<span<?= $Page->sender_userid->viewAttributes() ?>>
<?= $Page->sender_userid->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reciever_userid->Visible) { // reciever_userid ?>
    <tr id="r_reciever_userid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_reciever_userid"><template id="tpc_imbox_mail_reciever_userid"><?= $Page->reciever_userid->caption() ?></template></span></td>
        <td data-name="reciever_userid" <?= $Page->reciever_userid->cellAttributes() ?>>
<template id="tpx_imbox_mail_reciever_userid"><span id="el_imbox_mail_reciever_userid">
<span<?= $Page->reciever_userid->viewAttributes() ?>>
<?= $Page->reciever_userid->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alerta->Visible) { // alerta ?>
    <tr id="r_alerta">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_alerta"><template id="tpc_imbox_mail_alerta"><?= $Page->alerta->caption() ?></template></span></td>
        <td data-name="alerta" <?= $Page->alerta->cellAttributes() ?>>
<template id="tpx_imbox_mail_alerta" class="imbox_mailview">
<?php
$idpage = CurrentPage()->id_email->CurrentValue;
$row = ExecuteRow("SELECT status FROM user_email WHERE id_email = '".$idpage."'  AND id_user_destinatario = '".CurrentUserID()."'" );
if ($row[0] == 0){ 
?>
<span class="badge badge-danger">Nuevo</span>
<?php
}
?>
</template>
<template id="tpx_imbox_mail_alerta"><span id="el_imbox_mail_alerta">
<span<?= $Page->alerta->viewAttributes() ?>><slot name="tpx_imbox_mail_alerta"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->copy_sender->Visible) { // copy_sender ?>
    <tr id="r_copy_sender">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_copy_sender"><template id="tpc_imbox_mail_copy_sender"><?= $Page->copy_sender->caption() ?></template></span></td>
        <td data-name="copy_sender" <?= $Page->copy_sender->cellAttributes() ?>>
<template id="tpx_imbox_mail_copy_sender"><span id="el_imbox_mail_copy_sender">
<span<?= $Page->copy_sender->viewAttributes() ?>>
<?= $Page->copy_sender->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
    <tr id="r_sujeto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_sujeto"><template id="tpc_imbox_mail_sujeto"><?= $Page->sujeto->caption() ?></template></span></td>
        <td data-name="sujeto" <?= $Page->sujeto->cellAttributes() ?>>
<template id="tpx_imbox_mail_sujeto"><span id="el_imbox_mail_sujeto">
<span<?= $Page->sujeto->viewAttributes() ?>>
<?= $Page->sujeto->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <tr id="r_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_mensaje"><template id="tpc_imbox_mail_mensaje"><?= $Page->mensaje->caption() ?></template></span></td>
        <td data-name="mensaje" <?= $Page->mensaje->cellAttributes() ?>>
<template id="tpx_imbox_mail_mensaje"><span id="el_imbox_mail_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <tr id="r_archivo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_archivo"><template id="tpc_imbox_mail_archivo"><?= $Page->archivo->caption() ?></template></span></td>
        <td data-name="archivo" <?= $Page->archivo->cellAttributes() ?>>
<template id="tpx_imbox_mail_archivo" class="imbox_mailview">
<?php
$arcxmail = CurrentPage()->archivo->CurrentValue;
//echo $arcx;
if ($arcxmail != '') { 
 echo '<a  href="/homesimex/files/'.$arcxmail.'" target="_blank"><i class="cil-paperclip"></i></a>'; }
?>
</template>
<template id="tpx_imbox_mail_archivo"><span id="el_imbox_mail_archivo">
<span<?= $Page->archivo->viewAttributes() ?>><slot name="tpx_imbox_mail_archivo"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
    <tr id="r_tiempo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_tiempo"><template id="tpc_imbox_mail_tiempo"><?= $Page->tiempo->caption() ?></template></span></td>
        <td data-name="tiempo" <?= $Page->tiempo->cellAttributes() ?>>
<template id="tpx_imbox_mail_tiempo"><span id="el_imbox_mail_tiempo">
<span<?= $Page->tiempo->viewAttributes() ?>>
<?= $Page->tiempo->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado_msg->Visible) { // estado_msg ?>
    <tr id="r_estado_msg">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_estado_msg"><template id="tpc_imbox_mail_estado_msg"><?= $Page->estado_msg->caption() ?></template></span></td>
        <td data-name="estado_msg" <?= $Page->estado_msg->cellAttributes() ?>>
<template id="tpx_imbox_mail_estado_msg"><span id="el_imbox_mail_estado_msg">
<span<?= $Page->estado_msg->viewAttributes() ?>>
<?= $Page->estado_msg->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
    <tr id="r_id_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imbox_mail_id_mensaje"><template id="tpc_imbox_mail_id_mensaje"><?= $Page->id_mensaje->caption() ?></template></span></td>
        <td data-name="id_mensaje" <?= $Page->id_mensaje->cellAttributes() ?>>
<template id="tpx_imbox_mail_id_mensaje"><span id="el_imbox_mail_id_mensaje">
<span<?= $Page->id_mensaje->viewAttributes() ?>>
<?= $Page->id_mensaje->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_imbox_mailview" class="ew-custom-template"></div>
<template id="tpm_imbox_mailview">
<div id="ct_ImboxMailView">    <head>
<title><?php echo $Language->TablePhrase("imboxMailView", "actualizar"); ?></title>
<meta name="generator" content="PHPMaker 2021.0.9">
</head>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
          <a class="btn btn-default ew-add-edit ew-add" title="" data-table="email2" data-caption="Agregar" href="#" onclick="return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'/homesimex/Email2Add'});" data-original-title="Agregar"><i data-phrase="AddLink" class="fas fa-plus ew-icon" data-caption="Agregar"></i></a>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><?php echo $Language->TablePhrase("imboxMailView", "carpetas"); ?></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="../Email2List" class="nav-link">
                      <i class="cil-envelope-closed"></i> <?php echo $Language->TablePhrase("imboxMailView", "env"); ?> 
                      <span class="badge bg-primary float-right"></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../ImboxMailList" class="nav-link">
                      <i class="cil-inbox"></i> <?php echo $Language->TablePhrase("imboxMailView", "rec"); ?>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?php echo $Language->TablePhrase("imboxMailView", "leermens"); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><?php echo $Language->TablePhrase("imboxMailView", "suj"); ?> <slot class="ew-slot" name="tpx_imbox_mail_sujeto"></slot></h5>
                <h6><?php echo $Language->TablePhrase("imboxMailView", "de"); ?> <slot class="ew-slot" name="tpx_imbox_mail_reciever_userid"></slot>
                  <span class="mailbox-read-time float-right"><slot class="ew-slot" name="tpx_imbox_mail_tiempo"></slot></span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <slot class="ew-slot" name="tpx_imbox_mail_mensaje"></slot>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
   <div class="card-footer bg-white">
              <ul class="list-group">
                <li class="list-group-item">
<?php
$idEmail = CurrentPage()->id_email->CurrentValue;
$fil = ExecuteScalar("SELECT archivo FROM email where id_email =$idEmail");
if (isset($fil)) {
$photos = explode (',',$fil);
if(count($photos)>0){
foreach ($photos as $rowPhoto){
print " <div class='mailbox-attachment-info'>
<a href='../files/$rowPhoto' target='_blank'><i class='fas fa-paperclip'></i> $rowPhoto</a> </div> <br>";}
};
};
?>
                </li>
              </ul>
              <div class="card-footer">
        <a class="btn btn-default ew-add-edit " title="" data-caption="Enviar" href="/homesimex/Email2Add?id_email=<?php echo CurrentPage()->id_email->CurrentValue; ?>" data-original-title="Enviar">
         <i class="fas fa-reply"></i> &nbsp;<?php echo $Language->TablePhrase("imboxMailView", "res"); ?>
        </a>
           <a class="btn btn-default ew-add-edit " title="" data-caption="Enviar" href="/homesimex/Email2Add?Idrenviar=<?php echo CurrentPage()->id_email->CurrentValue; ?>" data-original-title="Enviar">
           <?php echo $Language->TablePhrase("imboxMailView", "reenv"); ?>&nbsp;<i class="fas fa-sign-out-alt"></i> 
        </a>
        </div>
        <!--
<a class="btn btn-default ew-row-link ew-copy" title="" data-table="email2" data-caption="Copiar" href="#"
onclick="return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'/homesimex/Email2Add?Idmail=<?php echo CurrentPage()->id_email->CurrentValue; ?>'});"
data-original-title="Copiar"> <i data-phrase="CopyLink" class="icon-copy ew-icon" data-caption="Copiar"></i></a> 
              <button type="button" class="btn btn-primary">Reviar</button> -->
            </div>
            <!-- /.card-footer -->
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</html>
    <?php
    	 Execute("UPDATE user_email set status = '1' WHERE id_user_destinatario = '".CurrentUserID()."'");   
     ?>
</div>
</template>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_imbox_mailview", "tpm_imbox_mailview", "imbox_mailview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Startup script
    $(".ew-edit").hide();
});
</script>
<?php } ?>
