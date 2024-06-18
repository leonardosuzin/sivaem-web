# SiVaEm-web

Desenvolvido por Ellen Woellner, Leonardo Suzin e Vinícius Souza

Sistema de Vagas de Emprego - Disciplina de Desenvolvimento Web-Servidor-UTFPR 2024

# Configuração

Para configurar é necessário utilizar o XAMPP como serviço de host PHP.

Abra o XAMPP e ative o serviço de APACHE.

Insira os arquivos na pasta C:\xampp\htdocs\ e acesse http://localhost/sivaem-web-main/ para entrar na aplicação.

Agora, na pasta C:\xampp\htdocs\sivaem-laravel

É necessário realizar a instalação do composer para o projeto. Para iniciar a instalação, deve-se usar o comando composer install.

Após instalar o composer, utilizar o comando (composer global require "laravel/installer=~1.1") no terminal do projeto para instalar o laravel.

Executar o comando php artisan migrate:fresh para gerar o banco de dados que será usado na aplicação.

Utilizar o comando php artisan serve para rodar o servidor. Utilizar a porta 8000 para rodar o projeto.

Para acessar os usuários, crie um cadastro de cada tipo, para acessar suas respectivas telas.

#