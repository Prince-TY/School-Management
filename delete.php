<?php
require_once __DIR__ . "/config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['delete'])) {
    http_response_code(405);
    exit("Invalid request.");
}

$idInput = (string) ($_POST['id'] ?? '');

if (!ctype_digit($idInput) || (int) $idInput < 1) {
    http_response_code(400);
    exit("Invalid student ID.");
}

$id = (int) $idInput;

$stmt = $conn->prepare("DELETE FROM students WHERE id = :id");
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() === 0) {
    http_response_code(404);
    exit("Student not found.");
}

header("Location: index.php?deleted=1");
exit();
