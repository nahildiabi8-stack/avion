<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($data['action'] === 'remove') {
    array_splice($_SESSION['cart'], (int) $data['index'], 1);
    echo json_encode(['cart' => array_values($_SESSION['cart'])]);
    exit;
}

// Ajout — vérifie doublon
$alreadyIn = array_filter(
    $_SESSION['cart'],
    fn($item) =>
    $item['operatorId'] === (int) $data['operatorId'] &&
        $item['destination'] === $data['destination']
);

if (empty($alreadyIn)) {
    $_SESSION['cart'][] = [
        'operatorId'   => (int) $data['operatorId'],
        'operatorName' => $data['operatorName'],
        'price'        => (int) $data['price'],
        'destination'  => $data['destination'],
    ];
}

echo json_encode(['cart' => array_values($_SESSION['cart'])]);
