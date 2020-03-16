# api-rest-users-drinks
Exercício realizado para um teste de emprego

Cargo: Developer PHP

Empresa: https://mosyle.com/

Trata-se de um backend API para completar os itens dentro do Desafio.php
Lembrando que o único item não desenvolvido é o item descrito abaixo:
  Tratamento Opcional:
    Paginação na lista de usuários

Vale ressaltar que criamos duas tabela no banco de dados MySQL em uma
versão online de graça com uma tabela até certo tamanho. A conexão está
no arquivo conn.php e o comandos estão em bd.sql

A maioria dos cenários tem como resposta um json com três itens
  1- Status: onde 0 = error, 1 = OK e 2 = WARNING;
  2- response: um comentário interno sobre o script executado;
  3- dataArray: array com as saídas pedidas no teste.

Para executar os tratamentos opcionais segue a tabela abaixo:

 URL	              Type
 /historic/:iduser	POST
 /ranking           POST

Comtém um .htaccess para o redirecionamento simples dentro da pasta

Qualquer dúvida sinta-se livre para me contatar
