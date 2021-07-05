<?php

namespace PHPMaker2021\simexamerica;

// Page object
$InjectParticipante = &$Page;
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
    .speedup:hover {
     cursor: pointer;
     border: 1px solid #3E7DC0 !important
}
</style>

<!-- librerias adicionales -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

<div class="container-fluid">
    <div class="card" id="vue-chat">

        <div class="card-header bg-success">
            <h3 class="card-title">Mensajes</h3>
            <form id="formulario_buscador">
            <input type="text" class="form-control float-right" id="buscador" placeholder="Buscar">
</form>
        </div>

        <!-- /.card-header -->
        <div class="card-body" >
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messagess " >
                <!-- Message. Default to the left -->
                <div class="container" v-for="mens in mensajes" v-if="mens.visible">
                    <div class="direct-chat-msg ">
                    <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{mens.actor}}</span>
                                    <span class="direct-chat-timestamp float-right">
                                        <i class='far fa-clock text-primary'></i> 
                                        Hora real {{mens.fstar}} <br> 
                                        <i class='far fa-clock text-info'></i> 
                                        Hora Simulada  {{mens.fstarsim}} 
                                    </span>
                                   </div>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text speedup" style="background-color:#f2f3f4">

                    <div class = "header">
                        <h4> {{mens.titulo_mensaje}} <!--<span class="badge badge-pill badge-primary float-right">{{mens.calificacion}}</span>--></h4> 
                        <span
                                                class="float-right badge "
                                                v-bind:class="{'badge-primary': mens.calificacion == 'Pendiente', 'badge-success': mens.calificacion == 'Finalizado', 
                                                    'badge-warning': mens.calificacion == 'Inconcluso' }"
                                                >
                                                {{mens.calificacion}}
                                        </span>
                        <!--<span class="float-right badge badge-warning "> Inconpleto</span> -->
                        <!--  
                        <span
                                                class="float-right badge "
                                                v-bind:class="{'badge-primary': mens.calificacion == 'Pendiente', 'badge-success': mens.calificacion == 'Finalizado', 
                                                    'badge-warning': mens.calificacion == 'Inconcluso' }"
                                                >
                                                {{mens.calificacion}}
                                        </span> 
                        <span>{{mens.titulo_tarea}}</span> -->
                        <div> 
                            <hr>
                            <span v-html="mens.mensaje"></span>
                            <div class="stats">
                            <i class="cil-paperclip"></i> <br>
                            <a v-bind:href="'files/'+mens.filename"> {{mens.filename}}</a> 
                            <hr>
                            <a  data-toggle="collapse" href="#para" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <i class="fa fa-users"></i> 

                                            Para:</a>
                            <div class="collapse multi-collapse" id="para">
                                        <ul  v-for="destinatario in mens.destinatarios" v-if="mens.visible">
                                          <li> {{destinatario.destinatario}}.</li>
                                        </ul>
                                        </div>
                              </div>
                            <hr>
                            <div class="timeline-footer">

                                <a class="m-r-15 text-inverse-lighter" title="" data-caption="Enviar" href="/homesimex/Email2Add?Idrenviar=71" data-original-title="Enviar">
                                    Reenviar&nbsp;<i class="fas fa-sign-out-alt"></i> 
                                </a>
                                <a href="javascript:;" class="m-r-15 text-inverse-lighter">
                                    <i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Coperación
                                </a> 
                                <a type="button" class="m-r-15 text-inverse-lighter" data-toggle="collapse" v-bind:href="'#collapse'+mens.id" >
                                    <i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comentario
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
                                            <button class="btn btn-primary btn-sm shadow-none" v-on:click="hacerComentario(mens)" type="button">Envio
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
<script src="https://cdn.jsdelivr.net/npm/disableautofill@2.0.0/dist/disableautofill.min.js"></script>
<script type="text/javascript">
//Cambio
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

    var publishKey = 'pub-c-451eac62-0cee-4afa-9f20-93eb596aedfb';
    var subscribeKey = 'sub-c-5c30cc92-dbff-11eb-8c90-a639cde32e15';

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
                obtenerDestinatarios(respuesta.destinatarios,respuesta.id);
                obtenerComentariosVarios(respuesta.comentarios,respuesta.id);
                app.mensajes.push(respuesta);
                
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
                    mens.destinatarios = [];
                    mens.entrada = "";
                    mens.visible = true;
                    app.mensajes.push(mens);
                    obtenerDestinatarios(mens,mens.id);
                    obtenerComentariosVarios(mens.comentarios,mens.id);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function obtenerDestinatarios(mens,id){
        $.ajax({
            url: "inject/obtener_destinatarios.php?idMensaje="+id,
            success: function (es) {
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                    let res = respuesta[i];
                    let add = {
                        "destinatario":res.destinatario
                    };
                    mens.destinatarios.push(add);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
        console.log(mens);
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
    var daf =new disableautofill({
        'form': '#formulario_buscador'
    });
    daf.init();
</script>

<?= GetDebugMessage() ?>

<?= GetDebugMessage() ?>
