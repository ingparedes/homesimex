<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <title>Usuarios -> Grupos</title>
</head>
<style type="text/css">
    .card-body-grupo {
        padding-left: 5px;
    }

    .card-body-subgrupo {
        padding-left: 5px;
        padding-right: 5px;
        height: 100px;
        overflow-y: scroll;
    }

    .bg-primary {
        background-color: #0d6efd !important;
        margin-left: 15px;
        margin-right: 15px;
    }
</style>

<body>

    <?php
    echo "escenario " . $_GET['idEscenario'];
    $idEscenario = $_GET['idEscenario'];
    require_once('config.php');
    $sql_escnrio = "SELECT e.id_escenario, e.nombre_escenario FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario ";
    $result  = mysqli_query($con, $sql_escnrio);
    ?>
    <div class="container">
        <select id="escenario" name="escenario" onchange="location.href='?idEscenario='+this.value">
            <option value="0">Seleccione Escenario...</option>;
            <?php
            while ($valor = mysqli_fetch_array($result)) {
                echo "<option value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
            }
            ?>
        </select>
        <div class="alert alert-primary alert-dismissible fade show" role="alert" id="alerta">
            Asignación Correcta!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row">

            <div class="col-md-4">
                <?php
                $sql = "SELECT * FROM userlevels WHERE userlevelid > 1 ORDER BY userlevelname;";
                $result  = mysqli_query($con, $sql);
                ?>
                <br>
                <h5>USUARIOS</h5>
                <div class="row sortable" id="usuarios">
                    <?php
                    $sql = "SELECT * FROM users us INNER JOIN userlevels ul ON us.perfil = ul.userlevelid WHERE us.grupo = '0' and us.perfil <> '1' ORDER BY us.perfil;";
                    $result = mysqli_query($con, $sql);
                    $tmp = "";
                    while ($row = mysqli_fetch_array($result)) { ?>
                        <div class="col-md-12" data-index="<?php echo $row['id_users']  ?>" data-estado="user" id="<?php echo $row['id_users']  ?>" draggable="true">
                            <div class="drop__card">
                                <div class="drop__data">
                                    <img id="img_<?php echo $row['id_users']  ?>" src="fotos/<?php echo $row['img_user']  ?>" alt="" class="drop__img">
                                    <div>
                                        <h1 class="drop__name">
                                            <?php echo $row['nombres'] . " " . $row['apellidos'] ?>
                                        </h1>
                                        <span id="perf_<?php echo $row['id_users']  ?>" class="drop__profession">
                                            <?php echo $row['userlevelname'] ?>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div><br>

                    <?php }
                    ?>

                </div>

            </div>

            <div class="col-md-6">
                <div id="grupos">
                    <?php
                    //$sql = "SELECT * FROM grupo ORDER BY nombre_grupo;";
                    $sqlG = "SELECT * FROM grupo g  WHERE g.id_escenario = '" . $idEscenario . "' ORDER BY g.nombre_grupo;";
                    $result_G  = mysqli_query($con, $sqlG);
                    ?>

                    <br>
                    <?php while ($rowG = mysqli_fetch_array($result_G)) { ?>
                        <div class="card bg-secondary text-white">
                            <div class="card-body" id="gr-<?php echo $rowG[0] ?>" data_id="gr-<?php echo $rowG[0] ?>">
                                <h5 class="card-title" id="gr-<?php echo $rowG[0] ?>-h">Grupo: <?php echo $rowG[1] ?></h5>
                            </div>
                        </div>
                        <?php
                        $sqlSG = "SELECT * FROM subgrupo WHERE id_grupo = $rowG[0] ORDER BY nombre_subgrupo";
                        $result_SG  = mysqli_query($con, $sqlSG);
                        $cant_SG = mysqli_num_rows($result_SG); ?>
                        <div class="circulo" id="cant_sgs_<?php echo $rowG[0] ?>" style="display: none"><?php echo $cant_SG ?></div>
                        <?php
                        while ($rowSG = mysqli_fetch_array($result_SG)) { ?>
                            <div class="card bg-primary text-white">
                                <div class="card-body-subgrupo" data_id="sg-<?php echo $rowSG[0] ?>" id="sg-<?php echo $rowSG[0] ?>-g-<?php echo $rowG[0] ?>">
                                    <h5 class="card-title" id="sg-<?php echo $rowSG[0] ?>-g-<?php echo $rowG[0] ?>">Sub Grupo: <?php echo $rowSG[1] ?></h5>
                                    <p class="card-text"> <?php echo $rowSG[2] ?> </p>

                                </div>
                            </div>
                    <?php }
                    } ?>

                </div>
            </div>
        </div>
    </div>



    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/funcion.js"></script>

    <script type="text/javascript" charset="utf-8" src="assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="assets/js/jquery-ui.min.js"></script>

    <script>
        var idEscenario = <?php echo $_GET['idEscenario'] ?>;
        console.log('idEscenario', idEscenario);
        $(document).ready(function() {

            $("#escenario option[value=" + idEscenario + "]").attr("selected", true);
            const grupos = document.getElementById('grupos');
            const usuarios = document.getElementById('usuarios');

            usuarios.addEventListener('dragstart', e => {
                e.dataTransfer.setData('id', e.target.id);
                console.log('usuario', e.target.id);
            });

            grupos.addEventListener('dragend', e => {
                // e.dataTransfer.setData('id', e.target.id);
                //console.log('usuario', e.target.id);
            });

            grupos.addEventListener('dragover', e => {
                e.preventDefault();
                //e.target.classList.add('hover');
            });
            grupos.addEventListener('dragleave', e => {
                //e.target.classList.remove('hover');

            });

            grupos.addEventListener('drop', e => {
                //e.target.classList.remove('hover');
                const user = parseInt(e.dataTransfer.getData('id'));
                var tipo = e.target.id.slice(0, 2);
                console.log(e.dataTransfer, tipo);
                var tip = document.getElementById(user);

                console.log('estado', tip.dataset.estado, user); //accede al dataset

                if (tipo == 'gr') {
                    var grupo = parseInt(e.target.id.slice(3, 6));
                    if (grupo != "") {
                        var subgrupo = 0;
                        var perfil = document.getElementById('perf_' + user).innerHTML.trim();
                        if (perfil != 'PARTICIPANTES') {
                            if (tip.dataset.estado) {
                                document.getElementById('img_' + user).remove('img');
                                document.getElementById('perf_' + user).remove('span');
                                tip.dataset.estado = 'grupo';
                            }
                            e.target.appendChild(document.getElementById(user));
                            guardarPosiciones(user, grupo, subgrupo, 'excongrupo');
                            //console.log(e.target.id);
                        } else {
                            var cant_SG = document.getElementById('cant_sgs_' + grupo).innerHTML;
                            console.log('cant subgrupos:', cant_SG);
                            if (cant_SG == 0) {
                                if (tip.dataset.estado) {
                                    document.getElementById('img_' + user).remove('img');
                                    document.getElementById('perf_' + user).remove('span');
                                    tip.dataset.estado = 'grupo';
                                }

                                e.target.appendChild(document.getElementById(user));
                                guardarPosiciones(user, grupo, subgrupo, 'excongrupo');
                            } else {
                                console.error('El participante no puede ser asignado a un grupo con subgrupos');
                            }

                        }
                    }

                } else {

                    var grupo = (e.target.id.slice(8, 11));
                    if (grupo != "") {
                        var subgrupo = parseInt(e.target.id.slice(3, 6));
                        console.log(grupo, subgrupo);
                        document.getElementById('img_' + user).remove('img');
                        document.getElementById('perf_' + user).remove('span');
                        e.target.appendChild(document.getElementById(user));
                        guardarPosiciones(user, grupo, subgrupo, 'otro');
                    }

                }
            });

            function guardarPosiciones(us, gr, sg, tipo) {
                console.log(us, gr, sg, tipo);
                //if (tipo == 'otro') {
                // var divs = document.getElementById(gr).getElementsByClassName("drop__card").length;
                // $('#cant_usr_' + gr).html('<h2>' + divs + "</h2>");

                var datos = {
                    usuario: us,
                    grupo: gr,
                    subgrupo: sg
                };

                /* } else {
                var divs = document.getElementById(gr).getElementsByClassName("drop__card").length;
                $('#cant_usr_' + grupo).html('<h2>' + divs + "</h2>");
                var datos = {
                    usuario: us,
                    grupo: grupo,
                    subgrupo: id_grupo
                };
                console.log('Subgrupo', us, grupo, id_grupo); */

                /* } else {
                    console.log('entra al if guarda')
                    var divs = document.getElementById(gr).getElementsByClassName("drop__card").length;
                    $('#cant_usr_' + gr).html('<h2>' + divs + "</h2>");
                    var id_grupo = gr.split('-')[1];
                    var datos = {
                        usuario: us,
                        grupo: id_grupo,
                        subgrupo: 0
                    };
                    console.log('EXCON grupo', us, id_grupo); */
                //}

                $.ajax({
                    url: 'valida.php?accion=guarda',
                    method: 'POST',
                    dataType: 'text',
                    data: datos,
                    success: function(response) {
                        console.log(response);
                        $('#alerta').fadeIn();
                        setTimeout(function() {
                            $("#alerta").fadeOut();
                        }, 2000);
                    }
                });

            }
        });
    </script>

</body>

</html>