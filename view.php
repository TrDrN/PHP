<?php
ini_set('session.gc_maxlifetime', 600);
ini_set('session.cookie_lifetime ', 0);
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');
session_start();

if (isset($_SESSION['login_user'])) {
    $username = $_SESSION['login_user'];
    $stmt = $pdo->prepare("SELECT permission FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $permission = $row['permission'];

    if ($permission !== 'admin') {
        header("location:index.php?error=Hozzáférés megtagadva!");
        exit;
    }
} else {

    $currentSessionId = session_id();
    $stmt = $pdo->prepare("SELECT session_id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $existingSessionId = $row['session_id'];

    if ($existingSessionId !== null && $existingSessionId !== $currentSessionId) {
        header("location:index.php?error=Az adott felhasználó már bejelentkezett!");
        exit;
    }


    $stmt = $pdo->prepare("UPDATE users SET session_id = :sessionId WHERE username = :username");
    $stmt->execute(['sessionId' => $currentSessionId, 'username' => $username]);
}


?>
<!Doctype html>
<html lang="hu">

<head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Megtekintés</title>
    <link rel="shortcut icon" type="image/x-icon" href="/pictures/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* ===== Google Font Import - Poppins ===== */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }


        @media print {

            /* elrejti az oldalon található navigációt nyomtatáskor */
            nav,
            .hide-on-print,
            ul,
            li,
            .text,
            button,
            i.uil.uil-bars.sidebar-toggle,
            i.uil.uil-telescope {
                display: none;

            }

            .hide-on-small-screen-print {
                display: none;
            }

            #hide-on-small-screen-print {
                display: none;
            }



            /* Táblázat formázása */
            table {
                width: 100%;
                height: 100%;
                border-collapse: collapse;
            }

            /* Táblázat fejléce */
            thead th {
                font-weight: bold;
                background-color: #ddd;
                border: 2px solid #000;

                padding: 5px;
            }

            /* Táblázat cellák */
            td {
                border: 1px solid #000;

                padding: 5px;
            }



            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
            }

            .table-wrapper {
                width: 100%;
                height: 100%;
                overflow: auto;
            }

        }


        .cim .haz {
            float: left;
        }

        .cim .tel {
            float: right;
        }

        .javitas .hatarido {

            float: right;
        }

        .munka .munkafelvevo {
            float: right;
        }




        @media screen and (max-width: 768px) {

            /* Make the table scrollable horizontally */
            table {
                width: 100%;
                overflow-x: scroll;

            }

            /* Hide the table headers */
            th {
                display: none;
            }

            /* Make the table cells full-width */
            td {
                width: 100%;
                display: block;
            }

            /* Add a div to display the column headers */
            td:before {
                content: attr(data-th);
                font-weight: bold;
                display: inline-block;
                width: 30%;
            }

            .hide-on-small-screen {
                display: none;
            }

            .rovid_leiras {
                float: left;
                width: 100%;
                margin-top: -7em;
            }

            .munkadij {
                float: left;
                width: 100%;
                margin-top: -5em;
            }

            .egysegar {
                float: left;
                width: 100%;
                margin-top: -15em;
            }

            .megnevezes {
                float: left;
                width: 100%;
                margin-top: -7em;
            }

            .egysegar {
                float: left;
                width: 100%;
                margin-top: -3em;
            }


        }


        @media only screen and (min-width: 768px) {
            .hidden-element {
                display: none;
            }

            .potkerek {
                display: none;
            }

            .elakadasjelzo {
                display: none;
            }

            .eudoboz {
                display: none;
            }

            .izzoklt {
                display: none;
            }

            .radio {
                display: none;

            }

            .felni {
                display: none;
            }

            table {
                width: 100%;
                font-size: 13px;
                overflow-x: auto;
            }

            thead {
                display: none;
            }

            tr {
                page-break-inside: avoid;
            }

            td {
                width: 50%;
                padding: 5px;
            }
        }
    </style>
</head>

<body>
    <?php
    $gyartasi_ev = '';
    if (isset($_POST['gyartasi_ev'])) {
        $gyartasi_ev = $_POST['gyartasi_ev'];
    }

    $gyartmany = '';
    if (isset($_POST['gyartmany'])) {
        $gyartmany = $_POST['gyartmany'];
    }

    $szin = '';
    if (isset($_POST['szin'])) {
        $szin = $_POST['szin'];
    }

    $tulajdonos_neve = '';
    if (isset($_POST['tulajdonos_neve'])) {
        $tulajdonos_neve = $_POST['tulajdonos_neve'];
    }

    $cime = '';
    if (isset($_POST['cime'])) {
        $cime = $_POST['cime'];
    }

    $rendszam = '';
    if (isset($_POST['rendszam'])) {
        $rendszam = $_POST['rendszam'];
    }

    $oraallas = '';
    if (isset($_POST['oraallas'])) {
        $oraallas = $_POST['oraallas'];
    }

    $uzemanyagszint = '';
    if (isset($_POST['uzemanyagszint'])) {
        $uzemanyagszint = $_POST['uzemanyagszint'];
    }

    $rovid_leiras = '';
    if (isset($_POST['rovid_leirast'])) {
        $rovid_leiras = $_POST['rovid_leiras'];
    }

    $ok = '';
    if (isset($_POST['ok'])) {
        $ok = $_POST['ok'];
    }

    $ev = '';
    if (isset($_POST['ev'])) {
        $ev = $_POST['ev'];
    }

    $honap_nap = '';
    if (isset($_POST['honap_nap'])) {
        $honap_nap = $_POST['honap_nap'];
    }

    $munkadij = '';
    if (isset($_POST['munkadij'])) {
        $munkadij = $_POST['munkadij'];
    }

    $egysegar = '';
    if (isset($_POST['egysegar'])) {
        $egysegar = $_POST['egysegar'];
    }

    $megnevezes = '';
    if (isset($_POST['megnevezes'])) {
        $megnevezes = $_POST['megnevezes'];
    }

    $tulajdonos_neve = '';
    if (isset($_POST['tulajdonos_neve'])) {
        $tulajdonos_neve = $_POST['tulajdonos_neve'];
    }
    ?>

    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="/pictures/logo.png" alt="" title="">
            </div>
            <span class="logo_name">Török és Társa 2021 gépjármüjavító Bt.</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="index.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Főoldal</span>
                    </a></li>
                <li><a href="new.php">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">Felvétel</span>
                    </a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name" onclick="location.href='logout.php'">Kilépés</span>
                    </a></li>

                <li class="mode"><a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Sötét mód</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>


            <img src="/pictures/profile.png" alt="" title="" class="hide-on-small-screen-print">

        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-telescope"></i>
                    <span class="text">Megtekintés</span>
                </div>
                <p>&nbsp;</p>
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    include("config.php");
                    $pdo->query("SET NAMES 'utf8mb4'");
                    $parancs = "SELECT COUNT(*) FROM autok JOIN munkalapok ON autok.auto_id = munkalapok.auto_id";
                    $pdo->query($parancs);
                    $parancs = ("SELECT * FROM autok JOIN munkalapok ON autok.auto_id = munkalapok.auto_id WHERE autok.auto_id = :id");
                    $stmt = $pdo->prepare($parancs);
                    $stmt->execute(array(':id' => $id));
                    while ($sor = $stmt->fetch()) {
                        ?>
                        <div id="table-to-print">
                            <table border="1" cellspacing="0" cellpadding="0" style="margin: auto;" class="my-table"
                                width="1024px">
                                <tbody>
                                    <tr>
                                        <td width="546" colspan="2" valign="top">
                                            <h1>
                                                <center> Török és Társa 2021 gépjárműjavító Bt.</center>
                                            </h1>
                                            <h3>
                                                <div class="cim">
                                                    <span class="haz">7400 Kaposvár Bem u 47</span> <span class="tel">+36
                                                        20/9296443</span>
                                                </div>
                                            </h3>
                                        </td>
                                        <td width="102" valign="top">
                                            <p>
                                                <center><strong>Munkaszám:</strong></center>
                                            </p>
                                            <p align="center">
                                                <strong>
                                                    <?php echo '<font color="blue">' . $sor['munkalap_id'] . '</font>' ?> / 2023
                                                </strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="438" valign="top">
                                            <h1 align="center">
                                                Munkamegrendelés
                                            </h1>
                                        </td>
                                        <td width="108" valign="top">
                                            <p align="center">
                                                Form.nyomt. jele:
                                            </p>
                                            <h4 align="center">
                                                Munkamegrendelés
                                            </h4>
                                        </td>
                                        <td width="102" valign="top">
                                            <p align="center">
                                                Változat: 1
                                            </p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table> <br>
                            <table border="1" cellspacing="0" cellpadding="0" style="margin: auto;" class="my-table">
                                <tbody>
                                    <tr>
                                        <td width="308" colspan="8" valign="top">
                                            <p>
                                                Megrendelő:
                                                <?php echo '<font color="blue">' . $sor['tulajdonos_neve'] . '</font>'; ?>
                                            </p>
                                            <p>
                                                Címe:
                                                <?php echo '<font color="blue">' . $sor['cime'] . '</font>'; ?>
                                            </p>
                                        </td>
                                        <td width="342" colspan="13" valign="top">
                                            <p>
                                                Tulajdonos.: UA.
                                            </p>
                                            <p>
                                                Címe: UA.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="207" colspan="6" valign="top">
                                            <p>
                                                Rendszám:
                                                <?php echo '<font color="blue">' . $sor['rendszam'] . '</font>'; ?>
                                            </p>
                                        </td>
                                        <td width="204" colspan="8" valign="top">
                                            <p>
                                                Gyártmány:
                                                <?php echo '<font color="blue">' . $sor['gyartmany'] . '</font>'; ?>
                                            </p>
                                        </td>
                                        <td width="239" colspan="7" valign="top">
                                            <p>
                                                Gyártási év.:
                                                <?php echo '<font color="blue">' . $sor['gyartasi_ev'] . '</font>'; ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="207" colspan="6" valign="top">
                                            <p>
                                                Alvázszám:
                                            </p>
                                        </td>
                                        <td width="204" colspan="8" valign="top">
                                            <p>
                                                Motorszám:
                                            </p>
                                        </td>
                                        <td width="239" colspan="7" rowspan="2" valign="top">
                                            <p>
                                                Üzemanyag szint:
                                                <?php echo '<font color="blue">' . $sor['uzemanyagszint'] . '</font>'; ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="207" colspan="6" valign="top">
                                            <p>
                                                Szín:
                                                <?php echo '<font color="blue">' . $sor['szin'] . '</font>'; ?>
                                            </p>
                                        </td>
                                        <td width="204" colspan="8" valign="top">
                                            <p>
                                                Óra állás.:
                                                <?php echo '<font color="blue">' . $sor['oraallas'] . '</font>'; ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="308" colspan="8" valign="top">
                                            <p>
                                                Jármű sérülések leírása:
                                            </p>
                                        </td>
                                        <td width="342" colspan="13" valign="top">
                                            <p>
                                                <img width="266" height="109" src="/pictures/abra.jpg" align="left" hspace="12" alt="ábra1" class="hide-on-small-screen" />
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="650" colspan="21" valign="top">
                                            <p align="center">
                                                <strong> Tartozékok:</strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="72" valign="top">
                                            <p align="center">
                                                Pótkerék

                                            </p>
                                            <p align="center">

                                            </p>
                                        </td>
                                        <td width="54" colspan="3" valign="top">
                                            <p align="center">
                                                Emelő
                                            </p>

                                        </td>
                                        <td width="81" colspan="2" valign="top">
                                            <p align="center">
                                                Elakadásjelző
                                            </p>
                                            <p align="center">

                                            </p>
                                        </td>
                                        <td width="108" colspan="3" valign="top">
                                            <p align="center">
                                                Eü. doboz
                                            </p>
                                            <p align="center">

                                            </p>
                                        </td>
                                        <td width="35" colspan="2" valign="top">
                                            <p align="center">
                                                Izzó klt.
                                            </p>
                                            <p align="center">

                                            </p>
                                        </td>
                                        <td width="87" colspan="4" valign="top">
                                            <p align="center">
                                                Rádió tipus
                                            </p>
                                            <p align="center">

                                            </p>
                                        </td>
                                        <td width="80" colspan="3" valign="top">
                                            <p align="center">
                                                Könnyűfém felni
                                            </p>
                                            <p align="center">

                                            </p>
                                        </td>
                                        <td width="48" colspan="2" valign="top">
                                            <p align="center">
                                                Egyéb:
                                            </p>
                                        </td>
                                        <td width="84" valign="top">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="72" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <input type="checkbox" name="" id="">
                                            </p>
                                        </td>
                                        <td width="54" colspan="3" valign="top" class="hide-on-small-screen">
                                        </td>
                                        <td width="81" colspan="2" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <input type="checkbox" name="" id="">
                                            </p>
                                        </td>
                                        <td width="108" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <input type="checkbox" name="" id="">
                                            </p>
                                        </td>
                                        <td width="35" colspan="2" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <input type="checkbox" name="" id="">
                                            </p>
                                        </td>
                                        <td width="87" colspan="4" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <input type="checkbox" name="" id="">
                                            </p>
                                        </td>
                                        <td width="80" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <input type="checkbox" name="" id="">
                                            </p>
                                        </td>
                                        <td width="48" colspan="2" valign="top" class="hide-on-small-screen">
                                        </td>
                                        <td width="84" valign="top" class="hide-on-small-screen">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="650" colspan="21" valign="top">
                                            <p>
                                                Megrendelem Önöknél a gépkocsi javítását a következő hiba
                                                elhárítására:
                                            </p>
                                            <p>
                                                <?php echo '<font color="blue">' . $sor['ok'] . '</font>'; ?>
                                            </p>
                                            <p>
                                            <div class="javitas">
                                                <span> <strong> A javítás várható költsége (Ft) : </strong></span>
                                                . <span class="hatarido"><strong>A javítás várható határideje</strong>:</span>
                                            </div>
                                            </p>
                                            <p>
                                                <strong> Dátum</strong>
                                                :
                                                <?php echo '<font color="blue">' . $sor['ev'] . '</font>'; ?> év
                                                <?php echo '<font color="blue">' . $sor['honap_nap'] . '</font>'; ?>
                                            </p>
                                            <p>
                                                . .
                                            </p>
                                            <p>
                                            <div class="munka">
                                                Megrendelő <span class="munkafelvevo"> Munkafelvevő</span>
                                            </div>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="650" colspan="21" valign="top">
                                            <p align="center">
                                                <strong> Elvégzett munka</strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="357" colspan="12" valign="top">
                                            <p align="center">
                                                Rövid leírása
                                            </p>
                                            <p>
                                                <span class="hide-on-small-screen-print">
                                                    <span class="hidden-element">
                                                        <?php echo '<font color="blue">' . $sor['rovid_leiras'] . '</font>'; ?>
                                                    </span>
                                                </span>
                                            </p>
                                        </td>
                                        <td width="148" colspan="5" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                Végezte
                                            </p>
                                        </td>
                                        <td width="145" colspan="4" valign="top">
                                            <p align="center">
                                                M.díj
                                            </p>
                                            <p align="center">
                                                <span class="hide-on-small-screen-print">
                                                    <span class="hidden-element">
                                                        <?php echo '<font color="blue">' . $sor['munkadij'] . '</font>'; ?>
                                                    </span>
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="357" colspan="12" valign="top" class="hide-on-small-screen">
                                            <p>
                                                <span class="hide-on-small-screen">
                                                    <?php echo '<font color="blue">' . $sor['rovid_leiras'] . '</font>'; ?>
                                                </span>
                                            </p>
                                        </td>
                                        <td width="148" colspan="5" valign="top" class="hide-on-small-screen">
                                        </td>
                                        <td width="145" colspan="4" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <span class="hide-on-small-screen">
                                                    <?php echo '<font color="blue">' . $sor['munkadij'] . '</font>'; ?>
                                                </span>
                                            </p>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td width="650" colspan="21" valign="top">
                                            <p align="center">
                                                <strong>Felhasznált anyag (egyéb ktsg., díj)</strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="101" colspan="2" valign="top">
                                            <p align="center">
                                                Megnevezés
                                            </p>
                                            <p>
                                                <span class="hide-on-small-screen-print">
                                                    <span class="hidden-element">
                                                        <?php echo '<font color="blue">' . $sor['megnevezes'] . '</font>'; ?>
                                                    </span>
                                                </span>
                                            </p>
                                        </td>
                                        <td width="86" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                Cikkszám, azonosítás
                                            </p>
                                        </td>
                                        <td width="67" colspan="2" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                Mennyiség
                                            </p>
                                        </td>
                                        <td width="54" valign="top">
                                            <p align="center">
                                                Egységár
                                            </p>

                                        </td>
                                        <td width="82" colspan="5" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                Megnevezés
                                            </p>
                                        </td>
                                        <td width="93" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                Cikkszám, azonosítás
                                            </p>
                                        </td>
                                        <td width="80" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                Mennyiség
                                            </p>
                                        </td>
                                        <td width="86" colspan="2" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                Egységár
                                            </p>
                                            <p align="center">
                                                <span class="hide-on-small-screen-print">
                                                    <span class="hidden-element">
                                                        <?php echo '<font color="blue">' . $sor['egysegar'] . '</font>'; ?>
                                                    </span>
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="101" colspan="2" valign="top" class="hide-on-small-screen">
                                            <p>
                                                <span class="hide-on-small-screen">

                                                    <?php echo '<font color="blue">' . $sor['megnevezes'] . '</font>'; ?>
                                                </span>
                                            </p>
                                        </td>
                                        <td width="86" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <strong></strong>
                                            </p>
                                        </td>
                                        <td width="67" colspan="2" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <strong></strong>
                                            </p>
                                        </td>
                                        <td width="54" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <strong></strong>
                                            </p>
                                        </td>
                                        <td width="82" colspan="5" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <strong></strong>
                                            </p>
                                        </td>
                                        <td width="93" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <strong></strong>
                                            </p>
                                        </td>
                                        <td width="80" colspan="3" valign="top" class="hide-on-small-screen">
                                            <p align="center">
                                                <strong></strong>
                                            </p>
                                        </td>
                                        <td width="86" colspan="2" valign="top">
                                            <p align="center">
                                                <?php echo '<font color="blue">' . $sor['egysegar'] . '</font>' ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="107" colspan="5" valign="top" align="center">
                                            <p>
                                                A megrendelt valamint a vállalt szolgáltatás és a jótállás
                                                feltételeit a vállalási szabályzat tartalmazza.
                                            </p>
                                        </td>
                                        <td width="210" colspan="7" valign="top" align="center">
                                            <p>
                                                A járművet a megrendelt munkák elvégzése után hiánytalanul,
                                                üzemképesen átvettem
                                            </p>
                                            <p>
                                                ………………………..
                                            </p>
                                            <p>
                                                Megrendelő
                                            </p>
                                        </td>
                                        <td width="333" colspan="11" valign="top" align="center">
                                            <p>
                                                Tanúsítjuk, hogy az általunk végzett munka megfelelő, a
                                                beépített alkatrészek további felhasználásra alkalmasak.
                                            </p>
                                            <p>
                                                Dátum:
                                                <?php echo '<font color="blue">' . $sor['datum'] . '</font>' ?>
                                            </p>
                                            <p align="center">
                                                ………………………….
                                            </p>
                                            <p align="center">
                                                Átadó
                                            </p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <br>
                        <center>
                            <button onclick="window.print()" name="nyomtatas" id="nyomtatas"
                                class="nyomtatas">Nyomtatás</button>

                        </center>

                        <?php
                    }
                }
                ?>


                <script>
                    const body = document.querySelector("body"),
                        modeToggle = body.querySelector(".mode-toggle");
                    sidebar = body.querySelector("nav");
                    sidebarToggle = body.querySelector(".sidebar-toggle");

                    let getMode = localStorage.getItem("mode");
                    if (getMode && getMode == "dark") {
                        body.classList.toggle("dark");
                    }

                    let getStatus = localStorage.getItem("status");
                    if (getStatus && getStatus == "close") {
                        sidebar.classList.toggle("close");
                    }

                    modeToggle.addEventListener("click", () => {
                        body.classList.toggle("dark");
                        if (body.classList.contains("dark")) {
                            localStorage.setItem("mode", "dark");

                        } else {
                            localStorage.setItem("mode", "light");
                        }
                    });

                    sidebarToggle.addEventListener("click", () => {
                        sidebar.classList.toggle("close");
                        if (sidebar.classList.contains("close")) {
                            localStorage.setItem("status", "close");

                        } else {
                            localStorage.setItem("status", "open");
                        }
                    });
                </script>
</body>
</body>

</html>