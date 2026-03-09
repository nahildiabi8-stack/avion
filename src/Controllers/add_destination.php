<?php
require_once __DIR__ . '/../Managers/Manager.php';

$manager = new Manager();
$manager->createDestination($_POST['location'], (int) $_POST['price'], (int) $_POST['tour_operator_id']);

header('Location: ../../public/Admin.php');

exit;