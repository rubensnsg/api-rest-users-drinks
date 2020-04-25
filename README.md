# api-rest-users-drinks
Cargo de Developer PHP para a empresa Mosyle. Exercício realizado para um teste de emprego.

Trata-se de um backend API para completar os itens dentro do Desafio.pdf

Vale ressaltar que criamos duas tabela no banco de dados MySQL em uma
versão online de graça com uma tabela até certo tamanho. A conexão está
no arquivo conn.php e o comandos estão em bd.sql

A maioria dos cenários tem como resposta um json com três itens

  1. status: onde 0 = error, 1 = OK e 2 = WARNING;

  2. response: um comentário interno sobre o script executado;

  3. dataArray: array com as saídas pedidas no teste.


Para executar os tratamentos opcionais segue a tabela abaixo:

| URL                | Type Request  |
| ------------------ | ------------- |
| /historic/:iduser  |  POST         |
| /ranking           |  POST         |
| /page/:pageNumber  |  POST         |


Contém um .htaccess para o redirecionamento simples dentro da pasta


Qualquer dúvida sinta-se livre para me contatar
