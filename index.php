<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('session.gc_maxlifetime', 600);
ini_set('session.cookie_lifetime ', 0);

include('session.php');


?>
<!doctype html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Főoldal</title>
    <link rel="shortcut icon" type="image/x-icon" href="/pictures/logo.png">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>


    <script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById("txt").innerHTML =
                h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) { i = "0" + i };
            return i;
        }
    </script>



</head>


<body style="margin:0;" onload="startTime()">


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
                <?php
                if (isset($_SESSION['login_user'])) {
                    $username = $_SESSION['login_user'];
                    $stmt = $pdo->prepare("SELECT permission FROM users WHERE username = :username");
                    $stmt->execute(['username' => $username]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $permission = $row['permission'];
                }
                if ($permission === 'admin'): ?>
                    <li><a href="new.php">
                            <i class="uil uil-files-landscapes"></i>
                            <span class="link-name">Felvétel</span>
                        </a>
                    </li>
                <?php endif; ?>
                
            </ul>
            
            <ul class="logout-mode">
                <li><a href="profile.php">
                        <i class="uil-info-circle"></i>
                        <span class="link-name">Profil információ</span>
                    </a></li>
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

            <div class="search-box">
                <i class="uil uil-search"></i>
                <form class="form-inline" method="post" action="search.php">
                    <input type="text" placeholder="Adja meg a rendszámot...." name="kereses">
                </form>
            </div>
            <img src="/pictures/profile.png" alt="" title="" onclick="showMenu()">
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast"></i>
                    <span class="text">Irányítópult</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-car-sideview"></i>
                        <span class="text">Autók száma:</span>
                        <?php
                        include('config.php');
                        $dbh = new PDO("mysql:host=localhost;dbname=autoszerelo_munkalapok", $user, $password);
                        $parancs = "SELECT COUNT(*) FROM autok";
                        $result = $dbh->query($parancs);
                        while ($sor = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <span class="number">
                                <?= $sor['COUNT(*)']; ?>
                            </span>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-notebooks"></i>
                        <span class="text">Munkalapok száma:</span>
                        <?php
                        include('config.php');
                        $dbh = new PDO("mysql:host=localhost;dbname=autoszerelo_munkalapok", $user, $password);
                        $parancs = "SELECT COUNT(*) FROM munkalapok";
                        $result = $dbh->query($parancs);
                        while ($sor = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <span class="number">
                                <?= $sor['COUNT(*)']; ?>
                            </span>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="box box3">
                        <i class="uil uil-clock"></i>
                        <span class="text">Jelenglegi idő:</span>

                        <span class="number">
                            <div id="txt"></div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Utoljára felvitt autók/munkalapok:</span>

                </div>
                <?php
                include('config.php');

                if (isset($_SESSION['login_user'])) {
                    $username = $_SESSION['login_user'];
                    $stmt = $pdo->prepare("SELECT permission FROM users WHERE username = :username");
                    $stmt->execute(['username' => $username]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $permission = $row['permission'];
                }

                $stmt = $pdo->prepare("SELECT * FROM autok ORDER BY auto_id DESC");
                $pdo->query("SET NAMES 'utf8mb4'");
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $row) {
                    ?>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tulajdonos neve</th>
                                    <th>Autó gyártmánya</th>
                                    <th>Autó rendszáma</th>
                                    <?php if (isset($permission) && $permission == 'admin') { ?>
                                        <th>Megtekintés</th>
                                        <th>Szerkesztés</th>
                                        <th>Törlés</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Tulajdonos neve">
                                        <?= $row['tulajdonos_neve']; ?>
                                    </td>
                                    <td data-label="Autó gyártmánya">
                                        <?= $row['gyartmany']; ?>
                                    </td>
                                    <td data-label="Autó rendszáma">
                                        <?= $row['rendszam']; ?>
                                    </td>
                                    <?php if (isset($permission) && $permission == 'admin') { ?>
                                        <td data-label="Megtekintés"><a href="view.php?id=<?= $row["auto_id"]; ?>"
                                                class="btn">Megtekintés</a></td>
                                        <td data-label="Szerkesztés"><a href="modify.php?id=<?= $row["auto_id"]; ?>"
                                                class="btn">Szerkesztés</a></td>
                                        <td data-label="Törlés"><a class="btn"
                                                onclick="deleteConfirm(<?= $row['auto_id']; ?>)">Törlés</a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <script>
        function deleteConfirm(id) {
            if (confirm("Biztos törölni akarod a kiválasztott autót/munkalapot?")) {
                location.href = 'delete.php?id=' + id;
            }
        }
    </script>

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

</html>