<?php

namespace PHPMaker2021\simexamerica;

// Page object
$EditGrupos = &$Page;
?>
<?php

$_SESSION['id_user'] = CurrentUserID();

?>


<style>
    .timeline-comment-box {
        background: #f2f3f4;
        margin-left: -10px;
        margin-right: -10px;
        padding: 10px 25px
    }

    .timeline-comment-box .user {
        float: left;
        width: 34px;
        height: 34px;
        overflow: hidden;
        border-radius: 30px
    }

    .timeline-comment-box .user img {
        max-width: 100%;
        max-height: 100%
    }

    .timeline-comment-box .user+.input {
        margin-left: 44px
    }

    .comment-text {
        font-size: 12px
    }
    .textarealine {
        overflow: auto;
        width: 100%;
        resize: inline;
    }
</style>

<!-- librerias adicionales -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

<div class="container-fluid">
    <div class="card" id="vue-chat">

        <div class="card-header bg-success">
            <h3 class="card-title"><?php echo $Language->phrase( "mensajesEd"); ?></h3>
            <input type="text" class="form-control float-right" id="buscador" placeholder="Buscar">
        </div>

        <!-- /.card-header -->
        <div class="card-body" >
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messageddds">
                <!-- Message. Default to the left -->
                <div class="container" v-for="mens in mensajes" v-if="mens.visible">
                    <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{mens.nombre_usuario}}</span>
                                    <span class="direct-chat-timestamp float-right">
                                        <i class='far fa-clock text-primary'></i> 
                                        <?php echo $Language->phrase( "horaReal"); ?>
 {{mens.fstar}} <br> 
                                        <i class='far fa-clock text-info'></i> 
                                        <?php echo $Language->phrase( "horaSimulada"); ?>  {{mens.fstarsim}} 
                                    </span>
                                   </div>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text" style="background-color:#f2f3f4">

                    <div class = "header">
                        <h4> {{mens.titulo_mensaje}} </h4> 
                        <span>{{mens.titulo_tarea}}</span>
                        <div> 
                            <hr>
                            <span v-html="mens.mensaje"></span>
                            <hr>
                            <div class="timeline-footer">
                                <a href="javascript:;" class="m-r-15 text-inverse-lighter">
                                    <i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i>  <?php echo $Language->phrase( "meGusta"); ?>
                                </a>
                                <a class="m-r-15 text-inverse-lighter" title="" data-caption="Enviar" href="/homesimex/Email2Add?Idrenviar=71" data-original-title="Enviar">
                                <?php echo $Language->phrase( "reenviarE"); ?>&nbsp;<i class="fas fa-sign-out-alt"></i> 
                                </a>
                                <a href="javascript:;" class="m-r-15 text-inverse-lighter">
                                    <i class="fa fa-comments fa-fw fa-lg m-r-3"></i> <?php echo $Language->phrase( "comentario1"); ?>
                                </a> 
                                <a type="button" class="m-r-15 text-inverse-lighter" data-toggle="collapse" v-bind:href="'#collapse'+mens.id" >
                                    <i class="fa fa-comments fa-fw fa-lg m-r-3"></i> <?php echo $Language->phrase( "comentario2"); ?>
                                </a> 
                            </div>
            
                            <div class="collapse" v-bind:id="'collapse'+mens.id">
                                <div class="timeline-comment-box">
                                    <div class="user">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                                    </div>
                                    <div class="input">
                                        <div class="input-group">
                                            <textarea type="text" class="textarealine" v-model="mens.entrada"></textarea>
                                        </div>
                                        <div class="mt-2 text-right">
                                            <button class="btn btn-primary btn-sm shadow-none" v-on:click="hacerComentario(mens)" type="button"><?php echo $Language->phrase( "envioEd"); ?>
                                        </div>
                                        <hr>       
                                        <div v-for="coment in mens.comentarios">   
                                            <span>
                                                <em> {{coment.nombre}} </em>
                                            </span>
                                            <span class="float-right">
                                                {{coment.hora}}
                                            </span>
                                                

                                            <div class="timeline-content">  
                                                <p class="comment-text" >
                                                    <small>{{coment.texto}}</small>
                                                </p>
                                            </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>

<script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.29.9.js"></script>
<script src="inject/pubnub.js"></script>
  
<script type="text/javascript">
    var app = new Vue({
        el: '#vue-chat',
        data: {
            mensajes: []
        },
        methods:{
            hacerComentario: function(mensaje){
                if(mensaje.entrada == ""){
                    return;
                }
                $.ajax({
                    url: "inject/guardar_comentario.php",
                    type: "POST",
                    data: {
                        "idMensaje":mensaje.id,
                        "idUser": <?php echo CurrentUserID(); ?> ,
                        "comentario":mensaje.entrada
                    },
                    success: function (es) {
                        let respuesta = JSON.parse(es)[0];
                        pubnub.enviarMensaje({
                            "id":respuesta.id
                        });
                        
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
                mensaje.entrada = "";
            }
        }
    });

    var publishKey = 'pub-c-74306dc6-f082-4bc8-9e59-18804033f25d';
    var subscribeKey = 'sub-c-834f0024-caec-11eb-bdc5-4e51a9db8267';

    var pubnub = new CanalPub("canal-01",publishKey,subscribeKey);
    var pubnubAdmin = new CanalPub("canal-02",publishKey,subscribeKey);
    pubnub.mensajeLlegado = llegadaComentario;
    pubnubAdmin.mensajeLlegado = llegandoMensaje;

    function llegadaComentario(msg){
        let comentario = msg.message;
        console.log(comentario);
        $.ajax({
            url: "inject/comentario.php?idComentario="+comentario.id,
            success: function (es) {
                let respuesta = JSON.parse(es)[0];
                for(let i = 0;i < app.mensajes.length;i++){
                    if(app.mensajes[i].id == respuesta.idMensaje){
                        let add = {
                            "nombre":respuesta.nombre,
                            "hora":respuesta.hora,
                            "texto":respuesta.mensaje
                        };
                        app.mensajes[i].comentarios.push(add);
                    }
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function obtenerComentariosVarios(comentarios,id){
        $.ajax({
            url: "inject/obtener_comentarios.php?idMensaje="+id,
            success: function (es) {
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                    let res = respuesta[i];
                    let add = {
                        "nombre":res.nombre,
                        "hora":res.hora,
                        "texto":res.mensaje
                    };
                    comentarios.push(add);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function llegandoMensaje(msg){
        let code = msg.message.code;
        for(let i = 0;i < app.mensajes.length;i++){
            if(app.mensajes[i].id == code){
                return;
            }
        }
        $.ajax({
            url: "inject/pedir_mensajecliente.php?idMensaje="+code,
            success: function (es) {
                let ayuda = JSON.parse(es);
                if(ayuda.length == 0){
                    return;
                }
                let respuesta = ayuda[0];
                respuesta.numero_comentarios = 0;
                respuesta.comentarios = [];
                respuesta.entrada = "";
                respuesta.visible = true;
                app.mensajes.push(respuesta);
                obtenerComentariosVarios(respuesta.comentarios,respuesta.id);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function obtenerMensajesEnviados(){
        $.ajax({
            url: "inject/enviadoscliente.php",
            success: function (es) {
                let respuesta = JSON.parse(es);
                console.log(respuesta);
                for(let i = 0;i < respuesta.length;i++){
                    let mens = respuesta[i];
                    mens.numero_comentarios = 0;
                    mens.comentarios = [];
                    mens.entrada = "";
                    mens.visible = true;
                    app.mensajes.push(mens);
                    obtenerComentariosVarios(mens.comentarios,mens.id);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    $(document).ready(function(){
        $("#buscador").on('keyup', function() {
            let val = $("#buscador").val();
            for(let i = 0;i < app.mensajes.length;i++){
                let mens = app.mensajes[i];
                mens.visible = false;
                if(mens.titulo_mensaje.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }
                if(mens.titulo_tarea.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }
                if(mens.mensaje.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }
            }
        });
        obtenerMensajesEnviados();
    });
</script>

<?= GetDebugMessage() ?>
