# SiVaEm-web

Desenvolvido por Ellen Woellner, Leonardo Suzin e Vinícius Souza

Sistema de Vagas de Emprego - Disciplina de Desenvolvimento Web-Servidor-UTFPR 2024

# Configuração

Para configurar é necessário utilizar o XAMPP como serviço de host PHP.

Abra o XAMPP e ative os serviços de APACHE e MySQL.

Insira os arquivos na pasta C:\xampp\htdocs\sivaem-web-main e acesse http://localhost/sivaem-web-main/ para entrar na aplicação.

É necessário utilizar um banco de dados SQL para poder utilizar a função de dados do servidor. Para isto, acesse http://localhost/phpmyadmin/. O script para criação do banco encontra-se na pasta C:\xampp\htdocs\sivaem-web-main\database.

Para acessar os usuários, crie um cadastro de cada tipo, para acessar suas respectivas telas.

É necessário realizar a instalação do composer para o projeto. Para iniciar a instalação, deve-se usar o comando composer install.

Após a instalação do composer, é necessário instalar o pacote de rotas, através do comando composer require pecee/simple-router.


#