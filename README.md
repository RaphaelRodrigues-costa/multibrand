# Iniciar o projeto

### No seu terminal execute os comandos.

- composer install - Para instalar as dependencias do composer 
- npm install - Para instalar as dependencias do npm 
- npm run build - Para buildar o css e js 
- php artisan serve - Para criar o servidor web local 

### Opcional
- docker-compose up - Esse comando vai criar um banco de dados mysql

## Rotas

- / - Rota inicial
- /login - Rota para fazer login
- /register - Rota para criar um registro
- /dashboard - Rota da tela inical do aplicativo
- /cars - Rota que lista todos os carros
- /cars?name=bmw - Rota para buscar parte de um nome do item
- /cars/{id}/delete - Rota para deletar o carro no banco de dados
