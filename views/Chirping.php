<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Chirping = &$Page;
?>
<?php session_start();
$id_user = $_GET['id_user'];
?>

    
  
  
<body>
    <?php
    include('../config.php');
    $medio = 3;
    $sql = "SELECT CONCAT(u.nombres,' ',u.apellidos) AS nombre, u.email, u.img_user, m.fechareal_start, m.fechasim_start, m.titulo, m.mensaje, m.adjunto, m.id_actor as actor, m.medios
    FROM mensajes m 
    INNER JOIN mensajes_usuarios mu ON m.id_inyect = mu.id_mensaje
    INNER JOIN users u ON mu.id_user_remitente = u.id_users    
    WHERE mu.id_user_destinatario = '" . $id_user . "' AND m.enviado = '1' AND m.medios = '" . $medio . "' ORDER BY m.id_inyect DESC;";

    $res_sql = mysqli_query($con, $sql);
    $cant = mysqli_num_rows($res_sql);

    $datos_user = "SELECT CONCAT(nombres,' ', apellidos) AS nombre, email, grupo, img_user FROM users WHERE id_users = '" . $id_user . "';";
    $res_dtsUsr = mysqli_query($con, $datos_user);
    $row_dtsUsr = mysqli_fetch_array($res_dtsUsr, MYSQLI_BOTH);

    $sql_prtcp = "SELECT id_users FROM users WHERE grupo = '" . $row_dtsUsr['grupo'] . "'";
    $res_sql_prtcp = mysqli_query($con, $sql_prtcp);
    $cant_prtcp = mysqli_num_rows($res_sql_prtcp);

    ?>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <a class="navbar-brand display-mobile" href="#"><svg viewBox="0 0 24 24" class="r-13gxpu9 r-4qtqp9 r-yyyyoo r-16y2uox r-1q142lx r-8kz0gk r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1srniue">
                <g>
                <img src="img/logo.png" width="40" height="40" >
                </g>
            </svg></a>

        <form class="navbar-form display-mobile" role="search">
            <div class="input-group">
                <input type="text" class="form-control input-search" placeholder="Search Twitter" name="srch-term" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-default btn-search" type="submit"><span></span><i class="iconify octicon octicon-search navbar-search-icon" data-icon="bi:search" data-inline="false"></i></button>

                </div>
            </div>
        </form>
        <div class="dropdown navbar-user-dropdown display-mobile">
            <button class="btn btn-secondary dropdown-toggle btn-circle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#"><?php echo $Language->TablePhrase("Chirping", "actionChirping"); ?></a>
                <a class="dropdown-item" href="#"><?php echo $Language->TablePhrase("Chirping", "anotherChirping"); ?></a>
                <a class="dropdown-item" href="#"><?php echo $Language->TablePhrase("Chirping", "somethingChirping"); ?></a>
            </div>
        </div>
        <button class="btn btn-search-bar display-mobile"><?php echo $Language->TablePhrase("Chirping", "tweetChirping"); ?></button>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarCollapse" style="">

            <ul class="navbar-nav mr-auto" id="navbarsExampleDefault">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><i class="octicon octicon-home iconify" data-icon="ant-design:home-filled" data-inline="false" class="" aria-hidden="true"></i> <?php echo $Language->TablePhrase("Chirping", "homechirping"); ?> <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="octicon octicon-zap iconify" data-icon="bi:lightning-fill" data-inline="false"></i> <?php echo $Language->TablePhrase("Chirping", "momentChirping"); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="iconify octicon octicon-bell" data-icon="ic:baseline-notifications" data-inline="false"></i> <?php echo $Language->TablePhrase("Chirping", "notiChirping"); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="octicon octicon-inbox iconify" data-icon="wpf:message" data-inline="false"></i> <?php echo $Language->TablePhrase("Chirping", "mensajesChirping"); ?></a>
                </li>
            </ul>
            <a class="navbar-brand display-desktop" href="#"><svg viewBox="0 0 24 24" class="r-13gxpu9 r-4qtqp9 r-yyyyoo r-16y2uox r-1q142lx r-8kz0gk r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1srniue">
                    <g>
                    <img src="img/logo.png" width="40" height="40"></g>
                </svg></a>
            <div class="left-drop">
                <form class="navbar-form display-desktop" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control input-search" placeholder="Search Twitter" name="srch-term" id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-search" type="submit"><span></span><i class="iconify octicon octicon-search navbar-search-icon" data-icon="bi:search" data-inline="false"></i></button>
                        </div>
                    </div>
                </form>
                <!-- END: Navbar Search form -->
                <!-- Navbar User menu -->
                <div class="dropdown navbar-user-dropdown display-desktop">
                <img class="avatar-index" src="../../files/<?php echo $row_dtsUsr['img_user'] ?>" alt="">

                </div>
                <div>
                    <!-- END: Navbar User menu -->
                    <!-- Navbar Tweet button -->
                </div>
                <button class="btn btn-search-bar display-desktop" id="refrescar" value="Actualizar"><?php echo $Language->TablePhrase("Chirping", "chirping1"); ?></button>
          

    </nav>
    <div class="main-container" style="margin-top: 30px;">

        <div class="container main-content">
            <div class="row">
                <div class="col profile-col">
                    <!-- Left column -->
                    <div class="content-panel col-md-12">

                        <!-- Who to Follow panel -->
                        <div class="panel-content">
                            <!--Follow list -->
                            <div class="content-mini-background">
                                <div class="row profile-background-mini">
                                </div>
                            </div>

                            <ol class="tweet-list">
                                <li class="tweet-card-index">
                                    <div class="tweet-content">
                                        <div class="avatar-container-index">
                                            <img class="avatar-index" src="../../files/<?php echo $row_dtsUsr['img_user'] ?>" alt="">
                                        </div>
                                        <div class="tweet-header" style="margin-top: 72px;">
                                            <span class="fullname">
                                                <strong><?php echo $row_dtsUsr[0] ?></strong>
                                            </span>
                                            <span class="username tweeter-color-gray-small"><?php echo $row_dtsUsr[1] ?></span>
                                        </div>
                                    </div>

                                </li>
                            </ol>
                            <ul class="navbar-nav content-tweets-index">
                                <li class="profile-stats-item">
                                    <a class="nav-link">
                                        <span class="profile-stats-item profile-stats-item-label">Emails</span>
                                        <span class="profile-stats-item profile-stats-item-number"><?php echo $cant ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link">
                                        <span class="profile-stats-item profile-stats-item-label">Grupo</span>
                                        <span class="profile-stats-item profile-stats-item-number"><?php echo $row_dtsUsr[2] ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link">
                                        <span class="profile-stats-item profile-stats-item-label">Participantes</span>
                                        <span class="profile-stats-item profile-stats-item-number"><?php echo $cant_prtcp ?></span>
                                    </a>
                                </li>
                            </ul>
                            <!--END: Follow list -->
                        </div>
                    </div>
                    <!-- <div class="content-panel col-md-12">
                        <div class="panel-header">
                            <h5><b>Tendencia Global</b> -</h5><small> <a href="">Cambiar</a></small>
                        </div>
                         Who to Follow panel 
                        <div class="panel-content">
                            Follow list 
                            <ol class="tweet-list">
                                <li class="tweet-card-index">
                                    <div class="tweet-content-index">
                                        <div class="tweet-header">
                                            <span>
                                                <a href="" class="twitter-hashtag"><s>#</s><b>TheGiftAlbum</b></a>
                                            </span>
                                        </div>

                                        <small class="tweeter-color-gray-small">93.4mil tweets</small>
                                    </div>
                                </li>
                                <li class="tweet-card-index">
                                    <div class="tweet-content-index">
                                        <div class="tweet-header">
                                            <span>
                                                <a href="" class="twitter-hashtag"><s>#</s><b>TheGiftAlbum</b></a>
                                            </span>
                                        </div>

                                        <small class="tweeter-color-gray-small">93.4mil tweets</small>
                                    </div>
                                </li>
                                <li class="tweet-card-index">
                                    <div class="tweet-content-index">
                                        <div class="tweet-header">
                                            <span>
                                                <a href="" class="twitter-hashtag"><s>#</s><b>TheGiftAlbum</b></a>
                                            </span>
                                        </div>

                                        <small class="tweeter-color-gray-small">93.4mil tweets</small>
                                    </div>
                                </li>
                            </ol>
                            END: Follow list 
                        </div>
                    </div> -->
                </div>
                <!-- End; Left column -->
                <!-- Center content column -->
                <div class="col-md-8 col-sm-12">
                    <ol class="tweet-list">
                        <li class="tweet-card tweet-card-second-background">
                            <div class="tweet-content">
                                <a>

                                    <img class="tweet-card-avatar-thinking" src="../../files/<?php echo $row_dtsUsr['img_user'] ?>" alt="">
                                </a>
                                <div class="tweet-text">
                                    <form class="navbar-form" role="search">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-thinking" placeholder="¿Que está pasando?" name="srch-term" id="srch-term">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default btn-thinking" type="submit"><span></span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512">
                                                        <rect x="48" y="80" width="416" height="352" rx="48" ry="48" fill="none" stroke="#1DA1F2" stroke-linejoin="round" stroke-width="32" />
                                                        <circle cx="336" cy="176" r="32" fill="none" stroke="#1DA1F2" stroke-miterlimit="10" stroke-width="32" />
                                                        <path d="M304 335.79l-90.66-90.49a32 32 0 0 0-43.87-1.3L48 352" fill="none" stroke="#1DA1F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                                        <path d="M224 432l123.34-123.34a32 32 0 0 1 43.11-2L464 368" fill="none" stroke="#1DA1F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                                    </svg></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        <!-- <li class="tweet-card tweet-card-third-background">
                            <div class="tweet-content-view-new-tweets">
                                <a href="#" class="link-view-new-tweets">Ver tweets nuevos</a>
                            </div>
                        </li> -->
                        <!-- desde ahi -->
                        <?php
                        setlocale(LC_TIME, "es_CO");
                        while ($row = mysqli_fetch_array($res_sql, MYSQLI_BOTH)) {
                            if ($row['actor'] <> '0') {
                                $sql_actor = "SELECT * FROM actor_simulado WHERE id_actor = '" . $row['actor'] . "';";
                                $res_sql_actor = mysqli_query($con, $sql_actor);
                                $row_actor = mysqli_fetch_array($res_sql_actor, MYSQLI_BOTH);
                                $rmtnte = $row_actor[1];
                                $email = "Actor Simulado";
                            } else {
                                $rmtnte = $row[0];
                                $email = $row[1];
                            }
                            $sql_updte_leido = "UPDATE mensajes_usuarios mu SET leido = 1 WHERE mu.id_user_destinatario IN ('" . $id_user . "');";
                            $res_updte_leido = mysqli_query($con, $sql_updte_leido);
                        ?>
                            <li class="tweet-card">
                                <div class="tweet-content">
                                    <div class="tweet-header">
                                        <span class="fullname">
                                            <strong><?php echo $rmtnte ?></strong>
                                        </span>
                                        <span class="username"> | <?php echo $email ?></span>
                                        <span class="tweet-time"> | <?php echo date("F j, Y, g:i a", strtotime($row['fechareal_start'])); ?></span>
                                    </div>
                         
                                    <div class="tweet-text">
                                        <p class="" lang="es" data-aria-label-part="0">
                                            <strong> <?php echo $row[5] . "</br>" ?> </strong>
                                            <?php echo $row[6] . "</br>" ?>
                                        </p>
                                    </div>
                                    <div class="tweet-footer">
                                        <a class="tweet-footer-btn">
                                            <i class="iconify" data-icon="akar-icons:arrow-back-thick-fill" data-inline="true"></i><span> <?php echo $Language->TablePhrase("Chirping", "responderCh"); ?></span>

                                        </a>
                                        <a class="tweet-footer-btn">
                                            <i class="iconify" data-icon="akar-icons:arrow-forward-thick-fill" data-inline="true"></i><span> <?php echo $Language->TablePhrase("Chirping", "reenviarCh"); ?></span>
                                        </a>
                                        <a class="tweet-footer-btn">
                                            <i class="iconify" data-icon="ic:baseline-mark-email-read" data-inline="true"></i><span> <?php echo $Language->TablePhrase("Chirping", "leidoCh"); ?></span>
                                        </a>
                                        <a class="tweet-footer-btn">
                                            <i class="iconify" data-icon="ion:trash-bin-sharp" data-inline="true"></i><span> <?php echo $Language->TablePhrase("Chirping", "eliminarCh"); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        <!--
                        <li class="tweet-card">
                            <div class="tweet-content">
                                <div class="tweet-header">
                                    <span class="fullname">
                                        <strong>Jon Vadillo</strong>
                                    </span>
                                    <span class="username">@JonVadillo</span>
                                    <span class="tweet-time">- Jul 18</span>
                                </div>
                                <a>
                                    <img class="tweet-card-avatar" src="./img/byeUQc0Q_400x400.jpg" alt="">
                                </a>
                                <div class="tweet-text">
                                    <p class="" lang="es" data-aria-label-part="0">¡Nuevo artículo en Mozilla!<br>Resuelto: Corregido – Una breve historia sobre un error reportado por la comunidad <a href="https://t.co/dqg5hVQXA0" class="twitter-timeline-link" target="_blank"><span class="">https://www.mozilla-hispano.org/</span></a> <a href="" class="twitter-hashtag"><s>#</s><b>firefox</b></a> <a href="" class="twitter-hashtag"><s>#</s><b>comunidad</b></a>
                                        <a href="" class="twitter-hashtag" dir="ltr"></a>
                                    </p>
                                </div>
                                <div class="tweet-footer">
                                    <a class="tweet-footer-btn">
                                        <i class="octicon octicon-comment iconify" data-icon="bx:bx-comment" data-inline="true"></i><span> 18</span>
                                    </a>
                                    <a class="tweet-footer-btn">

                                        <i class="octicon octicon-sync iconify" data-icon="ant-design:sync-outlined" data-inline="true"></i><span> 64</span>
                                    </a>
                                    <a class="tweet-footer-btn">
                                        <i class="octicon octicon-heart iconify" data-icon="wpf:like" data-inline="true"></i><span> 202</span>
                                    </a>
                                    <a class="tweet-footer-btn">
                                        <i class="octicon octicon-mail iconify" data-icon="ant-design:mail-outlined" data-inline="true"></i><span> 155</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                        -->
                    </ol>
                    <!-- End: tweet list -->
                </div>
                <!-- End: Center content column -->
                <div class="col">

                </div>
            </div>
        </div>
</body>
<script>
  //Cuando la página esté cargada
  $(document).ready(function(){
    //Creamos el evento click del botón
    $("#refrescar").click(function(){
      //Actualizamos la página
      location.reload();
    });
  });
</script>


<?= GetDebugMessage() ?>
