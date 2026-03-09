<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['password'] === 'ok') {
        $_SESSION['is_admin'] = true;
        header('Location: ./Admin.php');
        exit;
    } else {
        echo 'Mauvais mot de passe';
    }
}
?>

<form method="POST">
    <input type="password" name="password" placeholder="Mot de passe admin">
    <button type="submit">Connexion</button>
</form>