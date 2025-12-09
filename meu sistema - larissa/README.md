# Mini-sistema PHP com PDO + MySQL (sem XAMPP)

Este é um mini-sistema educacional com CRUD de **Alunos**, usando **PHP nativo (servidor embutido)**, **PDO** e **MySQL**.

## Requisitos
- PHP 8+ instalado (com extensão pdo_mysql habilitada)
- MySQL Server instalado e em execução
- VS Code (opcional, recomendado)

## Banco de Dados
1. Crie o banco e tabelas executando o script SQL:
  ```bash
  # ajuste usuário e senha se necessário
  mysql -u root -p < database/schema.sql