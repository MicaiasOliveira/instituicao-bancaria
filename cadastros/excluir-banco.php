<?php

require_once "db/conexao.php";

$registros = [];
$conexao = novaConexao();

if($_GET['excluir']) {
    $identificador = $_GET['excluir'];

    $excluirBanco = "DELETE FROM banco WHERE identificador = $identificador";
    $stmt = $conexao->prepare($excluirBanco);
    $stmt->execute();
    echo '<div class="alert alert-success" role="alert">
            Banco excluido com SUCESSO!!
        </div>';
}

$selectBanco = "SELECT * FROM banco";
$resultado = $conexao->query($selectBanco)->fetchAll(PDO::FETCH_ASSOC);
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
            <tr>
                <td><?= $registro['nome_banco'] ?></td>
                <td><?= $registro['identificador'] ?></td>
                <td><?= $registro['qtde_agencia'] ?></td>
                <td>
                    <a href="/instituicoes.php?dir=cadastros&file=excluir-banco&excluir=<?= $registro['identificador'] ?>" 
                        class="btn btn-danger">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>