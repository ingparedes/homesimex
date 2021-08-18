<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Timelinemensajes = &$Page;
?>
<?php $_SESSION['userid'] = CurrentUserID(); ?>
<div class="container py-2">
    <h2 class="font-weight-light text-center text-muted py-3"><?php echo $Language->TablePhrase("timeline_mensajes", "boots"); ?></h2>

    <!-- timeline item 1 -->
    <div class="row">
        <!-- timeline item 1 left dot -->
        <div class="col-auto text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-light border">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <!-- timeline item 1 event content -->
        <div class="col py-2">
            <div class="card">
                <div class="card-body">
                    <div class="float-right text-muted"><?php echo $Language->TablePhrase("timeline_mensajes", "monjan"); ?></div>
                    <h4 class="card-title text-muted"><?php echo $Language->TablePhrase("timeline_mensajes", "day1"); ?></h4>
                    <p class="card-text"><?php echo $Language->TablePhrase("timeline_mensajes", "bienvenida"); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
    <!-- timeline item 2 -->
    <div class="row">
        <div class="col-auto text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-success">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <div class="col py-2">
            <div class="card border-success shadow">
                <div class="card-body">
                    <div class="float-right text-success"><?php echo $Language->TablePhrase("timeline_mensajes", "jan10"); ?></p></div>
                    <h4 class="card-title text-success"><?php echo $Language->TablePhrase("timeline_mensajes", "day2"); ?></p></h4>
                    <p class="card-text"><?php echo $Language->TablePhrase("timeline_mensajes", "instrucci"); ?></p></p>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-target="#t2_details" data-toggle="collapse"><?php echo $Language->TablePhrase("timeline_mensajes", "detalles"); ?></p></button>
                    <div class="collapse border" id="t2_details">
                        <div class="p-2 text-monospace">
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "desay"); ?></p></div>
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "session"); ?></p></div>
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "almuerz"); ?></p></div>
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "sessionL"); ?></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
    <!-- timeline item 3 -->
    <div class="row">
        <div class="col-auto text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-light border">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <div class="col py-2">
            <div class="card">
                <div class="card-body">
                    <div class="float-right text-muted"><?php echo $Language->TablePhrase("timeline_mensajes", "jan11"); ?></p></div>
                    <h4 class="card-title"><?php echo $Language->TablePhrase("timeline_mensajes", "day3"); ?></p></h4>
                    <p><?php echo $Language->TablePhrase("timeline_mensajes", "vegan"); ?></p></p>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
    <!-- timeline item 4 -->
    <div class="row">
        <div class="col-auto text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-light border">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <div class="col py-2">
            <div class="card">
                <div class="card-body">
                    <div class="float-right text-muted"><?php echo $Language->TablePhrase("timeline_mensajes", "jan12"); ?></p></div>
                    <h4 class="card-title"><?php echo $Language->TablePhrase("timeline_mensajes", "day4"); ?></p></h4>
                    <p><?php echo $Language->TablePhrase("timeline_mensajes", "almuerzzo"); ?></p></p>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
</div>
<!--container-->

<hr>

<div class="container py-2">
    
    <!-- timeline item 1 -->
    <div class="row no-gutters">
        <div class="col-sm"> <!--spacer--> </div>
        <!-- timeline item 1 center dot -->
        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-light border">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <!-- timeline item 1 event content -->
        <div class="col-sm py-2">
            <div class="card">
                <div class="card-body">
                    <div class="float-right text-muted small"><?php echo $Language->TablePhrase("timeline_mensajes", "jan9"); ?></div>
                    <h4 class="card-title text-muted"><?php echo $Language->TablePhrase("timeline_mensajes", "day1"); ?></h4>
                    <p class="card-text"><?php echo $Language->TablePhrase("timeline_mensajes", "bienvenida"); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
    <!-- timeline item 2 -->
    <div class="row no-gutters">
        <div class="col-sm py-2">
            <div class="card border-success shadow">
                <div class="card-body">
                    <div class="float-right text-success small"><?php echo $Language->TablePhrase("timeline_mensajes", "jan10"); ?></div>
                    <h4 class="card-title text-success"><?php echo $Language->TablePhrase("timeline_mensajes", "day2"); ?></h4>
                    <p class="card-text"><?php echo $Language->TablePhrase("timeline_mensajes", "signup"); ?></p>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-target="#t22_details" data-toggle="collapse"><?php echo $Language->TablePhrase("timeline_mensajes", "detalles"); ?></button>
                    <div class="collapse border" id="t22_details">
                        <div class="p-2 text-monospace">
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "desay"); ?></div>
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "session"); ?></div>
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "almuerz"); ?></div>
                            <div><?php echo $Language->TablePhrase("timeline_mensajes", "sessionL"); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-success">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <div class="col-sm"> <!--spacer--> </div>
    </div>
    <!--/row-->
    <!-- timeline item 3 -->
    <div class="row no-gutters">
        <div class="col-sm"> <!--spacer--> </div>
        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-light border">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <div class="col-sm py-2">
            <div class="card">
                <div class="card-body">
                    <div class="float-right text-muted small"><?php echo $Language->TablePhrase("timeline_mensajes", "jan11"); ?></div>
                    <h4 class="card-title"><?php echo $Language->TablePhrase("timeline_mensajes", "day3"); ?></h4>
                    <p><?php echo $Language->TablePhrase("timeline_mensajes", "bicicle"); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
    <!-- timeline item 4 -->
    <div class="row no-gutters">
        <div class="col-sm py-2">
            <div class="card">
                <div class="card-body">
                    <div class="float-right text-muted small"><?php echo $Language->TablePhrase("timeline_mensajes", "jan12"); ?></div>
                    <h4 class="card-title"><?php echo $Language->TablePhrase("timeline_mensajes", "day4"); ?></h4>
                    <p><?php echo $Language->TablePhrase("timeline_mensajes", "almuerzzo"); ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
            <div class="row h-50">
                <div class="col border-right">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
            <h5 class="m-2">
                <span class="badge badge-pill bg-light border">&nbsp;</span>
            </h5>
            <div class="row h-50">
                <div class="col">&nbsp;</div>
                <div class="col">&nbsp;</div>
            </div>
        </div>
        <div class="col-sm"> <!--spacer--> </div>
    </div>
    <!--/row-->
</div>

<?= GetDebugMessage() ?>
