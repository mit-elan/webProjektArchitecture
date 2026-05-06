<?php
require_once __DIR__ . '/businesslogic/requestHandler.php';
require_once __DIR__ . '/db/dbaccess.php';

header('Content-Type: application/json');

$handler = $_GET['handler'] ?? $_POST['handler'] ?? '';
$method  = $_GET['method']  ?? $_POST['method']  ?? '';

$data = json_decode(file_get_contents('php://input'), true) ?? [];


$requestHandler = new RequestHandler(new dbaccess());
$result = $requestHandler->dispatch($handler, $method, $data);

if ($result === null) {
    response(400, ['error' => 'Unknown handler or method']);
} else if (isset($result['code'])) {
    response($result['code'], ['error' => $result['error']]);
} else {
    response(200, $result);
}


function response(int $httpStatus, array $data): void
{
    http_response_code($httpStatus);
    echo json_encode($data);
}
