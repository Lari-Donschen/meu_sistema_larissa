-- Criação do banco e tabelas
CREATE DATABASE IF NOT EXISTS meusistema CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE meusistema;

-- Tabela de alunos (já existe)
CREATE TABLE IF NOT EXISTS alunos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  data_nascimento DATE NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ✨ NOVA: Tabela de usuários para autenticação
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  ultimo_acesso TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dados de exemplo para alunos
INSERT INTO alunos (nome, email, data_nascimento) VALUES
('Ana Silva', 'ana@ifc.edu.br', '2003-05-10'),
('Bruno Souza', 'bruno@ifc.edu.br', '2002-11-22')
ON DUPLICATE KEY UPDATE nome=nome;

-- ✨ NOVO: Usuário administrador padrão
-- Senha: admin123
INSERT INTO usuarios (nome, email, senha) VALUES
('Administrador', 'admin@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE nome=nome;