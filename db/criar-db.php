<?php

require_once "conexao.php";

$conexao = novaConexao(null);
$sql = "CREATE DATABASE IF NOT EXISTS instituicoes_bancarias";

$conexao->query($sql);

echo 'Sucesso!!';

$conexao->close();
