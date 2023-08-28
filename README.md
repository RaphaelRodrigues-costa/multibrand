# Iniciar o projeto

### No seu terminal execute os comandos.

- cp .env.example .env - Para criar o arquivo .env pela .env.example
- php artisan key:generate  - Para adicionar a chave APP_KEY no .env
- php artisan migrate:fresh  - Para rodar as migrates
- composer install - Para instalar as dependências do composer
- npm install - Para instalar as dependências do npm
- npm run build - Para buildar o css e js
- php artisan serve - Para criar o servidor web local

### Dependências
- Certifique-se que você tenha instalado o Mysql em sua máquina ou docker
- - Caso tenha docker poderá executar o comando docker-compose up
- Certifique-se que a versão do php seja a 8.1
- Certifique-se que a versão do node sejá a 16.20.2

### Opcional
- docker-compose up - Esse comando vai criar um banco de dados mysql

## Atenção
- O vite apresentou erro ao tentar rodar na versão mais atual do node, o projeto esta sendo executado na versão v16.20.2

## Para mudar a versão do node
- Instale o NVM (caso ainda não tenha):
- - curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
- Liste as versões disponíveis do Node.js:
- - Liste as versões disponíveis do Node.js:
- Instale uma versão específica (por exemplo, v16.20.2):
- - nvm install 16.20.2
- Use a versão instalada:
- - nvm use 14.17.4


## Rotas
- / - Rota inicial
- /login - Rota para fazer login
- /register - Rota para criar um registro
- /dashboard - Rota da tela inicial do aplicativo
- /cars - Rota que lista todos os carros
- /cars?name=bmw - Rota para buscar parte de um nome do item
- /cars/{id}/delete - Rota para deletar o carro no banco de dados
