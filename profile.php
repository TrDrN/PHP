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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Főoldal</title>
    <link rel="shortcut icon" type="image/x-icon" href="/pictures/logo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>



    <style>
        
        body{
    margin-top:20px;
    background:#f8f8f8
}
    </style>
</head>


<body style="margin:0;">


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
            </div>
            <img src="/pictures/profile.png" alt="" title="">
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil-file-edit-alt"></i>
                    <span class="text">Profil szerkesztés</span>
                </div>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $new_username = $_POST["new_username"];
                    $new_password = $_POST["new_password"];

                    
                    $sql = "UPDATE users SET username = :new_username, password = :new_password WHERE felhasználó_id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':new_username', $new_username);
                    $stmt->bindParam(':new_password', $new_password);
                    $stmt->bindParam(':username', $_SESSION['login_user']);
                    $stmt->execute();
                }

                
                $sql = "SELECT * FROM users JOIN users_data ON users.felhasználó_id = users_data.felhasználó_id WHERE users.felhasználó_id = users_data.felhasználó_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $_SESSION['login_user']);
                $stmt->execute();
                ?>

                <div class="container">

                <?php
                        include("config.php");
                        $username = $_SESSION['login_user'];
                        $sql = "SELECT * FROM users JOIN users_data ON users.felhasználó_id = users_data.felhasználó_id WHERE users.felhasználó_id = users_data.felhasználó_id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(':username' => $username));
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
  <div class="col">
    <div class="row">
      <div class="col mb-3">
        <div class="card">
          <div class="card-body">
            <div class="e-profile">
              <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                      <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $row['nev'] ?></h4>
                    <div class="text-muted"><small>Last seen 2 hours ago</small></div>
                    <div class="mt-2">
                      <button class="btn btn-primary" type="button">
                        <i class="fa fa-fw fa-camera"></i>
                        <span>Kép csere</span>
                      </button>
                    </div>
                  </div>
                  <div class="text-center text-sm-right">
                    <span class="badge badge-secondary"><?php echo $row['permission'] ?></span>
                    <div class="text-muted"><small>Lérehozás dátuma <?php echo $row['datum'] ?></small></div>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="" class="active nav-link">Szerkesztés</a></li>
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                  <form class="form" novalidate="" action="" method="post">
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Név</label>
                              <input class="form-control" type="text" name="name" placeholder="Név" value="<?php echo $row['nev'] ?>">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label>Felhasználónév</label>
                              <input class="form-control" type="text" name="username" placeholder="Felhasználónév" value="<?php echo $row['username'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Email</label>
                              <input class="form-control" type="text" placeholder="teszt@teszt.com" value="<?php echo $row['email'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label>Rólam</label>
                              <textarea class="form-control" rows="5" placeholder="Rólam"><?php echo $row['rolam'] ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-6 mb-3">
                        <div class="mb-2"><b>Jelszó csere</b></div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Jelenlegi jelszó</label>
                              <input class="form-control" type="password" placeholder="••••••" value="<?php echo $row['password'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Új jelszó</label>
                              <input class="form-control" type="password" placeholder="••••••">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Új jelszó <span class="d-none d-xl-inline">mégegyszer</span></label>
                              <input class="form-control" type="password" placeholder="••••••"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                        
                        <div class="row">
                          <div class="col">
                            
                            <div class="custom-controls-stacked px-2">
                              <div class="custom-control custom-checkbox">
                                
                              </div>
                              <div class="custom-control custom-checkbox">
                                
                              </div>
                              <div class="custom-control custom-checkbox">
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Mentés</button>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3 mb-3">
        <div class="card mb-3">
          <div class="card-body">
            <div class="px-xl-3">
              <button class="btn btn-block btn-secondary">
                <i class="fa fa-sign-out"></i>
                <span  onclick="location.href='logout.php'">Kilépés</span>
              </button>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h6 class="card-title font-weight-bold">Support</h6>
            <p class="card-text">Barátságos asszisztenseink gyors és ingyenes segítséget nyújtanak.</p>
            <button type="button" class="btn btn-primary">Kapcsolatfelvétel</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
<?php
}
?>
<?php
                if ($stmt->errorCode() != "00000") {
                    $error = implode(":", $stmt->errorInfo());
                    echo "Error: " . $error;
                }
                ?>
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
        });



    </script>
</body>

</html>