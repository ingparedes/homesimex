function notificacion(titleN, textN, iconN) {
  if (Notification) {
    if (Notification.permission !== "granted") {
      Notification.requestPermission();
    }
    var title = titleN;
    var extra = {
      icon: iconN,
      body: textN,
    };
    var noti = new Notification(title, extra);
    noti.onclick = {
      // Al hacer click
    };
    noti.onclose = {
      // Al cerrar
    };
    setTimeout(function () {
      noti.close();
    }, 10000);
  }
}

$(function () {
  var userOnline = Number($("span.user_online").attr("id"));
  var groupOnline = Number($("span.group_online").attr("id"));
  var clicou = [];

  function in_array(valor, array) {
    for (var i = 0; i < array.length; i++) {
      if (array[i] == valor) {
        return true;
      }
    }

    return false;
  }

  //agrega ventanas de chat
  function add_janela(id, nome, status) {
    var janelas = Number(jQuery("#chats .window").length);
    var pixels = (280 + 5) * janelas;
    var style =
      "float:none; position:absolute; bottom:0; left:" + pixels + "px";
    //console.log('ventanas:'+janelas);
    var splitDados = id.split(":");
    var id_user = Number(splitDados[1]);
    var janela =
      '<div class="window" id="janela_' + id_user + '" style="' + style + '">';
    janela +=
      '<div class="header_window"><a href="#" class="close">X</a> <span class="name">' +
      nome +
      '</span> <span id="' +
      id_user +
      '" class="' +
      status +
      '"></span></div>';
    janela += '<div class="body"><div class="mensagens"><ul></ul></div>';
    janela +=
      '<div class="send_message" id="' +
      id +
      '"><input type="text" name="mensagem" class="msg" id="' +
      id +
      '" /></div></div></div>';

    jQuery("#chats").append(janela);
  }

  function retorna_historico(id_conversa) {
    jQuery.ajax({
      type: "POST",
      url: "views/Historico.php",
      data: { conversacom: id_conversa, online: userOnline },
      dataType: "json",
      success: function (retorno) {
        jQuery.each(retorno, function (i, msg) {
          var texto = replaceURLWithHTMLLinks(msg.mensagem);
          //console.log(texto);
          if (jQuery("#janela_" + msg.janela_de).length > 0) {
            if (userOnline == msg.id_de) {
              jQuery("#janela_" + msg.janela_de + " .mensagens ul").append(
                '<li id="' + msg.id + '" class="eu"><p>' + texto + "</p></li>"
              );
            } else {
              jQuery("#janela_" + msg.janela_de + " .mensagens ul").append(
                '<li id="' +
                  msg.id +
                  '"><div class="imgSmall"><img src="fotos/' +
                  msg.fotoUser +
                  '" /></div><p>' +
                  texto +
                  "</p></li>"
              );
            }
          }
        });
        [].reverse
          .call(jQuery("#janela_" + id_conversa + " .mensagens li"))
          .appendTo(jQuery("#janela_" + id_conversa + " .mensagens ul"));
        jQuery("#janela_" + id_conversa + " .mensagens").animate(
          { scrollTop: 230 },
          "500"
        );
      },
    });
  }

  jQuery("body").on("click", "#users_online a", function () {
    var id = jQuery(this).attr("id");
    jQuery(this).removeClass("comecar");

    var status = jQuery(this).next().attr("class");
    var splitIds = id.split(":");
    var idJanela = Number(splitIds[1]);

    if (jQuery("#janela_" + idJanela).length == 0) {
      var nome = jQuery(this).text();
      add_janela(id, nome, status);
      retorna_historico(idJanela);
    } else {
      jQuery(this).removeClass("comecar");
    }
  });

  jQuery("body").on("click", ".header_window", function () {
    var next = jQuery(this).next();
    next.toggle(100);
  });

  jQuery("body").on("click", ".close", function () {
    var parent = jQuery(this).parent().parent();
    var idParent = parent.attr("id");
    var splitParent = idParent.split("_");
    var idJanelaFechada = Number(splitParent[1]);

    var contagem = Number(jQuery(".window").length) - 1;
    var indice = Number(jQuery(".close").index(this));
    var restamAfrente = contagem - indice;

    for (var i = 1; i <= restamAfrente; i++) {
      jQuery(".window:eq(" + (indice + i) + ")").animate(
        { left: "-=275" },
        200
      );
    }
    parent.remove();
    jQuery("#users_online li#" + idJanelaFechada + " a").addClass("comecar");
  });

  // Mensajes enviados
  jQuery("body").on("keyup", ".msg", function (e) {
    if (e.which == 13) {
      var texto = replaceURLWithHTMLLinks(jQuery(this).val());
      console.log(texto);
      var id = jQuery(this).attr("id");
      var split = id.split(":");
      var para = Number(split[1]);
      jQuery.ajax({
        type: "POST",
        url: "views/Submit.php", //Cambiar la ruta
        data: { mensagem: texto, de: userOnline, para: para },
        success: function (retorno) {
          retorno = retorno.trim();
          console.log("retorno: " + retorno);
          if (retorno == "ok") {
            jQuery(".msg").val("");
          } else {
            alert("Ocurrió un error al enviar el mensaje");
          }
        },
      });
    }
  });

  jQuery("body").on("click", ".mensagens", function () {
    var janela = jQuery(this).parent().parent();
    var janelaId = janela.attr("id");
    var idConversa = janelaId.split("_");
    idConversa = Number(idConversa[1]);

    jQuery.ajax({
      url: "sys/ler.php",
      type: "POST",
      data: { ler: "sim", online: userOnline, user: idConversa },
      success: function (retorno) {
        //console.log('ler:'+retorno);
      },
    });
  });

  function replaceURLWithHTMLLinks(text) {
    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gi;
    //console.log(text.replace(exp,"<a href='$1'>$1</a>"));
    return text.replace(exp, "<a href='$1'>$1</a>");
  }

  function verifica(timestamp, lastid, user, grupo) {
    var t;
    jQuery.ajax({
      url: "views/Stream.php",
      type: "GET",
      data:
        "timestamp=" +
        timestamp +
        "&lastid=" +
        lastid +
        "&user=" +
        user +
        "&grupo=" +
        grupo,
      dataType: "json",
      success: function (retorno) {
        //console.log("Retorno Valida:", retorno);
        clearInterval(t);
        if (retorno.status == "resultados" || retorno.status == "vazio") {
          t = setTimeout(function () {
            verifica(
              retorno.timestamp,
              retorno.lastid,
              userOnline,
              groupOnline
            );
          }, 1000);

          if (retorno.status == "resultados") {
            jQuery.each(retorno.dados, function (i, msg) {
              if (msg.id_para == userOnline) {
                notificacion(
                  "Chat SimexAmerica",
                  msg.id_de + "-" + msg.mensagem,
                  msg.icon
                );
                //console.log(msg);
                jQuery.playSound("sys/effect");
              }

              if (jQuery("#janela_" + msg.janela_de).length == 0) {
                jQuery("#users_online #" + msg.janela_de + " .comecar").click();
                clicou.push(msg.janela_de);
              }

              if (!in_array(msg.janela_de, clicou)) {
                if (
                  jQuery(".mensagens ul li#" + msg.id).length == 0 &&
                  msg.janela_de > 0
                ) {
                  if (userOnline == msg.id_de) {
                    jQuery(
                      "#janela_" + msg.janela_de + " .mensagens ul"
                    ).append(
                      '<li class="eu" id="' +
                        msg.id +
                        '"><p>' +
                        msg.mensagem +
                        "</p></li>"
                    );
                  } else {
                    jQuery(
                      "#janela_" + msg.janela_de + " .mensagens ul"
                    ).append(
                      '<li id="' +
                        msg.id +
                        '"><div class="imgSmall"><img src="fotos/' +
                        msg.fotoUser +
                        '" border="0"/></div><p>' +
                        msg.mensagem +
                        "</p></li>"
                    );
                  }
                }
              }
            });
            jQuery(".mensagens").animate({ scrollTop: 230 }, "500");
            //console.log(clicou);
          }
          clicou = [];
          jQuery("#users_online ul").html("");
          jQuery.each(retorno.users, function (i, user) {
            var incluir =
              '<li id="' +
              user.id +
              '"><div class="imgSmall"><img src="fotos/' +
              user.foto +
              '" border="0"/></div>';
            incluir +=
              '<a href="#" id="' +
              userOnline +
              ":" +
              user.id +
              '" class="comecar">' +
              user.nome +
              "</a>";
            incluir +=
              '<span id="' +
              user.id +
              '" class="status ' +
              user.status +
              '"></span></li>';
            jQuery("span#" + user.id).attr("class", "status " + user.status);
            jQuery("#users_online ul").append(incluir);
          });
        } else if (retorno.status == "erro") {
          alert("Estábamos confundidos, actualiza la página");
        }
      },
      error: function (retorno) {
        clearInterval(t);
        t = setTimeout(function () {
          console.log(retorno);
          verifica(retorno.timestamp, retorno.lastid, userOnline, groupOnline);
        }, 15000);
      },
    });
  }

  verifica(0, 0, userOnline, groupOnline);
});
