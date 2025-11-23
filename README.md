# 📚 Biblioteca Online

Sistema completo de gerenciamento de biblioteca desenvolvido em Laravel com Docker.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat-square&logo=docker)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql)

---

## 📖 Sobre o Projeto

Sistema web para gestão de acervo, usuários, reservas, empréstimos e multas, com painel administrativo moderno e arquitetura escalável.

---

## 🚀 Início Rápido

### Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/) 20.10+
- [Docker Compose](https://docs.docker.com/compose/install/) 2.0+
- [Make](https://www.gnu.org/software/make/) (geralmente já vem instalado)

### Instalação

1. **Clone o repositório**
```bash
git clone <url-do-repositorio>
cd biblioteca_online
```

2. **Inicialize o projeto**
```bash
make init-project
```

Este comando irá:
- Subir containers (nginx, php, mysql, redis)
- Instalar dependências
- Configurar arquivo `.env`
- Executar migrations
- Criar link de storage

3. **Acesse a aplicação**
- **Aplicação**: http://localhost:8080
- **Painel Admin**: http://localhost:8080/admin/dashboard
- **Mailpit (emails)**: http://localhost:32770

---

## 🛠️ Comandos Principais

### Docker
```bash
make up              # Inicia containers
make down            # Para containers
make restart         # Reinicia containers
make logs            # Mostra logs
make ps              # Status dos containers
```

### Banco de Dados
```bash
make migrate         # Executa migrations
make seed            # Popula banco com dados
make db              # Conecta ao MySQL
```

### Desenvolvimento
```bash
make bash            # Entra no container PHP
make tinker           # Laravel Tinker
make route-list       # Lista rotas
```

### Cache e Otimização
```bash
make cache-clear     # Limpa cache
make clear-all        # Limpa todos os caches
make optimize         # Otimiza aplicação
```

### Testes
```bash
make test            # Executa testes
```

**Ver todos os comandos disponíveis:**
```bash
make help
```

---

## 🐳 Serviços Disponíveis

| Serviço | Container | Porta | Descrição |
|---------|-----------|-------|-----------|
| **PHP** | `setup-laravel-php` | - | PHP 8.x + FPM + Composer |
| **Nginx** | `setup-laravel-nginx` | 8080 | Servidor web |
| **MySQL** | `setup-laravel-mysql` | 3306 | Banco de dados principal |
| **Redis** | `setup-laravel-redis` | 6379 | Cache e sessões |
| **Mailpit** | `setup-laravel-mailer` | 32770 | Servidor de email para testes |

### Credenciais do Banco de Dados

**MySQL (padrão):**
```
Host: localhost (ou mysql dentro dos containers)
Port: 3306
Database: db_laravel
User: developer
Password: 123456
Root Password: root
```

**Redis:**
```
Host: localhost (ou redis dentro dos containers)
Port: 6379
```

---

## 📁 Estrutura do Projeto

```
biblioteca_online/
├── backend/                    # Aplicação Laravel
│   ├── app/                    # Código da aplicação
│   │   ├── Actions/            # Actions de domínio
│   │   ├── Services/           # Serviços de negócio
│   │   ├── Repositories/       # Repositórios
│   │   ├── Models/             # Models Eloquent
│   │   └── Http/               # Controllers, Requests
│   ├── database/               # Migrations, seeders
│   ├── resources/              # Views, assets
│   └── routes/                 # Rotas da aplicação
├── docker/                     # Configurações Docker
├── makefiles/                  # Comandos Make organizados
├── docker-compose.yml          # Configuração dos serviços
└── Makefile                    # Makefile principal
```

---

## 🏗️ Arquitetura

O projeto segue padrões arquiteturais:

- **Repository Pattern** - Abstração de acesso a dados
- **Service Layer** - Lógica de negócio
- **Actions** - Ações específicas de domínio
- **DTOs** - Data Transfer Objects

### Criar Componentes

```bash
make make-service        # Criar Service
make make-repository     # Criar Repository + Interface
make make-action         # Criar Action
make make-dto            # Criar DTO
make make-controller     # Criar Controller
make make-model          # Criar Model
```

---

## 🔧 Configuração

### Arquivo `.env`

O arquivo `.env` é criado automaticamente pelo comando `make init-project`. As principais configurações:

```env
DB_CONNECTION=mysql
DB_HOST=setup-laravel-mysql
DB_PORT=3306
DB_DATABASE=db_laravel
DB_USERNAME=developer
DB_PASSWORD=123456

REDIS_HOST=setup-laravel-redis
REDIS_PORT=6379
```

---

## 🧪 Testes

```bash
make test                # Executa todos os testes
make test-coverage       # Testes com coverage
```

---

## 🐛 Troubleshooting

### Container não inicia
```bash
make logs-php           # Ver logs do PHP
make logs-nginx         # Ver logs do Nginx
make logs-mysql         # Ver logs do MySQL
make ps                 # Verificar status
```

### Problemas de permissão
```bash
make permissions        # Corrigir permissões
```

### Reset completo (⚠️ apaga dados!)
```bash
make down-volumes       # Para e remove volumes
make up-build           # Rebuild e inicia
make setup-full         # Setup completo
```

### Cache preso
```bash
make clear-all          # Limpa todos os caches
```

---

## 📝 Licença

MIT

---

## 🤝 Contribuindo

1. Faça fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

---

<div align="center">

**[⬆ Voltar ao topo](#biblioteca-online)**

</div>
