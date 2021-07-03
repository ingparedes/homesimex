<?php
require_once('config.php');
if ($_GET['accion'] == 'consulta_sg') {
    if ($_POST['texto'] != '0') {

        $sql = ("SELECT * FROM subgrupo WHERE id_grupo = '" . $_POST['texto'] . "' ORDER BY nombre_subgrupo");
        $result  = mysqli_query($con, $sql);
        $tmp = "";
        while ($row = mysqli_fetch_array($result)) {
            $tmp .= "<div class=\"card bg-primary text-white\" >
            <div class=\"card-body\" data_id = \"sg-" . $row[0] . "\" id = \"sg-" . $row[0] . "\">
            <h5 class=\"card-title\">Sub Grupo " . $row[1] . "</h5>
            <p class=\"card-text\">" . $row[2] . "</p>
            <div class=\"circulo\" id = \"cant_usr_sg-" . $row[0] . "\"></div>
            </div>
            </div>";
        }
        $tmp .= "<br>";
        $sql = "SELECT * FROM grupo g WHERE g.id_grupo NOT IN (SELECT id_grupo FROM subgrupo);";
        $result  = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $tmp .= "<div class=\"card bg-primary text-white\" >
            <div class=\" card-body\" data_id = \"gr-" . $row[0] . "\" id = \"gr-" . $row[0] . "\">
            <h5 class=\"card-title\">Grupo " . $row[1] . "</h5>
            <p class=\"card-text\">" . $row[2] . "</p>
            <div class=\"circulo\" id = \"cant_usr_gr-" . $row[0] . "\"></div>
            </div>
            </div>";
        }
    } else {
        $tmp = "error";
    }
    echo $tmp;
} elseif ($_GET['accion'] == 'consulta_gr') {
    if ($_POST['texto'] != '0') {
        //USUARIOS
        $sql      = ("SELECT * FROM users us INNER JOIN userlevels ul ON us.perfil = ul.userlevelid WHERE us.grupo = '0' AND us.perfil = '" . $_POST['texto'] . "' ORDER BY us.nombres;");
        $result  = mysqli_query($con, $sql);
        $tmp1 = "";
        while ($row = mysqli_fetch_array($result)) {
            $tmp1 .= "<div class=\"col-md-12\" data-index=\"" . $row['id_users'] . "\" id=\"" . $row['id_users'] . "\" draggable=\"true\">
                <div class=\"drop__card\">
                    <div class=\"drop__data\">
                        <img id = \"img_" . $row['id_users'] . "\" src=\"fotos/" . $row['img_user'] . "\" alt=\"\" class=\"drop__img\">
                        <div>
                            <h1 class=\"drop__name\">
                                " . $row['nombres'] . " " . $row['apellidos'] . " 
                            </h1>
                            <span id = \"perf_" . $row['id_users'] . "\" class=\"drop__profession\">
                                Perfil: " . $row['userlevelname'] . "
                            </span>
                        </div>
                    </div>

                </div>
            </div>";
        }

        //GRUPOS 

        $sql = ("SELECT * FROM grupo ORDER BY nombre_grupo");
        $result  = mysqli_query($con, $sql);
        $tmp2 = "";
        while ($row = mysqli_fetch_array($result)) {
            $tmp2 .= "<div class=\"card bg-primary text-white\" >
        <div class=\" card-body\" data_id = \"gr-" . $row[0] . "\" id = \"gr-" . $row[0] . "\">
            <h5 class=\"card-title\">Grupo " . $row[1] . "</h5>
            <p class=\"card-text\">" . $row[2] . "</p>
                <div class=\"circulo\" id = \"cant_usr_gr-" . $row[0] . "\"></div>
            </div>
        </div>";
        }
    } else {
        $tmp = "error";
    }
    $tmp = $tmp1 . "|" . $tmp2;
    echo $tmp;
} elseif ($_GET['accion'] == 'consulta_us') {
    if ($_POST['texto'] != '0') {

        $sql      = ("SELECT * FROM users us INNER JOIN userlevels ul ON us.perfil = ul.userlevelid WHERE us.grupo = '0' AND us.perfil = '" . $_POST['texto'] . "' ORDER BY us.nombres;");
        $result  = mysqli_query($con, $sql);
        $tmp = "";
        while ($row = mysqli_fetch_array($result)) {
            $tmp .= "<div class=\"col-md-12\" data-index=\"" . $row['id_users'] . "\" id=\"" . $row['id_users'] . "\" draggable=\"true\">
                <div class=\"drop__card\">
                    <div class=\"drop__data\">
                        <img id = \"img_" . $row['id_users'] . "\" src=\"fotos/" . $row['img_user'] . "\" alt=\"\" class=\"drop__img\">
                        <div>
                            <h1 class=\"drop__name\">
                                " . $row['nombres'] . " " . $row['apellidos'] . " 
                            </h1>
                            <span id = \"perf_" . $row['id_users'] . "\" class=\"drop__profession\">
                                Perfil: " . $row['userlevelname'] . "
                            </span>
                        </div>
                    </div>

                </div>
            </div>";
        }
    } else {
        $tmp = "error";
    }
    echo $tmp;
} elseif ($_GET['accion'] == 'guarda') {
    /*
    echo "usuario" . $_POST['usuario'] . "<br>";
    echo "grupo" . $_POST['grupo'] . "<br>";
    echo "subgrupo" . $_POST['subgrupo'] . "<br>";
*/
    if (isset($_POST['subgrupo'])) {
        $sql = "UPDATE users SET grupo='" . $_POST['grupo'] . "', subgrupo='" . $_POST['subgrupo'] . "' WHERE  id_users='" . $_POST['usuario'] . "';";
    } else {
        $sql = "UPDATE users SET grupo='" . $_POST['grupo'] . "', subgrupo='0' WHERE  id_users='" . $_POST['usuario'] . "';";
    }
    $result  = mysqli_query($con, $sql);
    if ($result) {
        echo "ok";
    } else {
        echo "error";
    }
}
