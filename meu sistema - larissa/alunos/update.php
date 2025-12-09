<?php
require_once __DIR__ . '/../config/db.php';

$id = (int)($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$data = $_POST['data_nascimento'] ?? null;

if ($id <= 0 || $nome === '' || $email === '') {
  header('Location: /alunos/index.php');
  exit;
}

try {
  $sql = "UPDATE alunos SET nome = :nome, email = :email, data_nascimento = :data WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':nome', $nome);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':data', $data ?: null);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
} catch (PDOException $e) {
  // conflito de e-mail, etc.
}
header('Location: /alunos/index.php');