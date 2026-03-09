<?php
require_once __DIR__ . '/../Managers/Manager.php';

$manager = new Manager();
$manager->createTourOperator($_POST['name'], $_POST['link'] ?? '');

header('Location: ../../public/Admin.php');
exit;