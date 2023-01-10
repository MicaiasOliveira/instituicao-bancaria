<?php

require_once "db/conexao.php";


$conexao = novaConexao();


if(count($_POST) > 0) {
    $dados = $_POST;
    $erros = [];

    if(trim($dados['nome_cliente']) === "") {
        $erros['nome_cliente'] = 'Nome do Banco é obrigatório';
    }

    if(trim($dados['sobrenome_cliente']) === "") {
        $erros['sobrenome_cliente'] = 'Sobrenome é obrigatório';
    }
    
    if(!count($erros)) {
        
        $identificador = $dados['identificador'];
        $nomeClienteAlterado = $dados['nome_cliente'];
        $sobrenomeClienteAlterado = $dados['sobrenome_cliente'];
        
        $editarCliente = "UPDATE cliente 
        SET nome_cliente = ?,
            sobrenome_cliente = ?
        WHERE identificador = ?";
    
    $conexao = novaConexao();
    $stmt = $conexao->prepare($editarCliente);
    
    $resultado2 = $stmt->execute([
        "$nomeClienteAlterado",
        "$sobrenomeClienteAlterado",
        "$identificador"
    ]);

        if($resultado2) {
            unset($dados);
            echo '<div class="alert alert-info" role="alert">
                    Cliente editado com SUCESSO!!
                </div>';
        } else {
            print_r($stmt->errorInfo());
        }
    };
};

$registros = [];

$selectIdentificador = "SELECT nome_cliente, sobrenome_cliente, identificador FROM cliente";
$resultado = $conexao->query($selectIdentificador)->fetchAll(PDO::FETCH_ASSOC);

if(is_Array($resultado)) {
    foreach($resultado as $row) {
        $registros[] = $row;   
    };
};

?>

<table class="table table-hover table-striped table-bordered">
    <thead>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Identificador</th>
    </thead>
    <tbody>
        <?php foreach($registros as $registro) : ?>
            <form action="#" method="post">
                <tr class="form-row">
                    <td class="form-group">
                        <input type="text" 
                        class="form-control <?= $erros['nome_cliente'] ? 'is-invalid' : ''?>" 
                        id="nome_cliente" name="nome_cliente" placeholder="<?= $registro['nome_cliente'] ?>"
                        value="<?= $dados['nome_cliente'] ?>">
                     <div class="invalid-feedback">
                        <?= $erros['nome_cliente'] ?>
                    </div>
                    <td class="form-group">
                        <input type="text" 
                        class="form-control <?= $erros['sobrenome_cliente'] ? 'is-invalid' : ''?>" 
                        id="sobrenome_cliente" name="sobrenome_cliente" placeholder="<?= $registro['sobrenome_cliente'] ?>"
                        value="<?= $dados['sobrenome_cliente'] ?>">
                     <div class="invalid-feedback">
                        <?= $erros['sobrenome_cliente'] ?>
                    </div>
                    </td>
                    <td class="form-group">
                    <input type="number" 
                        class="form-control"
                        id="identificador" name="identificador" placeholder="<?= $registro['identificador'] ?>"
                        disabled>
                    <div class="invalid-feedback">
                        <?= $erros['identificador'] ?>
                    </div>
                    <input type="number" 
                        class="form-control <?= $erros['identificador'] ? 'is-invalid' : ''?>"
                        id="display" name="identificador" placeholder="Identificador"
                        value="<?= $registro['identificador'] ?>">
                    </td>
                    <td class="form-group">
                        <button class="btn btn-info" type="submit">Editar</button>
                    </td>
                </tr>
            </form>
        <?php endforeach ?>
    </tbody>
</table>

<style>
    #display {
        display: none;
    }
</style>