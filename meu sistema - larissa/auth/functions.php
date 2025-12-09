<?php
// Inicia a sessão se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica se o usuário está autenticado
 */
function esta_autenticado() {
    return isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] > 0;
}

/**
 * Obtém os dados do usuário logado
 */
function usuario_logado() {
    if (!esta_autenticado()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['usuario_id'],
        'nome' => $_SESSION['usuario_nome'] ?? '',
        'email' => $_SESSION['usuario_email'] ?? ''
    ];
}

/**
 * Redireciona para login se não estiver autenticado
 */
function requer_autenticacao() {
    if (!esta_autenticado()) {
        header('Location: /auth/login.php');
        exit;
    }
}

/**
 * Realiza o login do usuário
 */
function fazer_login($usuario_id, $nome, $email) {
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['usuario_email'] = $email;
    
    // Atualiza o último acesso
    global $pdo;
    $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_acesso = NOW() WHERE id = :id");
    $stmt->execute([':id' => $usuario_id]);
}

/**
 * Realiza o logout do usuário
 */
function fazer_logout() {
    $_SESSION = [];
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

/**
 * Valida email
 */
function validar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Gera hash da senha
 */
function hash_senha($senha) {
    return password_hash($senha, PASSWORD_DEFAULT);
}

/**
 * Verifica se a senha corresponde ao hash
 */
function verificar_senha($senha, $hash) {
    return password_verify($senha, $hash);
}