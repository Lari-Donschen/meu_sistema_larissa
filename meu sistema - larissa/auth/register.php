<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';

// Se já estiver autenticado, redireciona para home
if (esta_autenticado()) {
    header('Location: /index.php');
    exit;
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';
    
    // Validações
    if ($nome === '' || $email === '' || $senha === '' || $confirma_senha === '') {
        $erro = 'Por favor, preencha todos os campos.';
    } elseif (!validar_email($email)) {
        $erro = 'E-mail inválido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } elseif ($senha !== $confirma_senha) {
        $erro = 'As senhas não conferem.';
    } else {
        try {
            // Verifica se o e-mail já existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            
            if ($stmt->fetch()) {
                $erro = 'Este e-mail já está cadastrado.';
            } else {
                // Insere o novo usuário
                $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
                $stmt->execute([
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => hash_senha($senha)
                ]);
                
                $sucesso = 'Cadastro realizado com sucesso! Você será redirecionado para o login...';
                header("refresh:2;url=/auth/login.php");
            }
        } catch (PDOException $e) {
            $erro = 'Erro ao processar cadastro. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Mini-sistema PHP</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <style>
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    .login-card {
      background: white;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 32px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    }
    .login-header {
      text-align: center;
      margin-bottom: 24px;
    }
    .login-header h1 {
      color: var(--brand);
      margin: 0 0 8px 0;
    }
    .login-header p {
      color: #666;
      margin: 0;
    }
    .alert-error {
      background: #fee;
      border: 1px solid #fcc;
      color: #c33;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 16px;
    }
    .alert-success {
      background: #efe;
      border: 1px solid #cfc;
      color: #3c3;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 16px;
    }
    .form-group {
      margin-bottom: 16px;
    }
    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
    }
    .login-footer {
      text-align: center;
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
      color: #666;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1>Criar Conta</h1>
        <p>Preencha os dados para se cadastrar</p>
      </div>
      
      <?php if ($erro): ?>
        <div class="alert-error"><?php echo htmlspecialchars($erro); ?></div>
      <?php endif; ?>
      
      <?php if ($sucesso): ?>
        <div class="alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
      <?php endif; ?>
      
      <form method="post" action="/auth/register.php">
        <div class="form-group">
          <label for="nome">Nome completo</label>
          <input class="input" type="text" id="nome" name="nome" required 
                 value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>"
                 autofocus>
        </div>
        
        <div class="form-group">
          <label for="email">E-mail</label>
          <input class="input" type="email" id="email" name="email" required 
                 value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
          <label for="senha">Senha (mínimo 6 caracteres)</label>
          <input class="input" type="password" id="senha" name="senha" required>
        </div>
        
        <div class="form-group">
          <label for="confirma_senha">Confirmar senha</label>
          <input class="input" type="password" id="confirma_senha" name="confirma_senha" required>
        </div>
        
        <div class="form-group">
          <button class="btn primary" type="submit" style="width: 100%;">Cadastrar</button>
        </div>
      </form>
      
      <div class="login-footer">
        <p>Já tem uma conta? <a href="/auth/login.php">Faça login aqui</a></p>
      </div>
    </div>
  </div>
</body>
</html>