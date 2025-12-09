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
  ```

## Funcionalidades Implementadas

### CRUD de Alunos
- ✅ Listar alunos com busca por nome/e-mail
- ✅ Cadastrar novo aluno
- ✅ Editar aluno existente
- ✅ Excluir aluno

### Sistema de Autenticação
- ✅ Login de usuários
- ✅ Registro de novos usuários
- ✅ Proteção de rotas (páginas protegidas)
- ✅ Logout

### Exportação de Dados
- ✅ **Exportar para CSV** - Gera arquivo CSV com os dados dos alunos
- ✅ **Exportar para PDF** - Gera relatório em PDF com os dados dos alunos

## Funcionalidades de Exportação

### Exportação CSV
- Formato compatível com Excel e LibreOffice Calc
- Utiliza ponto e vírgula (;) como delimitador
- Inclui BOM UTF-8 para compatibilidade
- Respeita filtros de busca aplicados
- Arquivo gerado: `alunos_YYYY-MM-DD_HHMMSS.csv`

**Arquivo:** `alunos/export_csv.php`

### Exportação PDF

#### Opção 1: PDF Simples (Sem biblioteca externa)
Gera um HTML formatado que pode ser salvo como PDF pelo navegador (Ctrl+P).

**Arquivo:** `alunos/export_pdf_simple.php`
- ✅ Não requer instalação de bibliotecas
- ✅ Funciona imediatamente
- ✅ Design profissional
- ✅ Respeita filtros de busca

#### Opção 2: PDF com TCPDF (Biblioteca externa)
Gera arquivo PDF diretamente no servidor usando a biblioteca TCPDF.

**Arquivo:** `alunos/export_pdf.php`

**Instalação do TCPDF:**
```bash
composer require tecnickcom/tcpdf
```

Ou se não tiver o Composer instalado:
```bash
# Instalar Composer (Windows)
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Depois instalar TCPDF
php composer.phar require tecnickcom/tcpdf
```

### Como Usar as Exportações

1. **Acesse a listagem de alunos:** `http://localhost:8000/alunos/index.php`

2. **Aplique filtros (opcional):** Use a busca para filtrar alunos específicos

3. **Clique no botão de exportação:**
   - **📊 Exportar CSV** - Download automático do arquivo CSV
   - **📄 Exportar PDF** - Abre relatório em nova aba (use Ctrl+P para salvar)

4. **Os dados exportados incluem:**
   - ID do aluno
   - Nome completo
   - E-mail
   - Data de nascimento
   - Data de cadastro

## Estrutura de Arquivos

```
meu sistema - larissa/
├── alunos/
│   ├── index.php          # Lista e busca alunos
│   ├── create.php         # Formulário novo aluno
│   ├── store.php          # Salva novo aluno
│   ├── edit.php           # Formulário editar aluno
│   ├── update.php         # Atualiza aluno
│   ├── delete.php         # Exclui aluno
│   └── export_csv.php     # Exporta para CSV
├── auth/
│   ├── functions.php      # Funções de autenticação
│   ├── login.php          # Página de login
│   ├── register.php       # Página de registro
│   └── logout.php         # Faz logout
├── config/
│   ├── config.php         # Configurações do banco
│   └── db.php             # Conexão PDO
├── database/
│   └── schema.sql         # Script de criação do banco
├── includes/
│   ├── header.php         # Cabeçalho das páginas
│   ├── footer.php         # Rodapé das páginas
│   └── menu.php           # Menu de navegação
├── assets/
│   ├── css/style.css      # Estilos
│   └── js/script.js       # Scripts
├── index.php              # Página inicial
└── README.md              # Este arquivo
```

## Iniciar o Servidor

```bash
# Na pasta do projeto
php -S localhost:8000
```

Acesse: `http://localhost:8000`

## Credenciais Padrão

- **E-mail:** admin@sistema.com
- **Senha:** admin123

## Tecnologias Utilizadas

- PHP 8+
- MySQL 8+
- PDO (PHP Data Objects)
- HTML5 + CSS3
- JavaScript vanilla
- TCPDF (opcional, para PDF avançado)

## Recursos de Segurança

- ✅ Prepared Statements (proteção contra SQL Injection)
- ✅ Senhas com hash bcrypt
- ✅ Validação de entrada
- ✅ htmlspecialchars (proteção contra XSS)
- ✅ Sistema de sessões
- ✅ Proteção de rotas

## Melhorias Futuras

- [ ] Paginação na listagem
- [ ] Upload de foto do aluno
- [ ] Níveis de acesso (admin/usuário)
- [ ] Logs de atividades
- [ ] Recuperação de senha
- [ ] Exportação em Excel (XLSX)
- [ ] Gráficos e estatísticas

---

**Desenvolvido por:** Larissa da Silva Donschen  
**Ano:** 2024