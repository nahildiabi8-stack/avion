<?php
session_start();
require_once __DIR__ . '/../Managers/Manager.php';

$manager = new Manager();
$author = $manager->getAuthorByName($_POST['nom'], $_POST['prenom']);

if ($author) {
    $_SESSION['author_id'] = $author->getId();
    header('Location: ../../public/main.php');
} else {
    header('Location: ../../Register.php');
}
exit;