<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = '';
  $password = '';

  if (isset($_POST['username'])) {
    $username = $_POST['username'];
  }

  if (isset($_POST['password'])) {
    $password = $_POST['password'];
  }


  $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['username' => $username, 'password' => $password]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
  
  if ($row) {

    $_SESSION['login_user'] = $username;
    header("location: index.php");
    exit();
  } else {
    
    header("Location: login.php?error=Hibás Felhasználónév vagy jelszó!");
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Bejelentkezés</title>
  <link rel="shortcut icon" type="image/x-icon" href="/pictures/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');

    * {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      height: 100vh;
      text-align: center;
      align-items: center;
      justify-content: center;
      background: #151515;
    }

    .login-form {
      position: relative;
      width: 370px;
      height: auto;
      background: #1b1b1b;
      padding: 40px 35px 60px;
      box-sizing: border-box;
      border: 1px solid black;
      border-radius: 5px;
      box-shadow: inset 0 0 1px #272727;
    }

    .text {
      font-size: 30px;
      color: #c7c7c7;
      font-weight: 600;
      letter-spacing: 2px;
    }

    form {
      margin-top: 40px;
    }

    form .field {
      margin-top: 20px;
      display: flex;
    }

    .field .fas {
      height: 50px;
      width: 60px;
      color: #868686;
      font-size: 20px;
      line-height: 50px;
      border: 1px solid #444;
      border-right: none;
      border-radius: 5px 0 0 5px;
      background: linear-gradient(#333, #222);
    }

    .field input,
    form button,
    input[type=submit] {
      height: 50px;
      width: 100%;
      outline: none;
      font-size: 19px;
      color: #868686;
      padding: 0 15px;
      border-radius: 0 5px 5px 0;
      border: 1px solid #444;
      caret-color: #339933;
      background: linear-gradient(#333, #222);
    }

    input:focus {
      color: #339933;
      box-shadow: 0 0 5px rgba(0, 255, 0, .2),
        inset 0 0 5px rgba(0, 255, 0, .1);
      background: linear-gradient(#333933, #222922);
      animation: glow .8s ease-out infinite alternate;
    }

    @keyframes glow {
      0% {
        border-color: #339933;
        box-shadow: 0 0 5px rgba(0, 255, 0, .2),
          inset 0 0 5px rgba(0, 0, 0, .1);
      }

      100% {
        border-color: #6f6;
        box-shadow: 0 0 20px rgba(0, 255, 0, .6),
          inset 0 0 10px rgba(0, 255, 0, .4);
      }
    }

    input[type=submit] {
      margin-top: 30px;
      border-radius: 5px !important;
      font-weight: 600;
      letter-spacing: 1px;
      cursor: pointer;
    }

    input[type=submit]:hover {
      color: #339933;
      border: 1px solid #339933;
      box-shadow: 0 0 5px rgba(0, 255, 0, .3),
        0 0 10px rgba(0, 255, 0, .2),
        0 0 15px rgba(0, 255, 0, .1),
        0 2px 0 black;
    }

    .link {
      margin-top: 25px;
      color: #868686;
    }

    .link a {
      color: #339933;
      text-decoration: none;
    }

    .link a:hover {
      text-decoration: underline;
    }

    .error {

      background: #F2DEDE;

      color: #0c0101;

      padding: 10px;

      width: 95%;

      border-radius: 5px;

      margin: 20px auto;

    }
  </style>
</head>

<body>
  <div class="login-form">
    <div class="text">
      Bejelentkezés
    </div>
    <form action="" method="post" name="Login_Form">

      <?php if (isset($_GET['error'])) { ?>

        <p class="error">
          <?php echo $_GET['error']; ?>
        </p>

      <?php } ?>


      <tr>
        <div colspan="2" align="center" valign="top"></div>
      </tr>
      <div class="field">
        <div class="fas fa-user-circle"></div>
        <input type="text" class="Input" placeholder="Felhasználónév" name="username" required="required">
      </div>
      <div class="field">
        <div class="fas fa-lock"></div>
        <input type="password" placeholder="Jelszó" class="Input" name="password" required="required">
      </div>
      <input name="Submit" type="submit" value="Bejelentkezés">
    </form>
  </div>
</body>

</html>