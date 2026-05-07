<?php
session_start();
require_once 'class_user.php';
try {
    $felh = new User();
} catch (Exception $e) {
    echo $e->getMessage();
}
if (isset($_POST['submit'])) {
    $emailVagyNev = $_POST['emailVagyNev'] ?? '';
    $jelszo = $_POST['jelszo'] ?? '';
    $login = $felh->bejelentkezes($emailVagyNev, $jelszo);
    if ($login) {
        // sikeres bejelentkezés
        header("location:home.php");
        exit;
    } else {
        // sikertelen
        $uzenet = "Hibás felhasználónév vagy jelszó!";
        echo "<script>alert(" . json_encode($uzenet) . ");</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="hu-HU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="style.css">
    <script src="login.js"></script>
</head>

<body>
    <main>

        <h1>Bejelentkezés</h1>

        <form action="" method="POST">

            <label for="en">
                E-mail vagy felhasználónév:
                <input
                    type="text"
                    id="en"
                    name="emailVagyNev"
                    required
                    minlength="2">
            </label>

            <label for="j">
                Jelszó:
                <input
                    type="password"
                    id="j"
                    name="jelszo"
                    required>
            </label>

            <button type="submit" name="submit">
                Belépés
            </button>

        </form>

        <a href="registration.php">
            Regisztráció
        </a>

    </main>
</body>

</html>