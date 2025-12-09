<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';

// Se já estiver autenticado, redireciona para home
if (esta_autenticado()) {
    header('Location: /index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if ($email === '' || $senha === '') {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch();
            
            if ($usuario && verificar_senha($senha, $usuario['senha'])) {
                fazer_login($usuario['id'], $usuario['nome'], $usuario['email']);
                header('Location: /index.php');
                exit;
            } else {
                $erro = 'E-mail ou senha incorretos.';
            }
        } catch (PDOException $e) {
            $erro = 'Erro ao processar login. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Mini-sistema PHP</title>
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
        <h1>Mini-sistema PHP</h1>
        <p>Faça login para continuar</p>
      </div>
      
      <?php if ($erro): ?>
        <div class="alert-error"><?php echo htmlspecialchars($erro); ?></div>
      <?php endif; ?>
      
      <form method="post" action="/auth/login.php">
        <div class="form-group">
          <label for="email">E-mail</label>
          <input class="input" type="email" id="email" name="email" required 
                 value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                 autofocus>
        </div>
        
        <div class="form-group">
          <label for="senha">Senha</label>
          <input class="input" type="password" id="senha" name="senha" required>
        </div>
        
        <div class="form-group">
          <button class="btn primary" type="submit" style="width: 100%;">Entrar</button>
        </div>
      </form>
      
      <div class="login-footer">
        <p>Não tem uma conta? <a href="/auth/register.php">Cadastre-se aqui</a></p>
        <p style="margin-top: 12px; font-size: 12px;">
          <strong>Usuário padrão:</strong> admin@sistema.com<br>
          <strong>Senha:</strong> admin123
        </p>
      </div>
    </div>
  </div>
</body>
</html>