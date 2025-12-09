<?php
require_once __DIR__ . '/../config/db.php';

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
  $stmt = $pdo->prepare("DELETE FROM alunos WHERE id = :id");
  $stmt->execute([':id' => $id]);
}
header('Location: /alunos/index.php');