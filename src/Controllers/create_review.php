<?php
require_once __DIR__ . '/../Managers/Manager.php';

$grade = (int) $_POST['grade'];
if ($grade < 1 || $grade > 5) {
    die('Note invalide. Veuillez choisir entre 1 et 5 étoiles.');
}

$manager = new Manager();

// Crée l'auteur et récupère son id
$authorId = $manager->createAuthor($_POST['nom'], '', 0, '');

// Crée la review avec le grade
$grade = isset($_POST['grade']) ? (int) $_POST['grade'] : 0;
$manager->createReview($_POST['message'], (int) $_POST['tour_operator_id'], $authorId, $grade);

// Redirige vers la destination
header('Location: ../../public/Destination.php?id=' . $_POST['destination_id']);
exit;
