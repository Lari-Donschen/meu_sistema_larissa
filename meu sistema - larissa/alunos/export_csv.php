<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../auth/functions.php';
requer_autenticacao();

// Obtém os filtros de busca, se houver
$busca = isset($_GET['q']) ? trim($_GET['q']) : '';
$sql = "SELECT id, nome, email, data_nascimento, criado_em FROM alunos";
$params = [];

if ($busca !== '') {
  $sql .= " WHERE nome LIKE :q OR email LIKE :q";
  $params[':q'] = '%' . $busca . '%';
}
$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$alunos = $stmt->fetchAll();

// Define o nome do arquivo
$filename = 'alunos_' . date('Y-m-d_His') . '.csv';

// Define os headers para download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Cria o output stream
$output = fopen('php://output', 'w');

// Adiciona BOM para UTF-8 (para o Excel reconhecer corretamente)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Cabeçalhos do CSV
fputcsv($output, ['ID', 'Nome', 'E-mail', 'Data de Nascimento', 'Criado em'], ';');

// Adiciona os dados
foreach ($alunos as $aluno) {
  $data_nasc = $aluno['data_nascimento'] ? date('d/m/Y', strtotime($aluno['data_nascimento'])) : '';
  $criado_em = date('d/m/Y H:i', strtotime($aluno['criado_em']));
  
  fputcsv($output, [
    $aluno['id'],
    $aluno['nome'],
    $aluno['email'],
    $data_nasc,
    $criado_em
  ], ';');
}

fclose($output);
exit;