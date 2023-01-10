<?php

require_once "db/conexao.php";


$conexao = novaConexao();


if(count($_POST) > 0) {
    $dados = $_POST;
    $erros = [];

    if(trim($dados['nome_banco']) === "") {
        $erros['nome_banco'] = 'Nome é obrigatório';
    }
    
    if(!count($erros)) {

        $identificador = $dados['identificador'];
        $nomeBancoAlterado = $dados['nome_banco'];

        $editarBanco = "UPDATE banco 
        SET nome_banco = ?
        WHERE identificador = ?";
        
        $conexao = novaConexao();
        $stmt = $conexao->prepare($editarBanco);
        
        if($stmt->execute([
            "$nomeBancoAlterado",
            "$identificador"
            ])) {
            unset($dados);
            echo '<div class="alert alert-info" role="alert">
                    Banco editado com SUCESSO!!
                </div>';
        } else {
            echo '<div class="alert alert-info" role="alert">
                    Ocorreu um erro ao editar o banco!!
                </div>';
        } 
    };
};

$registros = [];

$selectIdentificador = "SELECT * FROM banco";
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
        <th>ID</th>
        <th>Qtde Agencia</th>
    </thead>
    <tbody>
        <?php foreach($registros as $registro) : ?>
            <form action="#" method="post">
                <tr class="form-row">
                    <td class="form-group">
                        <input type="text" 
                        class="form-control <?= $erros['nome_banco'] ? 'is-invalid' : ''?>" 
                        id="nome_banco" name="nome_banco" placeholder="<?= $registro['nome_banco'] ?>"
                        value="<?= $dados['nome_banco'] ?>">
                     <div class="invalid-feedback">
                        <?= $erros['nome_banco'] ?>
                    </div>
                    </td>
                    <td class="form-group">
                    <input type="number" 
                        class="form-control <?= $erros['identificador'] ? 'is-invalid' : ''?>"
                        id="display" name="identificador" placeholder="Identificador"
                        value="<?= $registro['identificador'] ?>">
                    <div class="invalid-feedback">
                        <?= $erros['identificador'] ?>
                    </div>
                    <input type="number" 
                        class="form-control"
                        id="identificador" name="identificador" placeholder="<?= $registro['identificador'] ?>"
                        disabled>
                    </td>
                    <td class="form-group"><?= $registro['qtde_agencia'] ?></td>
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