<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>facebook</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>
<?php session_start();
$id_user = $_GET['id_user'];
?>

<body>
    <?php

    include('../../config.php');
    $medio = 2;
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
    function ago($time)
    {
        $periodos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año", "década");
        $duraciones = array("60", "60", "24", "7", "4.35", "12", "10");
        $now = time();
        $diferencia = $now - $time;

        for ($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones) - 1; $j++) {
            $diferencia /= $duraciones[$j];
        }
        $diferencia = round($diferencia);

        if ($diferencia != 1) {
            if ($j != 5) {
                $periodos[$j] .= "s";
            } else {
                $periodos[$j] .= "es";
            }
        }

        return "hace $diferencia $periodos[$j]";
    }
    ?>
    <div class="main-container">

        <!-- HEADER -->
        <header class="block">
            <!-- <ul class="header-menu horizontal-list">
                <li>
                    <a class="header-menu-tab" href="#1">
                        <img src="assets/img/facebook.png" class="icofacebook" alt="">
                        </span></a>
                </li>
                <li>
                    <form action="">
                        <input type="text" name="" placeholder="Buscar en Facebook" class="txtsearchfb" id="">
                    </form>
                </li>
                <li class="navoptionscenter">
                    <a class="header-menu-tab" href="#1"><span class="icon entypo-home scnd-font-color"></span></a>
                </li>
                <li>
                    <a class="header-menu-tab" href="#2">
                        <span class="icon fontawesome-play scnd-font-color"></span>
                    </a>
                </li>
                <li>
                    <a class="header-menu-tab" href="#3"><span
                            class="icon fontawesome-download scnd-font-color"></span></a>
                    <a class="header-menu-number" href="#4">5</a>
                </li>
                <li>
                    <a class="header-menu-tab" href="#5"><span
                            class="icon fontawesome-group scnd-font-color"></span></a>
                </li>
                <li>
                    <a class="header-menu-tab" href="#5"><span class="icon entypo-flattr scnd-font-color"></span></a>
                </li>
            </ul> -->
            <div class="profile-menu">
                <p><?php echo $row_dtsUsr['nombre'] ?> <a href="#26"><span class="entypo-down-open scnd-font-color"></span></a></p>
                <div class="profile-picture small-profile-picture">
                    <img width="40px" alt="<?php echo $row_dtsUsr['nombre'] ?> picture" src="../../files/<?php echo $row_dtsUsr['img_user'] ?>">
                </div>
            </div>
        </header>

        <div class="fixtopp"></div>

        <!-- LEFT-CONTAINER -->
        <div class="left-container container">
            <div class="menu-box block">
                <!-- MENU BOX (LEFT-CONTAINER) -->
                <ul class="menu-box-menu">
                    <li>
                        <a class="menu-box-tab" href="#6">
                            <div class="profile-picture small-profile-picture">
                                <img width="40px" alt="<?php echo $row_dtsUsr['nombre'] ?> picture" src="../../files/<?php echo $row_dtsUsr['img_user'] ?>">
                            </div>
                            <?php echo $row_dtsUsr['nombre'] ?>
                        </a>
                    </li>

                    <li>
                        <a class="menu-box-tab" href="#6">
                            <img src="assets/img/amigos.png" class="iconmenu" alt=""> Participantes<div class="menu-box-number"><?php echo $cant_prtcp ?> personas</div>
                        </a>
                    </li>

                    <li>
                        <a class="menu-box-tab" href="#6">
                            <img src="assets/img/equipos.png" class="iconmenu" alt=""> Grupo<div class="menu-box-number">grupo: <?php echo $row_dtsUsr['grupo'] ?></div>
                        </a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="#6">
                            <img src="assets/img/email.png" class="iconmenu" alt=""> Emails<div class="menu-box-number"><?php echo $cant ?> emails</div>
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <!-- MIDDLE-CONTAINER -->
        <div class="middle-container container">
            <!-- PROFILE (MIDDLE-CONTAINER) -->
            <!-- <div class="profile block">
                
                <a class="add-button" href="#28"><span class="icon entypo-plus scnd-font-color"></span></a>
                <div class="profile-picture big-profile-picture clear">
                    <img width="100%" alt="Anne Hathaway picture" src="http://upload.wikimedia.org/wikipedia/commons/e/e1/Anne_Hathaway_Face.jpg">
                </div>
                <h1 class="user-name">Anne Hathaway</h1>
            </div>
            <div class="profile block">
            
                <a class="add-button" href="#28"><span class="icon entypo-plus scnd-font-color"></span></a>
                <div class="profile-picture big-profile-picture clear">
                    <img width="100%" alt="Anne Hathaway picture" src="http://upload.wikimedia.org/wikipedia/commons/e/e1/Anne_Hathaway_Face.jpg">
                </div>
                <h1 class="user-name">Anne Hathaway</h1>
            </div>
            <div class="profile block">
            
                <a class="add-button" href="#28"><span class="icon entypo-plus scnd-font-color"></span></a>
                <div class="profile-picture big-profile-picture clear">
                    <img width="100%" alt="Anne Hathaway picture" src="http://upload.wikimedia.org/wikipedia/commons/e/e1/Anne_Hathaway_Face.jpg">
                </div>
                <h1 class="user-name">Anne Hathaway</h1>
            </div>
            <div class="profile block">
            
                <a class="add-button" href="#28"><span class="icon entypo-plus scnd-font-color"></span></a>
                <div class="profile-picture big-profile-picture clear">
                    <img width="100%" alt="Anne Hathaway picture" src="http://upload.wikimedia.org/wikipedia/commons/e/e1/Anne_Hathaway_Face.jpg">
                </div>
                <h1 class="user-name">Anne Hathaway</h1>
            </div> -->


            <!-- <div class="fixtoppmiddle"></div> -->

            <!-- TWEETS (MIDDLE-CONTAINER) -->
            <!-- <div class="tweets block">
                
                <div class="tweet first">

                    <div class="inputfbinline">
                        <div class="imgdown">
                            <img width="100%" src="http://upload.wikimedia.org/wikipedia/commons/e/e1/Anne_Hathaway_Face.jpg">
                        </div>
                        <div class="">
                            <input type="text" style="width: 200%;" placeholder="que estas pensando?" class="txtsearchfb">
                        </div>
                    </div>

                </div>
            </div> -->

            <!-- desde aqui -->

            <div class="tweets block">
                <!-- TWEETS (MIDDLE-CONTAINER) -->

                <div class="tweet first" style="height: auto; border-style: solid;">
                    <?php
                    while ($row = mysqli_fetch_array($res_sql, MYSQLI_BOTH)) {
                        if ($row['actor'] <> '0') {
                            $sql_actor = "SELECT * from actor_simulado WHERE id_actor = '" . $row['actor'] . "';";
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
                        <div class="inputfbinline">
                            <div class="imgdown">
                                <img width="100%" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                            </div>
                            <div class="">
                                <p> <?php echo $rmtnte  ?></p>
                                <p style="font-size: small"> <?php echo ago(strtotime($row[3])) ?></p>
                                <p> <strong><?php echo $row[5] ?> </strong></p><br>
                                <p class="txtcontent"> <?php echo $row[6] ?> </p>
                            </div>
                        </div>

                        <div class="divimgpost">
                            <!-- <img class="imgpost" src="http://upload.wikimedia.org/wikipedia/commons/e/e1/Anne_Hathaway_Face.jpg" alt=""> -->
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- RIGHT-CONTAINER -->
        <div class="right-container container">
            <!-- <div class="join-newsletter block">
                
                <h2 class="titular">JOIN THE NEWSLETTER</h2>
                <div class="input-container">
                    <input type="text" placeholder="yourname@gmail.com" class="email text-input">
                    <div class="input-icon envelope-icon-newsletter"><span class="fontawesome-envelope scnd-font-color"></span></div>
                </div>
                <a class="subscribe button" href="#21">SUBSCRIBE</a>
            </div>
            <div class="account block">
                
                <h2 class="titular">SIGN IN TO YOUR ACCOUNT</h2>
                <div class="input-container">
                    <input type="text" placeholder="yourname@gmail.com" class="email text-input">
                    <div class="input-icon envelope-icon-acount"><span class="fontawesome-envelope scnd-font-color"></span></div>
                </div>
                <div class="input-container">
                    <input type="text" placeholder="Password" class="password text-input">
                    <div class="input-icon password-icon"><span class="fontawesome-lock scnd-font-color"></span></div>
                </div>
                <a class="sign-in button" href="#22">SIGN IN</a>
                <p class="scnd-font-color">Forgot Password?</p>
                <a class="fb-sign-in" href="58">
                    <p><span class="fb-border"><span class="icon zocial-facebook"></span></span>Sign in with Facebook
                    </p>
                </a>
            </div>
            <div class="loading block">
                
                <div class="progress-bar downloading"></div>
                <p><span class="icon fontawesome-cloud-download scnd-font-color"></span>Downloading...</p>
                <p class="percentage">81<sup>%</sup></p>
                <div class="progress-bar uploading"></div>
                <p><span class="icon fontawesome-cloud-upload scnd-font-color"></span>Uploading...</p>
                <p class="percentage">43<sup>%</sup></p>
            </div> -->
            <div class="calendar-day block">
                <!-- CALENDAR DAY (RIGHT-CONTAINER) -->
                <div class="arrow-btn-container">
                    <a class="arrow-btn left" href="#200"><span class="icon fontawesome-angle-left"></span></a>
                    <h2 class="titular">WEDNESDAY</h2>
                    <a class="arrow-btn right" href="#201"><span class="icon fontawesome-angle-right"></span></a>
                </div>
                <p class="the-day">26</p>
                <a class="add-event button" href="#27">ADD EVENT</a>
            </div>
            <div class="calendar-month block">
                <!-- CALENDAR MONTH (RIGHT-CONTAINER) -->
                <div class="arrow-btn-container">
                    <a class="arrow-btn left" href="#202"><span class="icon fontawesome-angle-left"></span></a>
                    <h2 class="titular">APRIL 2013</h2>
                    <a class="arrow-btn right" href="#203"><span class="icon fontawesome-angle-right"></span></a>
                </div>
                <table class="calendar">
                    <thead class="days-week">
                        <tr>
                            <th>S</th>
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>R</th>
                            <th>F</th>
                            <th>S</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><a class="scnd-font-color" href="#100">1</a></td>
                        </tr>
                        <tr>
                            <td><a class="scnd-font-color" href="#101">2</a></td>
                            <td><a class="scnd-font-color" href="#102">3</a></td>
                            <td><a class="scnd-font-color" href="#103">4</a></td>
                            <td><a class="scnd-font-color" href="#104">5</a></td>
                            <td><a class="scnd-font-color" href="#105">6</a></td>
                            <td><a class="scnd-font-color" href="#106">7</a></td>
                            <td><a class="scnd-font-color" href="#107">8</a></td>
                        </tr>
                        <tr>
                            <td><a class="scnd-font-color" href="#108">9</a></td>
                            <td><a class="scnd-font-color" href="#109">10</a></td>
                            <td><a class="scnd-font-color" href="#110">11</a></td>
                            <td><a class="scnd-font-color" href="#111">12</a></td>
                            <td><a class="scnd-font-color" href="#112">13</a></td>
                            <td><a class="scnd-font-color" href="#113">14</a></td>
                            <td><a class="scnd-font-color" href="#114">15</a></td>
                        </tr>
                        <tr>
                            <td><a class="scnd-font-color" href="#115">16</a></td>
                            <td><a class="scnd-font-color" href="#116">17</a></td>
                            <td><a class="scnd-font-color" href="#117">18</a></td>
                            <td><a class="scnd-font-color" href="#118">19</a></td>
                            <td><a class="scnd-font-color" href="#119">20</a></td>
                            <td><a class="scnd-font-color" href="#120">21</a></td>
                            <td><a class="scnd-font-color" href="#121">22</a></td>
                        </tr>
                        <tr>
                            <td><a class="scnd-font-color" href="#122">23</a></td>
                            <td><a class="scnd-font-color" href="#123">24</a></td>
                            <td><a class="scnd-font-color" href="#124">25</a></td>
                            <td><a class="today" href="#125">26</a></td>
                            <td><a href="#126">27</a></td>
                            <td><a href="#127">28</a></td>
                            <td><a href="#128">29</a></td>
                        </tr>
                        <tr>
                            <td><a href="#129" onclick="let date = new Date(); console.log(toTimeZone(date,'America/Argentina/Buenos_Aires'));">Hora</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- end calendar-month block -->
        </div> <!-- end right-container -->
    </div> <!-- end main-container -->
    <script>
        function EjemploDeTZ() {

            var d, tz, s = "La hora actual local es ";
            d = new Date();
            tz = d.getTimezoneOffset();
            console.log('GMT: ', tz / 60)
            if (tz < 0)
                s += tz / 60 + " horas antes de GMT";
            else if (tz == 0)
                s += "GMT";
            else
                s += tz / 60 + " horas después de GMT";
            console.log('Hora: ', s)
            return (s);
        }
    </script>
</body>

</html>