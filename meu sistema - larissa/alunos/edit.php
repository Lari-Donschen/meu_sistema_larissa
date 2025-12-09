<?php
require_once __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = :id");
$stmt->execute([':id' => $id]);
$aluno = $stmt->fetch();
if (!$aluno) {
  echo '<div class="card"><p>Aluno não encontrado.</p></div>';
  include __DIR__ . '/../includes/footer.php';
  exit;
}
?>
<div class="card">
  <h2>Editar Aluno</h2>
  <form method="post" action="/alunos/update.php">
    <input type="hidden" name="id" value="<?php echo (int)$aluno['id']; ?>">
    <div class="form-row">
      <div>
        <label>Nome</label>
        <input class="input" type="text" name="nome" required value="<?php echo htmlspecialchars($aluno['nome']); ?>">
      </div>
      <div>
        <label>E-mail</label>
        <input class="input" type="email" name="email" required value="<?php echo htmlspecialchars($aluno['email']); ?>">
      </div>
    </div>
    <div class="mt-3">
      <label>Data de nascimento</label>
      <input class="input" type="date" name="data_nascimento" value="<?php echo htmlspecialchars($aluno['data_nascimento'] ?? ''); ?>">
    </div>
    <div class="mt-4 actions">
      <button class="btn primary" type="submit">Atualizar</button>
      <a class="btn" href="/alunos/index.php">Cancelar</a>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>