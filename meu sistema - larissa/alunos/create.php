<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="card">
  <h2>Novo Aluno</h2>
  <form method="post" action="/alunos/store.php">
    <div class="form-row">
      <div>
        <label>Nome</label>
        <input class="input" type="text" name="nome" required>
      </div>
      <div>
        <label>E-mail</label>
        <input class="input" type="email" name="email" required>
      </div>
    </div>
    <div class="mt-3">
      <label>Data de nascimento</label>
      <input class="input" type="date" name="data_nascimento">
    </div>
    <div class="mt-4 actions">
      <button class="btn primary" type="submit">Salvar</button>
      <a class="btn" href="/alunos/index.php">Cancelar</a>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>