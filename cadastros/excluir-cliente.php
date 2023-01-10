<?php

require_once "db/conexao.php";

$registros = [];
$conexao = novaConexao();

if($_GET['excluir']) {
    $identificador = $_GET['excluir'];
    
    $excluirCliente = "DELETE FROM cliente WHERE identificador = $identificador";
    $stmt = $conexao->prepare($excluirCliente);
    $stmt->execute();
    echo '<div class="alert alert-success" role="alert">
            Cliente excluido com SUCESSO!!
        </div>';
}

$selectCliente = "SELECT * FROM cliente";
$resultado = $conexao->query($selectCliente)->fetchAll(PDO::FETCH_ASSOC);
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
        <th>CPF</th>
    </thead>
    <tbody>
        <?php foreach($registros as $registro) : ?>
            <tr>
                <td><?= $registro['nome_cliente'] ?></td>
                <td><?= $registro['sobrenome_cliente'] ?></td>
                <td><?= $registro['cpf'] ?></td>
                <td>
                    <a href="/instituicoes.php?dir=cadastros&file=excluir-cliente&excluir=<?= $registro['identificador'] ?>" 
                        class="btn btn-danger">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>