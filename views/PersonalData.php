<?php namespace PHPMaker2021\simexamerica; ?>
<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PersonalData = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php if (SameText(Get("cmd"), "Delete")) { ?>
    <script>
        var fdeleteuser;
        loadjs.ready("head", function() {
            var $ = jQuery;
            fdeleteuser = new ew.Form("fdeleteuser");

            // Add field
            fdeleteuser.addFields([
                ["password", ew.Validators.required(ew.language.phrase("Password"))]
            ]);

            // Set invalid fields
            $(function() {
                fdeleteuser.setInvalid();
            });

            // Extend page with Validate function
            fdeleteuser.validate = function() {
                if (!this.validateRequired)
                    return true; // Ignore validation

                // Validate fields
                if (!this.validateFields())
                    return false;
                return true;
            }

            // Use JavaScript validation
            fdeleteuser.validateRequired = <?= JsonEncode(Config("CLIENT_VALIDATE")) ?>;
            loadjs.done("fdeleteuser");
        });
    </script>
    <div class="alert alert-danger d-inline-block">
        <i class="icon fas fa-ban"></i><?= $Language->phrase("PersonalDataWarning") ?>
    </div>
    <?php if (!EmptyString($Page->getFailureMessage())) { ?>
    <div class="text-danger">
        <ul>
            <li><?= $Page->getFailureMessage() ?></li>
        </ul>
    </div>
    <?php } ?>
    <div>
        <form name="fdeleteuser" id="fdeleteuser" method="post" class="form-group">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
            <div class="text-danger"></div>
            <div class="form-group">
                <label id="label" class="control-label ew-label"><?= $Language->phrase("Password") ?></label>
                <div class="input-group">
                    <input type="password" name="<?= $Page->Password->FieldVar ?>" id="<?= $Page->Password->FieldVar ?>" autocomplete="current-password" placeholder="<?= HtmlEncode($Language->phrase("Password")) ?>"<?= $Page->Password->editAttributes() ?>>
                    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
                    <div class="invalid-feedback"><?= $Page->Password->getErrorMessage() ?></div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit"><?= $Language->phrase("CloseAccountBtn") ?></button>
        </form>
    </div>
<?php } else { ?>
    <div class="row">
    <div class="col-md-6">
           
     
<?php 

$User = CurrentUserInfo("nombres");
$ape = CurrentUserInfo("apellidos");
$imgs = CurrentUserInfo("img_user");
$UserPer = CurrentUserInfo("perfil"); 
$mail = CurrentUserInfo("email"); 
$p = CurrentUserInfo("pais"); 
$Ids= CurrentUserID();
$UserGru = CurrentUserInfo("grupo"); 

$UserP = ExecuteScalar("SELECT UserLevelName FROM userlevels WHERE UserLevelID = ".$UserPer);
$UserGrd = ExecuteScalar("SELECT nombre_grupo FROM grupo WHERE id_grupo =".$UserGru);
$Usersubg = ExecuteRow("SELECT nombre_subgrupo FROM subgrupo WHERE id_subgrupo =".CurrentUserInfo("subgrupo") );
$coutry = ExecuteRow("SELECT * FROM paisgmt WHERE id_zone =".$p );

if (!empty($imgs))
{$fotos = $imgs;}
else
{$fotos = 'silueta.png';};


?>

            <!-- Profile Image -->
            <div class="card card-outline">
              <div class="card-body box-profile">
              <div class="btn-toolbar ew-toolbar">
                <span class="ew-action-option ew-list-option-separator text-nowrap" data-name="button">
                    <div class="btn-group">
                    <a class="ew-action ew-edit" data-caption="Editar" href="/homesimex/UsersEdit/<?php echo $Ids  ?>" data-original-title="Editar" title=""><i data-phrase="ViewPageEditLink" class="icon-edit ew-icon mr-2" data-caption="Editar"></i></a>
                </div>            
            </div>
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="/homesimex/files/<?php echo $fotos ?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $User." ". $ape  ?></h3>

                <p class="text-muted text-center"><?php echo $UserP  ?></p>
                <?php
                $grupo= $Language->phrase("grupo");
                $subgrupo= $Language->phrase("subgrupo");
                $email= $Language->phrase("email");
                $pais= $Language->phrase("pais");
                ?>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b><?php echo $grupo  ?>: <?php echo $UserGrd  ?></p></b> 
                  </li>
                  <li class="list-group-item">
                    <b><?php echo $subgrupo  ?>: <em> <?php echo $Usersubg[0];  ?></em></b>  
                  </li>
                  <li class="list-group-item">
                    <b><?php echo $email  ?>: <em> <?php echo $mail  ?></em></b> 
                  </li>
                  <li class="list-group-item">
                    <b><?php echo $pais  ?>: <em> <?php echo $coutry[2]." / ". $coutry[4]   ?></em></b> 
                  </li>

                </ul>

                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
         
        </div>
    </div>
<?php } ?>
<?php $Page->clearFailureMessage(); ?>
