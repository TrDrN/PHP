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

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("config.php");
if (count($_POST) > 0) {
    $kereses = $_POST['kereses'];
    $pdo->exec("SET NAMES 'utf8mb4'");
    $parancs = ("SELECT * FROM autok JOIN munkalapok ON autok.auto_id = munkalapok.auto_id WHERE rendszam=:rendszam ORDER BY autok.auto_id DESC ");
    $stmt = $pdo->prepare($parancs);
    $stmt->bindParam(':rendszam', $kereses);
    if ($stmt->execute()) {
        $eredmeny = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error = $stmt->errorInfo();
        echo "Hiba: " . $error[2];
        exit();
    }
} else {
    echo "Nincs ilyen rendszám az adatbázisban!";
    exit();
}
?>
<!doctype html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Keresés</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="/pictures/logo.png">

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

            <div class="search-box">
                <i class="uil uil-search"></i>
                <form class="form-inline" method="post" action="search.php">
                    <input type="text" placeholder="Adja meg a rendszámot...." name="kereses">
                </form>
            </div>
            <img src="/pictures/profile.png" alt="" title="">
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="activity">
                    <div class="title">
                        <i class="uil uil-search"></i>
                        <span class="text">Keresési eredmény</span>
                    </div>
                    <?php
                    $i = 0;
                    foreach ($eredmeny as $sor) {
                        ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tulajdonos neve</th>
                                        <th>Autó gyártmánya</th>
                                        <th>Autó rendszáma</th>
                                        <th>Megtekintés</th>
                                        <th>Szerkesztés</th>
                                        <th>Törlés</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Tulajdonos neve">
                                            <?= $sor['tulajdonos_neve']; ?>
                                        </td>
                                        <td data-label="Autó gyártmánya">
                                            <?= $sor['gyartmany']; ?>
                                        </td>
                                        <td data-label="Autó rendszáma">
                                            <?= $sor['rendszam']; ?>
                                        </td>
                                        <td data-label="Megtekintés"><a href="view.php?id=<?= $sor["auto_id"]; ?>"
                                                class="btn">Megtekintés</a></td>
                                        <td data-label="Szerkesztés"><a href="modify.php?id=<?= $sor["auto_id"]; ?>"
                                                class="btn">Szerkesztés</a></td>
                                                <td data-label="Törlés"><a class="btn"
                                            onclick="deleteConfirm(<?= $sor['auto_id']; ?>)">Törlés</a>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        $i++;
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