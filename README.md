# 📝 ArticleHub - Blog com Múltiplos Desenvolvedores

**ArticleHub** é uma aplicação web desenvolvida em Laravel voltada para o **cadastro e gerenciamento de artigos com múltiplos desenvolvedores vinculados**, com uma página pública estilo **blog**.

---

## 🚀 Funcionalidades

### 🔐 Área Administrativa
- Login/Logout para administradores
- Middleware para proteção de rotas

### 👥 Desenvolvedores
- CRUD completo
- Campos:
    - Nome
    - E-mail
    - Foto (upload)
    - Biografia

### 📝 Artigos
- CRUD completo
- Campos:
    - Título
    - Conteúdo (rich text)
    - Imagem de capa (upload)
    - Desenvolvedores (múltiplos)
    - Data de publicação

### 🌐 Página Pública - Blog
- Listagem de artigos em ordem decrescente de publicação
- Exibe:
    - Capa
    - Título
    - Resumo (300 caracteres)
    - Link para detalhes

### 📄 Página Pública - Detalhes do Artigo
- Visualização completa do artigo
- Exibe desenvolvedores vinculados (nome, foto e bio)

---

