<?php

require_once 'Database.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!is_numeric($id)) {
    http_response_code(400);
    echo json_encode([
        'status'  => false,
        'message' => 'Debe indicar un id de lote válido',
    ]);
    exit;
}

Database::setDB();

$cnx = Database::getConnection();
$stmt = $cnx->prepare("SELECT * FROM debts WHERE id = :id");
$stmt->bindValue(':id', (int) $id, SQLITE3_INTEGER);
$result = $stmt->execute();

$lote = $result->fetchArray(SQLITE3_ASSOC);

if (!$lote) {
    http_response_code(404);
    echo json_encode([
        'status'  => false,
        'message' => 'Lote no encontrado',
    ]);
    exit;
}

http_response_code(200);
echo json_encode([
    'status'  => true,
    'message' => 'Lote encontrado',
    'data'    => $lote,
]);