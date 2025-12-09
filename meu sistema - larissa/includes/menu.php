<?php
$usuario = usuario_logado();
?>
<header class="topbar">
  <div class="brand">Mini-sistema PHP</div>
  <nav class="nav">
    <a href="/index.php">Início</a>
    <a href="/alunos/index.php">Alunos</a>
    <?php if ($usuario): ?>
      <span style="margin-left: 14px; color: #666;">Olá, <?php echo htmlspecialchars(explode(' ', $usuario['nome'])[0]); ?>!</span>
      <a href="/auth/logout.php" style="color: #c33;">Sair</a>
    <?php endif; ?>
  </nav>
</header>