<?php
require_once __DIR__ . '/../Managers/Manager.php';

$manager = new Manager();
$manager->updateOperatorToPremium((int) $_POST['tour_operator_id'], $_POST['signatory']);

header('Location: ../../public/Admin.php');
exit;
