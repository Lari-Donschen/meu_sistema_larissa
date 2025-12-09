<?php
require_once __DIR__ . '/../config/db.php';

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$data = $_POST['data_nascimento'] ?? null;

if ($nome === '' || $email === '') {
  header('Location: /alunos/create.php');
  exit;
}

try {
  $sql = "INSERT INTO alunos (nome, email, data_nascimento) VALUES (:nome, :email, :data)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':nome', $nome);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':data', $data ?: null);
  $stmt->execute();
  header('Location: /alunos/index.php');
} catch (PDOException $e) {
  // e-mail duplicado, etc.
  header('Location: /alunos/create.php');
}