function busqueda_sg() {
  var texto = document.getElementById("cmbGrupo").value;
  var parametros = {
    texto: texto,
  };
  console.log("busqueda_sg", texto);
  $.ajax({
    data: parametros,
    url: "valida.php?accion=consulta_sg",
    type: "POST",
    success: function (respose) {
      if (respose != "error") {
        $("#grupos").html(respose);
      }
    },
  });
}

function busqueda_us() {
  var texto = document.getElementById("cmbUser").value;
  var parametros = {
    texto: texto,
  };
  console.log("busqueda_sg", texto);
  if (texto == "2") {
    document.getElementById("cmbGrupo").style.display = "none";
    var accion = "consulta_gr";
    $("#grupos").html("");
  } else {
    var accion = "consulta_us";
    document.getElementById("cmbGrupo").style.display = "block";
    $("#grupos").html("");
  }
  //console.log(parametros);
  $.ajax({
    data: parametros,
    url: "valida.php?accion=" + accion,
    type: "POST",
    success: function (respose) {
      //split
      if (respose != "error") {
        $("#usuarios").html(respose.split("|")[0]);
        $("#grupos").html(respose.split("|")[1]);
      }
    },
  });
}
