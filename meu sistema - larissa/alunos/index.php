<?php
require_once __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

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
?>
<div class="card">
  <h2>Alunos</h2>
  <form class="search" method="get" action="/alunos/index.php">
    <input class="input" type="text" name="q" placeholder="Buscar por nome ou e-mail" value="<?php echo htmlspecialchars($busca); ?>">
    <button class="btn" type="submit">Buscar</button>
    <a class="btn" href="/alunos/index.php">Limpar</a>
    <a class="btn primary" href="/alunos/create.php">Novo Aluno</a>
  </form>
</div>

<div class="card">
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Nascimento</th>
        <th>Criado em</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($alunos as $a): ?>
        <tr>
          <td><?php echo (int)$a['id']; ?></td>
          <td><?php echo htmlspecialchars($a['nome']); ?></td>
          <td><?php echo htmlspecialchars($a['email']); ?></td>
          <td><?php echo htmlspecialchars($a['data_nascimento'] ?? ''); ?></td>
          <td><?php echo htmlspecialchars($a['criado_em']); ?></td>
          <td class="actions">
            <a class="btn" href="/alunos/edit.php?id=<?php echo (int)$a['id']; ?>">Editar</a>
            <form method="post" action="/alunos/delete.php" onsubmit="return confirm('Excluir este aluno?');" style="display:inline;">
              <input type="hidden" name="id" value="<?php echo (int)$a['id']; ?>">
              <button class="btn" type="submit">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($alunos)): ?>
        <tr><td colspan="6">Nenhum registro encontrado.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>