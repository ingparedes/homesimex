/**
 * seccion de pubhub
 */
function CanalPub(canal,publishKey,subscribeKey) {
    this.canal = canal;
    this.pubhub = null;
    this.publishKey = publishKey;
    this.subscribeKey = subscribeKey;
   // this.uniqueId = 'myUniqueUUID';
    this.crearCanal();
}

/**
 * constructor
 */
CanalPub.prototype.crearCanal = function () {
    this.pubnub = new PubNub({
        publishKey: this.publishKey,
        subscribeKey: this.subscribeKey,
        uuid: this.uniqueId
    });
    let arm = this;
    this.pubnub.addListener({
        status: function (statusEvent) { },
        message: function (msg) {
            arm.mensajeLlegado(msg);
        },
        presence: function (presenceEvent) {
            console.log(presenceEvent);
        }
    })
    this.pubnub.subscribe({
        channels: [this.canal]
    });
}

/**
 * llamado cuando llega un mensaje
 */
CanalPub.prototype.mensajeLlegado = function (msg) {
    console.log("no implementado");
    console.log(msg);
}

/**
 * llamar para enviar un mensaje
 */
CanalPub.prototype.enviarMensaje = function (data) {
    let publishConfig = {
        channel: this.canal,
        message: data
    }
    this.pubnub.publish(publishConfig, function (status, response) {
        if (status.statusCode != 200) {
            console.log(status, response);
        }
    });
}
