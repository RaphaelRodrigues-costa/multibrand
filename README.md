# Iniciar o projeto

### No seu terminal execute os comandos.

- sudo composer install - Para instalar as dependencias do composer 
- npm install - Para instalar as dependencias do npm
- npm run dev - Para startar as dependencias de desenvolvimento 

### Opcional
- docker-compose up - Esse comando vai criar um banco de dados mysql

## Rotas

- / - Rota inicial
- /login - Rota para fazer login
- /register - Rota para criar um registro
- /dashboard - Rota da tela inical do aplicativo
- /cars-list - Rota que lista todos os carros
- /cars-filter/name - Rota de um filtro para buscar por marca
- /cars/{id}/delete - Rota para deletar o carro no banco de dados
