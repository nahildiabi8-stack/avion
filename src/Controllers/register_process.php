<?php

declare(strict_types=1);

require '../../src/Entities/Author.php';
require '../../src/Managers/Manager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = (string) $_POST['nom'];
    $prenom = (string) $_POST['prenom'];
    $age = (int) $_POST['age'];
    $sexe = (string) $_POST['sexe'];

    $manager = new Manager();

    $authorId = $manager->createAuthor($nom, $prenom, $age, $sexe);
    $_SESSION['author_id'] = $authorId;

    header("Location: ../../public/main.php");
    exit;
} else {
    echo "Invalid request method.";
}
