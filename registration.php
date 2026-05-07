<?php
require_once 'class_user.php';

session_start();

try {
    $felh = new User();
} catch (Exception $e) {
    echo $e->getMessage();
}

if (isset($_POST['submit'])) {
    $nev = $_POST['nev'] ?? '';
    $email = $_POST['email'] ?? '';
    $jelszo = $_POST['jelszo'] ?? '';

    $register = $felh->reg_felhasznalo($nev, $email, $jelszo);

    if (!$register) {
        echo "<script>alert('Sikertelen regisztráció');</script>";
    } else {
        $login = $felh->bejelentkezes($nev, $jelszo);

        if ($login) {
            header("Location: home.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu-HU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <main>

        <h1>Regisztráció</h1>

        <form action="" method="POST">

            <label for="n">
                Név:
                <input 
                    type="text" 
                    id="n" 
                    name="nev" 
                    required 
                    pattern=".{2,}"
                    title="Legalább 2 karakter"
                >
            </label>

            <label for="e">
                E-Mail:
                <input 
                    type="email" 
                    id="e" 
                    name="email" 
                    required
                >
            </label>

            <label for="j">
                Jelszó:
                <input 
                    type="password" 
                    name="jelszo" 
                    id="j" 
                    required 
                    pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#?!@$%^&*-]).{8,}$"
                >
            </label>

            <button type="submit" name="submit">Küldés</button>

        </form>

        <a href="login.php">Bejelentkezés</a>

    </main>

</body>

</html>