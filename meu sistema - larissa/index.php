<?php include __DIR__ . '/includes/header.php'; ?>
<div class="card">
  <h1>Bem-vindo</h1>
  <p>Este é o meu mini-sistema PHP com PDO + MySQL. Use o menu acima para acessar a área de Alunos.</p>
</div>
<div class="card">
  <h2>Atalhos</h2>
  <div class="actions">
    <a class="btn primary" href="/alunos/create.php">Cadastrar aluno</a>
    <a class="btn" href="/alunos/index.php">Listar alunos</a>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>