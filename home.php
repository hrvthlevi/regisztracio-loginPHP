<?php
session_start();
require_once 'class_user.php';

try {
    $felh = new User();
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

// biztonságos lekérés
$felhAzon = $_SESSION['felhAzon'] ?? NULL;
// logout kezelés
if (isset($_GET['q']) && $_GET['q'] === 'logout') {
    $felh->kijelentkezes();
    header("Location: login.php");
    exit;
}

// ha nincs bejelentkezve → login
if (!$felh->get_session()) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="hu-HU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <div>
            <a href="home.php?q=logout">LOGOUT</a>
        </div>

        <div>
            <h1>Hello <?php echo  $felh->get_nev($felhAzon) ?>!</h1>
        </div>

        <?php
            if ($felh->isAdmin($felhAzon)) {
            echo "<h2>Bejelentkezett felhasználók:</h2>";
            $matrix = $felh->aktivok();
            $felh->megjelenit_aktivok($matrix);
        }  
        ?>
    </main>
</body>

</html>