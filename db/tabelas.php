<?php

require_once "conexao.php";

$sql = "CREATE TABLE IF NOT EXISTS banco (
    nome_banco VARCHAR(100) NOT NULL,
    identificador INT PRIMARY KEY,
    qtde_agencia INT
)";

$sql2 = "CREATE TABLE IF NOT EXISTS agencia (
    nome_banco VARCHAR(100) NOT NULL,
    identificador INT PRIMARY KEY,
    agencia INT
)";

$sql3 = "CREATE TABLE IF NOT EXISTS cliente (
    nome_banco VARCHAR(100) NOT NULL,
    identificador BIGINT PRIMARY KEY,
    nome_cliente VARCHAR(30),
    sobrenome_cliente VARCHAR(30),
    nascimento DATE,
    cpf BIGINT,
    agencia INT
)";



$conexao = novaConexao();
$conexao->exec($sql);
$conexao->exec($sql2);
$conexao->exec($sql3);
echo "Criou!!";

?>