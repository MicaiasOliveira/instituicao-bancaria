<?php 

require_once "conexao.php";

$conexao = novaConexao();


try {
    $insertAgencia = "INSERT INTO cliente 
    (nome_banco, identificador, nome_cliente, sobrenome_cliente, nascimento, cpf, agencia)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($insertAgencia);
    
    $stmt->bindParam(1, $nomeBanco);
    $stmt->bindParam(2, $identificador);
    $stmt->bindParam(3, $nome_cliente);
    $stmt->bindParam(4, $sobrenome_cliente);
    $stmt->bindParam(5, $nascimento);
    $stmt->bindParam(6, $cpf);
    $stmt->bindParam(7, $agencia);
    
    $nomeBanco = 'Micaias Teste';
    $identificador = '333';
    $nome_cliente = 'Micaias';
    $sobrenome_cliente = 'Oliveira';
    $nascimento = '1996-07-23';
    $cpf = '10859744485';
    $agencia = '23';
    
    if($stmt->execute()) {
        print_r($stmt);
    } else {
        print_r($stmt);
    }
} catch (PDOException $e) {
    echo 'Erro => ' . $e->getMessage();
}

print_r($stmt);


        