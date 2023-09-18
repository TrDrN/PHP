<?php
ob_start();
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
<!doctype html>
<html lang="hu">

<head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Felvétel</title>
    <link rel="shortcut icon" type="image/x-icon" href="/pictures/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <style>
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
            body {
                overflow: auto;
            }

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
            body {
                overflow: auto;
            }

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
            <img src="/pictures/profile.png" alt="" title="">
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-upload"></i>
                    <span class="text">Felvétel</span>
                </div>
                <form method="post">
                    <table border="1" cellspacing="0" cellpadding="0" style="margin: auto;">
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
                                        <strong> /
                                            2023</strong>
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
                    <table border="1" cellspacing="0" cellpadding="0" style="margin: auto;">
                        <tbody>
                            <tr>
                                <td width="308" colspan="10" valign="top">
                                    <p>
                                        Megrendelő: <input name="tulajdonos_neve" type="text" required="required"
                                            id="tulajdonos_neve">
                                    </p>
                                    <p>
                                        Címe: <input name="cime" type="text" id="cime">
                                    </p>
                                </td>
                                <td width="342" colspan="13" valign="top" class="hide-on-small-screen">
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
                                        Rendszám: <input name="rendszam" type="text" required="required" id="rendszam"
                                            size="10"><u></u>

                                    </p>
                                </td>
                                <td width="204" colspan="8" valign="top">
                                    <p>
                                        Gyártmány: <input name="gyartmany" type="text" id="gyartmany" size="10"
                                            required="required">
                                    </p>
                                </td>
                                <td width="239" colspan="7" valign="top">
                                    <p>
                                        Gyártási év.: <input type="number" required="required" size="5" id="gyartasi_ev"
                                            name="gyartasi_ev">
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
                                        Üzemanyag szint: <select required="required" id="uzemanyagszint"
                                            name="uzemanyagszint">
                                            <option value="" selected hidden>Válasszon egy üzemanyagszintet</option>
                                            <option>1/4</option>
                                            <option>2/4</option>
                                            <option>3/4</option>
                                            <option>4/4</option>
                                        </select>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="207" colspan="6" valign="top">
                                    <p>
                                        Szín: <input name="szin" type="text" required="required" id="szin" size="10">
                                    </p>
                                </td>
                                <td width="204" colspan="8" valign="top">
                                    <p>
                                        Óra állás.: <input name="oraallas" type="text" required="required" id="oraallas"
                                            size="10">
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
                                        <img width="266" height="109" src="/pictures/abra.jpg" align="left" hspace="12"
                                            alt="ábra1" class="hide-on-small-screen" />
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
                                        <input type="checkbox" class="potkerek">
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
                                        <input type="checkbox" class="elakadasjelzo">
                                    </p>
                                </td>
                                <td width="108" colspan="3" valign="top">
                                    <p align="center">
                                        Eü. doboz
                                    </p>
                                    <p align="center">
                                        <input type="checkbox" class="eudoboz">
                                    </p>
                                </td>
                                <td width="35" colspan="2" valign="top">
                                    <p align="center">
                                        Izzó klt.
                                    </p>
                                    <p align="center">
                                        <input type="checkbox" class="izzoklt">
                                    </p>
                                </td>
                                <td width="87" colspan="4" valign="top">
                                    <p align="center">
                                        Rádió tipus
                                    </p>
                                    <p align="center">
                                        <input type="checkbox" class="radio">
                                    </p>
                                </td>
                                <td width="80" colspan="3" valign="top">
                                    <p align="center">
                                        Könnyűfém felni
                                    </p>
                                    <p align="center">
                                        <input type="checkbox" class="felni">
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
                                        <input type="checkbox" class="hide-on-small-screen">
                                    </p>
                                </td>
                                <td width="54" colspan="3" valign="top" class="hide-on-small-screen">
                                </td>
                                <td width="81" colspan="2" valign="top" class="hide-on-small-screen">
                                    <p align="center">
                                        <input type="checkbox" class="hide-on-small-screen">
                                    </p>
                                </td>
                                <td width="108" colspan="3" valign="top" class="hide-on-small-screen">
                                    <p align="center">
                                        <input type="checkbox" class="hide-on-small-screen">
                                    </p>
                                </td>
                                <td width="35" colspan="2" valign="top" class="hide-on-small-screen">
                                    <p align="center">
                                        <input type="checkbox" class="hide-on-small-screen">
                                    </p>
                                </td>
                                <td width="87" colspan="4" valign="top" class="hide-on-small-screen">
                                    <p align="center">
                                        <input type="checkbox" class="hide-on-small-screen">
                                    </p>
                                </td>
                                <td width="80" colspan="3" valign="top" class="hide-on-small-screen">
                                    <p align="center">
                                        <input type="checkbox" class="hide-on-small-screen">
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
                                        <textarea name="ok" cols="0" rows="0" required="required" id="ok"></textarea>
                                    </p>
                                    <p>
                                    <div class="javitas">
                                        <span> <strong> A javítás várható költsége (Ft) : </strong></span>
                                        . <span class="hatarido"><strong>A javítás várható határideje</strong>:</span>
                                    </div>
                                    </p>
                                    <p>
                                        <strong> Dátum</strong>
                                        : <input name="ev" type="number" id="ev" required="required"> év <input
                                            name="honap_nap" type="text" id="honap_nap" required="required">
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
                                </td>
                                <td width="148" colspan="5" valign="top" class="hide-on-small-screen">
                                    <p align="center">
                                        Végezte
                                    </p>
                                </td>
                                <td class="hidden-element">
                                </td>
                                <td width="145" colspan="4" valign="top">
                                    <p align="center">
                                        M.díj
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="357" colspan="12" valign="top">
                                    <p>
                                        <textarea name="rovid_leiras" id="rovid_leiras" class="rovid_leiras"
                                            required="required"></textarea>
                                    </p>
                                </td>
                                <td width="148" colspan="5" valign="top">
                                </td>
                                <td width="145" colspan="4" valign="top">
                                    <p align="center">
                                        <input name="munkadij" type="text" id="munkadij" class="munkadij"
                                            required="required">
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
                                </td>
                                <td width="0" valign="top" class="hidden-element">
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
                                <td width="54" valign="top" class="hide-on-small-screen">
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
                                <td width="86" colspan="2" valign="top">
                                    <p align="center">
                                        Egységár
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="101" colspan="2" valign="top">
                                    <p>
                                        <textarea name="megnevezes" id="megnevezes" class="megnevezes"
                                            required="required"></textarea>
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
                                        <input name="egysegar" type="text" id="egysegar" size="15" class="egysegar"
                                            required="required">
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
                                        <?php date_default_timezone_set('Europe/Budapest');
                                        echo '<font color="blue">' . $date = date("Y-m-d") . '</font>' ?>
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
                    </table> <br>
                    <center>

                        <input type="submit" value="Feldolgozás" name="save">
                    </center>
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

                    include('config.php');
                    $pdo = new PDO("mysql:host=localhost;dbname=autoszerelo_munkalapok", $user, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->exec("SET NAMES 'utf8mb4'");


                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $gyartasi_ev = $_POST['gyartasi_ev'] ?? '';
                        $gyartmany = $_POST['gyartmany'] ?? '';
                        $szin = $_POST['szin'] ?? '';
                        $tulajdonos_neve = $_POST['tulajdonos_neve'] ?? '';
                        $cime = $_POST['cime'] ?? '';
                        $rendszam = $_POST['rendszam'] ?? '';
                        $oraallas = $_POST['oraallas'] ?? '';
                        $uzemanyagszint = $_POST['uzemanyagszint'] ?? '';
                        $rovid_leiras = $_POST['rovid_leiras'] ?? '';
                        $ok = $_POST['ok'] ?? '';
                        $ev = $_POST['ev'] ?? '';
                        $honap_nap = $_POST['honap_nap'] ?? '';
                        $munkadij = $_POST['munkadij'] ?? '';
                        $egysegar = $_POST['egysegar'] ?? '';
                        $megnevezes = $_POST['megnevezes'] ?? '';


                        if (!preg_match('/^([0-9]{2})\.([0-9]{2})$/', $_POST['honap_nap'], $matches)) {
                            echo "Hiba: A dátum formátuma érvénytelen!";

                        } else {
                            $honap = (int) $matches[1];
                            $nap = (int) $matches[2];

                            if ($honap < 1 || $honap > 12) {
                                echo "Hiba: A hónap érvénytelen!";

                            } elseif ($honap == 2 && ($nap < 1 || $nap > 28)) {
                                echo "Hiba: Februárban a napnak 1 és 28 közötti számnak kell lennie!";

                            } elseif (in_array($honap, [4, 6, 9, 11]) && ($nap < 1 || $nap > 30)) {
                                echo "Hiba: A hónapnak 30 napja van!";

                            } elseif ($nap < 1 || $nap > 31) {
                                echo "Hiba: A nap érvénytelen!";

                            } else {
                                if (!is_int($honap) || !is_int($nap)) {
                                    echo "Hiba: Az értékeknek egész számnak kell lennie!";

                                } else {
                                    $now = time();
                                    $min_date = strtotime('-30 days');
                                    $input_date = strtotime(date('Y') . '-' . $honap . '-' . $nap);

                                    if ($input_date < $min_date || $input_date > $now) {
                                        echo "Hiba: A dátumnak az elmúlt 30 napban kell lennie!";

                                    }
                                }
                            }
                        }

                        if (empty($tulajdonos_neve)) {
                            echo "Hiba: A név mező kitöltése kötelező!";
                        } elseif (!preg_match("/^[a-zA-ZáéíóúüűőöÁÉÍÓÚÜŰŐÖ\- ]*$/", $tulajdonos_neve)) {
                            echo "Hiba: A név csak betűket és szóközt tartalmazhat!";
                        } elseif (empty($rendszam)) {
                            echo "Hiba: A rendszám mező kitöltése kötelező!";
                        } elseif (!preg_match("/^[A-Z]{3}-[0-9]{3}$/", $rendszam)) {
                            echo "Hiba: A rendszám nem megfelelő formátumú (pl. ABC-123)!";
                        } elseif (empty($cime)) {
                            echo "Hiba: A cím mező kitöltése kötelező!";
                        } elseif (!preg_match("/^[a-zA-ZáéíóúüűőöÁÉÍÓÚÜŰŐÖ0-9 .,-]*$/", $cime)) {
                            echo "Hiba: A cím csak betűket, számokat, szóközöket, vesszőket és ékezeteket tartalmazhat!";
                        } elseif (empty($szin)) {
                        } elseif (!preg_match("/^[a-zA-ZáéíóúüűőöÁÉÍÓÚÜŰŐÖ0-9 .,-]*$/", $szin)) {
                            echo "Hiba: az autó színe csak betűket, számokat, kötőjelet, aláhúzást és szóközt tartalmazhat!";
                        } elseif (empty($gyartmany)) {
                            echo "Hiba: A gyártmány mező kitöltése kötelező!";
                        } elseif (!preg_match("/^[a-zA-ZáéíóúüűőöÁÉÍÓÚÜŰŐÖ0-9 .,-]*$/", $gyartmany)) {
                            echo "Hiba: Az autó gyártmánya csak betűket, számokat, kötőjelet, aláhúzást és szóközt tartalmazhat!";
                        } elseif (empty($oraallas)) {
                            echo "Hiba: Az óraállás mező kitöltése kötelező!";
                        } elseif (!preg_match("/^[a-zA-Z0-9\-_ ]*$/", $oraallas)) {
                            echo "Hiba: Az óraállás csak betűket, számokat, kötőjelet, aláhúzást és szóközt tartalmazhat!";
                        } elseif (empty($gyartasi_ev)) {
                            echo "Hiba: A gyártási év mező kitöltése kötelező!";

                        } elseif (!preg_match("/^[0-9]*$/", $gyartasi_ev)) {
                            echo "Hiba: A gyártási év mező csak számokat tartalmazhat!";

                        } elseif (empty($uzemanyagszint)) {
                            echo "Hiba: Az üzemanyagszint mező kitöltése kötelező!";

                        } elseif (!in_array($uzemanyagszint, ['1/4', '2/4', '3/4', '4/4'])) {
                            echo "Hiba: Kérem válasszon a megadott üzemanyagszintek közül!";

                        } elseif (empty($_POST['ok'])) {
                            echo "Hiba: Az ok mező kitöltése kötelező!";

                        } elseif (strlen($_POST['ok']) > 1000) {
                            echo "Hiba: Az ok mező maximális hossza 1000 karakter lehet!";

                        } elseif (empty($_POST['rovid_leiras'])) {
                            echo "Hiba: A rövid leírás mező kitöltése kötelező!";

                        } elseif (strlen($_POST['rovid_leiras']) > 1000) {
                            echo "Hiba: A rövid leírás mező maximális hossza 1000 karakter lehet!";

                        } elseif (empty($_POST['megnevezes'])) {
                            echo "Hiba: A megnevezés mező kitöltése kötelező!";

                        } elseif (strlen($_POST['megnevezes']) > 1000) {
                            echo "Hiba: A megnevezés mező maximális hossza 1000 karakter lehet!";

                        } elseif (empty($_POST['munkadij'])) {
                            echo "Hiba: A munkadíj mező kitöltése kötelező!";

                        } elseif (!preg_match('/^[0-9\s.-]+$/', $munkadij)) {
                            echo 'Hiba: A munkadíj mező csak számokat, szóközöket és a "-" karaktert tartalmazhat!';

                        } elseif (empty($_POST['egysegar'])) {
                            echo "Hiba: Az egységár mező kitöltése kötelező!";

                        } elseif (!preg_match('/^[0-9\s.-]+$/', $egysegar)) {
                            echo 'Hiba: Az egységár mező csak számokat, szóközöket és a "-" karaktert tartalmazhat!';

                        } elseif (empty($_POST['ev'])) {
                            echo "Hiba: Az év mező kitöltése kötelező!";

                        } elseif (!preg_match("/^[0-9]*$/", $ev)) {
                            echo "Hiba: Az év mező csak számokat tartalmazhat!";

                        } elseif (empty($_POST['honap_nap'])) {
                            echo "Hiba: A dátum mező kitöltése kötelező!";

                        } else {
                            if (empty($_POST['gyartasi_ev']) || empty($_POST['gyartmany']) || empty($_POST['szin']) || empty($_POST['tulajdonos_neve']) || empty($_POST['cime']) || empty($_POST['rendszam']) || empty($_POST['oraallas']) || empty($_POST['uzemanyagszint']) || empty($_POST['rovid_leiras']) || empty($_POST['ok']) || empty($_POST['ev']) || empty($_POST['honap_nap']) || empty($_POST['munkadij']) || empty($_POST['egysegar']) || empty($_POST['megnevezes'])) {
                                echo "<center>Minden mező kitöltése kötelező!</center>";

                                exit();
                            } else {
                                $gyartasi_ev = filter_input(INPUT_POST, 'gyartasi_ev', FILTER_SANITIZE_STRING);
                                $gyartmany = filter_input(INPUT_POST, 'gyartmany', FILTER_SANITIZE_STRING);
                                $szin = filter_input(INPUT_POST, 'szin', FILTER_SANITIZE_STRING);
                                $tulajdonos_neve = filter_input(INPUT_POST, 'tulajdonos_neve', FILTER_SANITIZE_STRING);
                                $cime = filter_input(INPUT_POST, 'cime', FILTER_SANITIZE_STRING);
                                $rendszam = filter_input(INPUT_POST, 'rendszam', FILTER_SANITIZE_STRING);

                                $oraallas = filter_input(INPUT_POST, 'oraallas', FILTER_SANITIZE_STRING);
                                $uzemanyagszint = filter_input(INPUT_POST, 'uzemanyagszint', FILTER_SANITIZE_STRING);
                                $rovid_leiras = filter_input(INPUT_POST, 'rovid_leiras', FILTER_SANITIZE_STRING);
                                $ok = filter_input(INPUT_POST, 'ok', FILTER_SANITIZE_STRING);
                                $ev = filter_input(INPUT_POST, 'ev', FILTER_SANITIZE_STRING);
                                $honap_nap = filter_input(INPUT_POST, 'honap_nap', FILTER_SANITIZE_STRING);
                                $munkadij = filter_input(INPUT_POST, 'munkadij', FILTER_SANITIZE_STRING);
                                $egysegar = filter_input(INPUT_POST, 'egysegar', FILTER_SANITIZE_STRING);
                                $megnevezes = filter_input(INPUT_POST, 'megnevezes', FILTER_SANITIZE_STRING);
                                date_default_timezone_set('Europe/Budapest');
                                $date = date("Y-m-d");
                                $parancs = "INSERT INTO autok (gyartasi_ev, gyartmany, szin, tulajdonos_neve, cime, rendszam) VALUES (?, ?, ?, ?, ?, ?)";
                                $stmt = $pdo->prepare($parancs);
                                $stmt->execute(array($gyartasi_ev, $gyartmany, $szin, $tulajdonos_neve, $cime, $rendszam));
                                $autoid = $pdo->lastInsertId();
                                $parancs = "INSERT INTO munkalapok (oraallas, uzemanyagszint, rovid_leiras, ok, ev, honap_nap, munkadij, egysegar, megnevezes ,auto_id ,datum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = $pdo->prepare($parancs);
                                $stmt->execute(array($oraallas, $uzemanyagszint, $rovid_leiras, $ok, $ev, $honap_nap, $munkadij, $egysegar, $megnevezes, $autoid, $date));

                                if ($stmt->rowCount() > 0) {
                                    echo "Adatok sikeresen mentve";
                                    header("location: summary.php?gyartasi_ev=$gyartasi_ev&gyartmany=$gyartmany&szin=$szin&tulajdonos_neve=$tulajdonos_neve&cime=$cime&rendszam=$rendszam&oraallas=$oraallas&uzemanyagszint=$uzemanyagszint&rovid_leiras=$rovid_leiras&ok=$ok&ev=$ev&honap_nap=$honap_nap&munkadij=$munkadij&egysegar=$egysegar&megnevezes=$megnevezes&date=$date");
                                    exit();
                                } else {
                                    echo "Hiba az adatok mentésekor";
                                }
                            }
                            ob_end_flush();
                            $output = ob_get_contents();
                            ob_end_clean();
                            echo $output;
                        }
                    }
                    ?>

            </div>
        </div>
        </div>

        </div>
        </div>
    </section>


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
        });    </script>


</body>

</html>