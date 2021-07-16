<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TimelineGeneral = &$Page;
?>
<html>

<head>
    <title>Timeline General</title>

    <style>
        .vis-item .vis-item-overflow {
            overflow: visible;
        }

        textarea {
            width: 800px;
            height: 200px;
        }

        .buttons {
            margin: 20px 0;
        }

        .buttons input {
            padding: 10px;
        }

        .stars-outer {
            display: inline-block;
            position: relative;
            font-family: FontAwesome;
        }

        .stars-outer::before {
            content: "\f006 \f006 \f006 \f006 \f006";
        }

        .stars-inner {
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
        }

        .stars-inner::before {
            content: "\f005 \f005 \f005 \f005 \f005";
            color: #f8ce0b;
        }

        .disableddiv {
            pointer-events: none;
            opacity: 0.4;
            cursor: default;
        }

        .enableddiv {
            pointer-events: auto;
            opacity: 1;
            cursor: auto;
        }

        select option {
            background-color: #fff;
            color: #000;
        }

        options {
            background-color: white;

        }

        .vis-custom-time {
            pointer-events: none;
        }
    </style>

    <!-- <script type="text/javascript" src="//unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script> -->
    <script src="js/vis-timeline-graph2d.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="//unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- MultiSelect Include the plugin's CSS and JS: -->
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css" />
    <!--   <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" /> -->

</head>

<body>
    <?php $sql_utc = ExecuteRow("SELECT p.gmt, e.fechaini_simulado, e.fechafin_simulado, e.id_escenario FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario WHERE e.estado IN ('1')");

    $sqlGrupos = ExecuteRows("SELECT id_grupo AS id, nombre_grupo AS grupo FROM grupo g INNER JOIN escenario e ON g.id_escenario = e.id_escenario     WHERE e.estado = '1';");

    $sqlTareas = ExecuteRows("SELECT t.id_tarea,t.titulo_tarea FROM tareas t WHERE t.id_escenario = '" . $sql_utc['id_escenario'] . "';");
    $sql_escnrio = ExecuteRows("SELECT e.id_escenario, e.nombre_escenario FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario ");
    $sqlPara = ExecuteRows("SELECT * FROM view_from;");
    $sqlArchivo = ExecuteRows("SELECT id_file, file_name FROM view_user_msg WHERE id_usuario IN (SELECT id_users FROM users WHERE grupo IN (SELECT u.grupo from users u WHERE u.id_users ='" . $idUser . "'))");
    $sqlActores = ExecuteRows("SELECT * FROM actor_simulado");
    // echo "usuario: " . $idUser;
    $_SESSION['id_user'] = CurrentUserID();
    $_SESSION['id_escenario'] = $sql_utc['id_escenario'];
    // echo "id_escenario: " . $_SESSION['id_escenario'];
    ?>

    <div class="buttons">
        <input type="button" id="load" value="&darr; Load" style="display:none">
        <!-- <input type="button" id="save" value="&uarr; Save" title="Save data from the Timeline into the textarea"> -->
        <button type="button" id="save" class="btn btn-secondary" disabled>Grabar</button>
        <!-- <button type="button" id="addTarea" class="btn btn-primary" onclick="$('#modalAddTarea').modal('show');">Nueva Tarea</button> -->
        <select id="escenario" name="escenario" class="form-control-sm">
            <option value="0">Seleccione Escenario...</option>";
            <?php
            foreach ($sql_escnrio as $valor) {
                echo "<option value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
            }
            ?>
        </select>
    </div>

    <!-- <div class="toast position-fixed bottom-100 end-300 p-5" style="z-index: 5" aria-atomic="true"> -->
    <div class="toast position-fixed bottom-10" role="alert" aria-live="assertive" data-delay="2000">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" data-delay="2000">
            <div class="toast-header bg-success text-white">
                <small>Datos almacenados</small>
            </div>
            <div class="toast-body bg-success text-white">
                Datos almacenados Ok
            </div>
        </div>
    </div>

    <div id="loading">loading...</div>
    <div id="visualization"></div>
    <em> Presione CTRL + rueda del mouse para hacer zoom </em>
    <!-- Modal1 -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLongTitle">Editar Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="dts_notifica.php?accion=saveItemMsj" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" hidden>
                            <input type="text" class="form-control" id="tipo" hidden>
                            <input type="text" class="form-control" id="id_tarea" hidden>
                            <label for="tituloT">Titulo: </label>
                            <h3>
                                <div id="tituloT"> </div>
                                </hr>

                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="desc_tarea">Descripción </label>
                            <!-- <textarea class="form-control" id="desc_tarea" rows="3"></textarea> -->
                            <em>
                                <div id="desc_tarea"></div><em>
                        </div>
                        <hr>
                        <ul id="ulmjs">
                            <li> <strong>Hora real inicial:</strong> <span id="fechainireal_tarea"> </span></li>
                            <li> <strong>hora real final:</strong> <span id="fechafin_tarea"> </span></li>
                            <li><strong>Hora simulada inicial: </strong><span id="fechainisimulado_tarea"> </span></li>
                            <li><strong>Hora simulada final:</strong> <span id="fechafinsimulado_tarea"> </span> </li>
                        </ul>
                        <div class="modal-footer">
                            <button type="button" id="btnAddMensaje" onclick="modalAddMsj();" data-dismiss="modal2" class="btn btn-info btn-sm mr-auto">Crear Mensaje</button>

                            <select id="valorar" class="form-control-sm" name="valorar">
                                <option value="0" selected>Valorar...</option>
                                <option value="1" style="background-color:white">Pendiente</option>
                                <option value="3" style="background-color:white">A evaluar</option>
                                <option value="2" style="background-color:white">Complido</option>
                            </select>
                            <button type="button" id="editMsg" onclick="v_modalEditMensaje()" class="btn btn-info btn-sm">Editar Mensaje</button>
                            <button type="button" id="submint" onclick="saveMsj()" class="btn btn-primary btn-sm">Guardar</button>
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancelar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Mensajes-->
    <div class="modal fade" id="modalEditMensaje" tabindex="-1" role="dialog" aria-labelledby="modalEditMensajeTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="e_modalLongTitle">Editar Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="e_datosMensaje" action="dts_notifica.php?accion=editMensaje" method="post">

                        <div class="container">

                            <input type="hidden" class="form-control-sm" id="id_inyect" name="id_inyect">
                            <input type="hidden" class="form-control-sm" id="e_id_tarea" name="e_id_tarea">

                            <div class="form-group">
                                <label for="titulo">Titulo </label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título Mensaje" value="" required>
                            </div>

                            <label for="mensaje">Mensaje </label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="2"></textarea>
                            <!-- <div id="e_mensaje" name="e_mensaje" class="border" contenteditable="true"></div> -->

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="fechareal_start">Fecha Inicio Real</label>
                                        <input type="text" class="form-control" id="fechareal_start" name="fechareal_start">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="fechasim_start">Fecha Inicial Simulada</label>
                                        <input type="text" class="form-control" id="fechasim_start" name="fechasim_start">
                                    </div>
                                </div>
                            </div>


                            <!-- <label for="idGrupo">Id Grupo </label>
                            <select name="e_idGrupo" id="e_idGrupo" class="form-control">
                                <option selected value="">Seleccione Grupo...</option>
                                <?php
                                /* foreach ($sqlGrupos as $valor) {
                                    echo "<option value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                } */
                                ?>

                            </select> -->
                            <div class="form-group">
                                <label for="medios"> Medio</label>
                                <select id="medios" name="medios" class="form-control" required="">
                                    <option style="background-color:white" value="">Seleccione Medio...</option>
                                    <option style="background-color:white" value="1">Email</option>
                                    <option style="background-color:white" value="2">Daybook</option>
                                    <option style="background-color:white" value="3">Chirping</option>
                                </select>
                                <div>
                                    <div class="form-group">
                                        <label for="actividad_esperada">Actividad Esperada</label>
                                        <textarea class="form-control" id="actividad_esperada" name="actividad_esperada" rows="2"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">

                                            <div class="form-group">
                                                <label for="id_actor">De:</label>
                                                <select id="id_actor" name="id_actor" class="form-control">
                                                    <?php
                                                    foreach ($sqlActores as $valor) {
                                                        echo "<option  style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="adjunto">Subir Archivo</label>
                                                <select id="adjunto" name="adjunto" class="form-control">
                                                    <option value="0">Seleccione Adjunto...</option>";
                                                    <?php
                                                    foreach ($sqlArchivo as $valor) {
                                                        echo "<option  style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Build your select: -->
                                            <div class="form-group">
                                                <label for="para">Para:</label>
                                                <select id="para" name="para[]" multiple="multiple" class="form-control">
                                                    <?php
                                                    foreach ($sqlPara as $valor) {
                                                        echo "<option style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </diV>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-sm" onclick="editMensajeBD()">Guardar</button>
                                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancelar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!--MODAL AÑADIR MENSAJE-->
    <div class="modal fade" id="modalAddMensajes" tabindex="-1" role="dialog" aria-labelledby="modalAddMensajes" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="e_modalLongTitle">Editar Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="e_datosMensaje" action="dts_notifica.php?accion=editMensaje" method="post">

                        <div class="container">

                            <input type="hidden" class="form-control-sm" id="id_inyect" name="id_inyect">
                            <input type="hidden" class="form-control-sm" id="e_id_tarea" name="e_id_tarea">

                            <div class="form-group">
                                <label for="titulo">Titulo </label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título Mensaje" value="" required>
                            </div>

                            <label for="mensaje">Mensaje </label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="2"></textarea>
                            <!-- <div id="e_mensaje" name="e_mensaje" class="border" contenteditable="true"></div> -->

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="fechareal_start">Fecha Inicio Real</label>
                                        <input type="text" class="form-control" id="fechareal_start" name="fechareal_start">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="fechasim_start">Fecha Inicial Simulada</label>
                                        <input type="text" class="form-control" id="fechasim_start" name="fechasim_start">
                                    </div>
                                </div>
                            </div>


                            <!-- <label for="idGrupo">Id Grupo </label>
                            <select name="e_idGrupo" id="e_idGrupo" class="form-control">
                                <option selected value="">Seleccione Grupo...</option>
                                <?php
                                /* foreach ($sqlGrupos as $valor) {
                                    echo "<option value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                } */
                                ?>

                            </select> -->
                            <div class="form-group">
                                <label for="medios"> Medio</label>
                                <select id="medios" name="medios" class="form-control" required="">
                                    <option style="background-color:white" value="">Seleccione Medio...</option>
                                    <option style="background-color:white" value="1">Email</option>
                                    <option style="background-color:white" value="2">Daybook</option>
                                    <option style="background-color:white" value="3">Chirping</option>
                                </select>
                                <div>
                                    <div class="form-group">
                                        <label for="actividad_esperada">Actividad Esperada</label>
                                        <textarea class="form-control" id="actividad_esperada" name="actividad_esperada" rows="2"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">

                                            <div class="form-group">
                                                <label for="id_actor">De:</label>
                                                <select id="id_actor" name="id_actor" class="form-control">
                                                    <?php
                                                    foreach ($sqlActores as $valor) {
                                                        echo "<option  style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="adjunto">Subir Archivo</label>
                                                <select id="adjunto" name="adjunto" class="form-control">
                                                    <option value="0">Seleccione Adjunto...</option>";
                                                    <?php
                                                    foreach ($sqlArchivo as $valor) {
                                                        echo "<option  style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Build your select: -->
                                            <div class="form-group">
                                                <label for="para">Para:</label>
                                                <select id="para" name="para[]" multiple="multiple" class="form-control">
                                                    <?php
                                                    foreach ($sqlPara as $valor) {
                                                        echo "<option style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </diV>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-sm" onclick="editMensajeBD()">Guardar</button>
                                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancelar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Add Mensajes-->
    <div class="modal fade" id="modalAddMensajeF" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLongTitle">Nuevo Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="datosMensaje" action="dts_notifica.php?accion=addMensaje" method="post">

                        <div class="container">

                            <input type="hidden" class="form-control-sm" id="idTarea" name="idTarea">

                            <div class="form-group">
                                <label for="titleMnsje">Titulo </label>
                                <input type="text" class="form-control" id="titleMnsje" name="titleMnsje" placeholder="Título Mensaje" value="" required>
                            </div>

                            <label for="mensaje">Mensaje </label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="2"></textarea>
                            <!-- <div id="mensaje" name="mensaje" class="border" contenteditable="true"></div> -->

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="fechaIniRealMjs">Fecha Inicio Real</label>
                                        <input type="text" class="form-control" id="fechaIniReal" name="fechaIniReal">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="fechaIniSimMjs">Fecha Inicial Simulada</label>
                                        <input type="text" class="form-control" id="fechaIniSimMjs" name="fechaIniSimMjs">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="medio"> Medio</label>
                                <select id="medio" name="medio" class="form-control" required="">
                                    <option style="background-color:white" value="">Seleccione Medio...</option>
                                    <option style="background-color:white" value="1">Email</option>
                                    <option style="background-color:white" value="2">Daybook</option>
                                    <option style="background-color:white" value="3">Chirping</option>
                                </select>
                                <div>
                                    <div class="form-group">
                                        <label for="actividad">Actividad Esperada</label>
                                        <textarea class="form-control" id="actividad" name="actividad" rows="2"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">

                                            <div class="form-group">
                                                <label for="actor">De:</label>
                                                <select id="actor" name="actor" class="form-control">
                                                    <?php
                                                    foreach ($sqlActores as $valor) {
                                                        echo "<option  style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="archivo">Subir Archivo</label>
                                                <select id="archivo" name="archivo" class="form-control">
                                                    <option value="0">Seleccione Adjunto...</option>";
                                                    <?php
                                                    foreach ($sqlArchivo as $valor) {
                                                        echo "<option  style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Build your select: -->
                                            <div class="form-group">
                                                <label for="para">Para:</label>
                                                <select id="para" name="para[]" multiple="multiple" class="form-control">
                                                    <?php
                                                    foreach ($sqlPara as $valor) {
                                                        echo "<option style=\"background-color:white\" value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </diV>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addMensaje()">Guardar</button>
                                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancelar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- ModalAddTarea -->
    <div id="modalAddTarea" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width:100%; height: 400px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-tittle">Crear Tarea</h4>
                </div>
                <form action="dts_notifica.php?accion=addTarea" method="post">
                    <form action="" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" id="idTarea" hidden>
                            <label for="idGrupo">Grupo</label>
                            <select name="idGrupo" id="idGrupo" class="form-control">
                                <option selected value="">Seleccione Grupo...</option>
                                <?php
                                foreach ($sqlGrupos as $valor) {
                                    echo "<option value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="titleTarea">Titulo </label>
                            <input type="text" class="form-control" id="titleTarea" placeholder="Título Tarea" value="">
                        </div>
                        <div class="form-group">
                            <label for="descTarea">Descripción </label>
                            <textarea class="form-control" id="desc_tarea" rows="3"></textarea>
                            <!--
                            <div id="descTarea" class="border" contenteditable="true">
                            </div>-->
                        </div>
                        <div class="form-group">
                            <label for="fechaIniReal" class="col-md-2 control-label">Fecha Inicio Real</label>
                            <input type="text" class="form-control" id="fechaIniReal">
                        </div>
                        <div class="form-group mb-2">
                            <label for="fechaFinReal" class="col-md-2 control-label">Fecha Fin Real</label>
                            <input type="text" class="form-control" id="fechaFinReal">
                        </div>

                        <div class="form-group">
                            <label for="fechaIniSim">Fecha Inicio Simulado</label>
                            <input type="text" class="form-control" id="fechaIniSim">
                        </div>
                        <div class="form-group">
                            <label for="fechaFinSim">Fecha Fin Simulado</label>
                            <input type="text" class="form-control" id="fechaFinSim">
                        </div>
                        <div class="form-group">
                            <label for="idTareaRelacion">Relación Tarea</label>
                            <select id="idTareaRelacion" class="form-control">
                                <option value="">Tareas...</option>
                                <?php
                                foreach ($sqlTareas as $valor) {
                                    echo "<option value=\"" . $valor[0] . "\">" . $valor[1] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="archivo">Subir Archivo</label>
                            <input type="file" class="form-control" id="archivo">
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="addTarea()" class="btn btn-primary btn-sm">Guardar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var btnLoad = document.getElementById('load');
        var btnSave = document.getElementById('save');

        let utc = '<?php echo $sql_utc[0] ?>';
        let hora = utc.slice(4, 10);
        let fechaIniSimulado = '<?php echo $sql_utc['fechaini_simulado'] ?>';
        let fechaFinSimulado = '<?php echo $sql_utc['fechafin_simulado'] ?>';
        let data_json;
        let idEscnrio = <?php echo $sql_utc['id_escenario'] ?>;
        $('#escenario').change(function() {
            idEscnrio = $('#escenario').val();
            $.ajax({

                url: "dts_notifica.php?accion=getEscenario&idEscnrio=" + idEscnrio,
                success: function(data) {
                    if (data != "sinRegistros") { //console.log('escenario', data);
                        var escenario = JSON.parse(data);
                        console.log('Escenario', data)
                        utc = escenario[0].gmt;
                        hora = utc.slice(4, 10);
                        fechaIniSimulado = escenario[0].fechaini_simulado;
                        fechaFinSimulado = escenario[0].fechafin_simulado;

                        $('#visualization').empty();
                        loadData('', idEscnrio);
                        //console.log('idEscnrio', idEscnrio);
                    } else {
                        console.error('No hay registros');
                        $('#visualization').empty();
                    }
                },
            });
        });

        function loadData(foco, esc) {
            console.log('idEscnrio', esc);
            var grupos2 = "";
            $.ajax({
                url: "dts_notifica.php?accion=loadTL&pg=Grupo&idEscenario=" + esc,
                success: function(data) {
                    if (data == 'baduser') {
                        alert("Usuario Maestro, inicie sesión con usuario de la BD");
                    } else {
                        document.getElementById("loading").style.display = "none";
                        var container = document.getElementById("visualization");
                        // Create a DataSet (allows two way data-binding)
                        //var datos = JSON.stringify(data);
                        var customDate = new Date(fechaIniSimulado);

                        items = new vis.DataSet(data);
                        data_json = data;

                        console.log('data', data);
                        // Configuration for the Timeline   
                        const getGrupos = (grupo, url) => new Promise((resolve, reject) => {
                            const grupos = grupo;
                            $.ajax({
                                url: "dts_notifica.php?accion=loadGruposTL&idEscenario=" + esc + "&pg=''",
                                async: false,
                                success: function(grupo) {
                                    grupos2 = grupo;
                                    //resolve(grupo);
                                    console.log('grupo', grupo)
                                },
                                error: (err) => {
                                    reject(err);
                                }

                            });
                        });
                        getGrupos()
                            .then(datoGrupo => {
                                // codigo que quieras usando datoUsuario
                                //console.log('grupos1', grupos);
                                grupos2 = datoGrupo;
                            })
                            .catch(err => {
                                // manejo del posible error, en caso que falle el ajax
                                console.log(err);
                            });
                        console.log('grupos2', grupos2);
                        options = {
                            editable: {
                                add: false, // add new items by double tapping
                                updateTime: true, // drag items horizontally
                                updateGroup: false, // drag items from one group to another
                                remove: false, // delete an item by tapping the delete button top right
                                overrideItems: false, // allow these options to override item.editable
                            },
                            onMove: function(item, callback) {
                                $('#save').removeClass('btn btn-secondary');
                                $("#save").prop('disabled', false);
                                $('#save').addClass('btn btn-success');
                                callback(item); // send back adjusted item

                            },
                            moment: function(date) {
                                return vis.moment(date).utcOffset(hora)
                            },
                            start: fechaIniSimulado,
                            end: fechaFinSimulado, //new Date(new Date().getTime() + 100000),

                            horizontalScroll: true,
                            zoomKey: "ctrlKey",

                            rollingMode: {
                                follow: true,
                                offset: 0.5,
                            },
                            width: '100%',
                            height: '500px',
                            margin: {
                                item: 20
                            },
                            /* timeAxis: {
                                scale: 'hour',
                                step: 1
                            } */
                            align: "left",
                        };
                        // Create a Timeline
                        var timeline = new vis.Timeline(container, items, grupos2, options);
                        if (foco != "") {
                            timeline.focus(foco);
                        }
                        var id1 = "id1";
                        var id2 = "id2";
                        timeline.addCustomTime(new Date(fechaIniSimulado), id1);
                        timeline.setCustomTimeMarker("Fecha Inicio<br>" + fechaIniSimulado.slice(0, 16), id1, false);
                        timeline.addCustomTime(new Date(fechaFinSimulado), id2);
                        timeline.setCustomTimeMarker("Fecha Fin<br>" + fechaFinSimulado.slice(0, 16), id2, false);

                        timeline.on('doubleClick', function(properties) {
                            var id = properties.item;
                            //console.log(properties);
                            if (id != null) {
                                id = id.slice(2);
                                var tipo = properties.item.slice(0, 1);

                                var parametros = {
                                    "id": id,
                                    "tipo": tipo,
                                };

                                $('#exampleModalCenter').modal('show');
                                $.ajax({
                                    url: "dts_notifica.php?accion=loadItemMsj",
                                    data: parametros,
                                    type: 'post',
                                    success: function(data) {
                                        //data = JSON.stringify(data);
                                        console.log('dataDbClk', data);
                                        $('#id').val(id);

                                        $('#tipo').val(tipo);
                                        $('#tituloT').html(data[0].titulo);
                                        $('#desc_tarea').html(data[0].descripcion);
                                        $('#fechainireal_tarea').html(data[0].fechainireal_tarea);
                                        $('#fechafin_tarea').html(data[0].fechafin_tarea);
                                        $('#fechainisimulado_tarea').html(data[0].fechainisimulado_tarea);
                                        $('#fechafinsimulado_tarea').html(data[0].fechafinsimulado_tarea);
                                        if (tipo == 'M') {
                                            $('#id_tarea').val(data[0].id_tarea);
                                            $('#modalLongTitle').html("Mensaje");
                                            $('#valorar').hide();
                                            $('#btnAddMensaje').hide();
                                            $('#ulmjs').hide();
                                            // $('#submint').hide();

                                            if (parseInt(data[0].enviado) != 1) {
                                                $('#tituloT').prop('readonly', false);

                                                console.log('enviado', data[0].enviado);
                                            } else {

                                                $('#tituloT').prop('readonly', true);

                                                $('#desc_tarea').addClass('disableddiv');
                                            }

                                        } else {
                                            $('#modalLongTitle').html("Tarea");
                                            $('#idTarea').val(id);
                                            $('#valorar').show();
                                            $('#btnAddMensaje').show();
                                            $('#valorar option[value=' + data.valora + ']').attr("selected", true);
                                            $('#tituloT').prop('readonly', true);
                                            //  $('#desc_tarea').addClass('disableddiv');
                                        }

                                    },
                                });
                            }
                        });
                    }
                },
                error: function(err) {
                    console.log("Error", err);
                    if (err.status === 0) {
                        alert(
                            "Fallo al abrir JSON ."
                        );
                    } else {
                        alert("No se pudo abrir JSON .");
                    }
                },
            });
            // ####### HASTA ACÁ ####### 


        }
        //btnLoad.onclick = loadData;     

        function saveMsj() { //graba datos del item desde la modal
            id = $('#id').val();
            tipo = $('#tipo').val();
            titulo = $('#tituloT').val();
            //desc = $('#desc_tarea').val();            
            desc = $('#desc_tarea').html();
            valorar = $('#valorar').val();
            if (valorar != '0') {
                color = 'green';
            } else {
                color = 'blue';
            }
            parametros = {
                "id": id,
                "tipo": tipo,
                /* "titulo": titulo,
                "desc": desc, */
                "valorar": valorar,
                "color": color
            }
            console.log('parametros', parametros);
            $.ajax({
                url: "dts_notifica.php?accion=saveItemMsj",
                data: parametros,
                type: 'post',
                success: function(data) {
                    if (data == 'ok') {
                        $('#exampleModalCenter').modal('hide');
                        $('.toast').toast('show');
                        $('#visualization').empty();
                        console.log("id-foco", tipo + ':' + id);
                        loadData(tipo + ':' + id, idEscnrio);
                        $('#modalAddTarea').modal('hide');

                    }
                }
            });
        }

        function saveData() {

            var datos = items.get({
                type: {
                    start: 'String',
                    end: 'String'
                }
            });
            //console.log("datos:", datos);

            for (let i = 0; i < datos.length; i++) {
                fechaIni = +new Date(datos[i].start);
                const timestamp = Math.floor(fechaIni);
                var MyDate = new Date(timestamp);
                var year = MyDate.getFullYear();
                var month = "0" + (MyDate.getMonth() + 1);
                var day = "0" + MyDate.getDate();
                var hours = "0" + MyDate.getHours();
                var minutes = "0" + MyDate.getMinutes();
                var seconds = "0" + MyDate.getSeconds();
                var fechaIni = year + '-' + month.substr(-2) + '-' + day.substr(-2) + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

                if (datos[i].end != "") {
                    fechaFn = +new Date(datos[i].end);
                    const timestamp = Math.floor(fechaFn);
                    var MyDate = new Date(timestamp);
                    var year = MyDate.getFullYear();
                    var month = "0" + (MyDate.getMonth() + 1);
                    var day = "0" + MyDate.getDate();
                    var hours = "0" + MyDate.getHours();
                    var minutes = "0" + MyDate.getMinutes();
                    var seconds = "0" + MyDate.getSeconds();
                    var fechaFn = year + '-' + month.substr(-2) + '-' + day.substr(-2) + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                }
                if ((datos[i].id.slice(0, 1) != 'T') || (datos[i].id.slice(0, 1) != 'M')) {
                    id = datos[i].id.slice(2);
                } else {
                    id = datos[i].id;
                }

                var itemss = {
                    id: id,
                    content: datos[i].content,
                    start: fechaIni,
                    end: fechaFn
                }

                $.ajax({
                    type: "POST", // la variable type guarda el tipo de la peticion GET,POST,..
                    url: "dts_notifica.php?accion=saveTL", //url guarda la ruta hacia donde se hace la peticion
                    data: itemss, // data recive un objeto con la informacion que se enviara al servidor
                    success: function(data) { //success es una funcion que se utiliza si el servidor retorna informacion
                        //console.log('data:', data);
                        $('#save').removeClass('btn btn-success');
                        $("#save").prop('disabled', true);
                        $('#save').addClass('btn btn-secondary');
                        $('.toast').toast('show');

                    },
                });
                //console.log('item', item);
            }
        }
        btnSave.onclick = saveData;

        function v_modalEditMensaje() {
            var id = $('#id').val();
            var tipo = $('#tipo').val();
            $('#modalEditMensaje').modal('show');

            var parametros = {
                "id": id,
                "tipo": tipo,
            };
            // console.log('parametros', parametros);
            $.ajax({
                url: "dts_notifica.php?accion=loadItemMsj",
                data: parametros,
                type: 'post',
                success: function(data) {
                    //data = JSON.stringify(data);
                    console.log('dataEdit', data[0].id_tarea);
                    $('#e_id_tarea').val(data[0].id_tarea);
                    $('#id_inyect').val(id);
                    $('#tipo').val(tipo);
                    $('#titulo').val(data[0].titulo);
                    $('#mensaje').val(data[0].descripcion);
                    $('#fechareal_start').val(data[0].fechareal_start);
                    $('#fechasim_start').val(data[0].fechasim_start);
                    $('#medios').val(data[0].medios);
                    $('#para').val(data[0].para);
                    $('#id_actor').val(data[0].id_actor);

                    $('#actividad_esperada').val(data[0].actividad_esperada);
                    $('#adjunto').val(data[0].adjunto);

                    $('#e_modalLongTitle').html("Mensaje");

                    // $('#submint').hide();

                    if (parseInt(data[0].enviado) != 1) {
                        $('#tituloT').prop('readonly', false);

                        console.log('enviado', data[0].enviado);
                    } else {
                        $('#tituloT').prop('readonly', true);

                        $('#desc_tarea').addClass('disableddiv');
                    }




                },
            });
        }

        function editMensajeBD() {
            //fncion para almacenar los datos en la bd  
            var parametros = $('#e_datosMensaje').serializeArray(); //.serialize();            
            console.log('parametros', parametros);
            $.ajax({
                url: "dts_notifica.php?accion=editMensaje",
                data: parametros,
                type: 'post',
                success: function(data) {
                    console.log(data);
                    if (data == 'ok') {
                        $('#modalEditMensaje').modal('hide');
                        $('#exampleModalCenter').modal('hide');
                        $('.toast').toast('show');
                        $('#visualization').empty();
                        loadData('', idEscnrio);
                    }
                }
            });
        }

        function modalMsj(t) {
            $('#modal2').modal('show');
            id = $('#id_inyect').val();
            tipo = $('#tipoMsj').val();
            $('#idMsj').val($('#id').val());
            $('#tipoMsj').val($('#tipo').val());
            $('#fecha').flatpickr({
                locale: "es",
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: fechaIniSimulado,
                maxDate: fechaFinSimulado,
                defaultDate: fechaIniSimulado,
            });

            console.log('msj', id, tipo);
        }

        function modalAddMsj() {
            $('#modalAddMensaje').modal('show');
            $('#datosMensaje')[0].reset();
            var idTarea = $('#id').val();
            $('#idTarea').val(idTarea);

        }

        // load the initial data
        loadData('', idEscnrio);
        $('#fechaIniReal').flatpickr({
            locale: "es",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: fechaIniSimulado,
            maxDate: fechaFinSimulado,
            defaultDate: fechaIniSimulado,
        });
        $('#fechaFinReal').flatpickr({
            locale: "es",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: fechaIniSimulado,
            maxDate: fechaFinSimulado,
            defaultDate: fechaFinSimulado,
        });

        function addTarea() {
            var parametros = {
                "idGrupo": $('#idGrupo').val(),
                "titleTarea": $('#titleTarea').val(),
                "descTarea": $('#descTarea').html(),
                "fechaIniReal": $('#fechaIniReal').val(),
                "fechaFinReal": $('#fechaFinReal').val(),
                "fechaIniSim": $('#fechaIniSim').val(),
                "fechaFinSim": $('#fechaFinSim').val(),
                "idTareaRelacion": $('#idTareaRelacion').val(),
                "archivo": $('#archivo').val(),
                "idEscenario": <?php echo $sql_utc['id_escenario']  ?>,
            }
            $.ajax({
                type: "POST", // la variable type guarda el tipo de la peticion GET,POST,..
                url: "dts_notifica.php?accion=addTarea", //url guarda la ruta hacia donde se hace la peticion
                data: parametros, // data recive un objeto con la informacion que se enviara al servidor
                success: function(data) { //success es una funcion que se utiliza si el servidor retorna informacion
                    console.log('tareas:', data);
                    $('#modalAddTarea').modal('hide');
                    $('.toast').toast('show');
                    $('#visualization').empty();
                    loadData();
                    //$('.toast').toast('show');

                },
            });
        }
        $(document).ready(function() {
            $('#para').multiselect({
                enableFiltering: true
            });
            $('#e_para').multiselect({
                enableFiltering: true
            });
        });

        function addMensaje() { //graba datos del item desde la modal
            var parametros = $('#datosMensaje').serializeArray(); //.serialize();            
            console.log('parametros', parametros);
            $.ajax({
                url: "dts_notifica.php?accion=addMensaje",
                data: parametros,
                type: 'post',
                success: function(data) {
                    console.log(data);
                    if (data == 'ok') {
                        $('#modalAddMensaje').modal('hide');
                        $('.toast').toast('show');
                        $('#visualization').empty();
                        loadData('', idEscnrio);
                    }
                }
            });

        }
    </script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>

<?= GetDebugMessage() ?>
