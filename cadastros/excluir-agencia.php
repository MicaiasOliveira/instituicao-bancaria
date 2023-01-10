<?php

require_once "db/conexao.php";

$registros = [];
$conexao = novaConexao();

if($_GET['excluir']) {
    $identificador = $_GET['excluir'];

    $excluirAgencia = "DELETE FROM agencia WHERE identificador = $identificador";
    $stmt = $conexao->prepare($excluirAgencia);
    $stmt->execute();
    echo '<div class="alert alert-success" role="alert">
            Agência excluido com SUCESSO!!
        </div>';
}

$selectAgencia = "SELECT * FROM agencia";
$resultado = $conexao->query($selectAgencia)->fetchAll(PDO::FETCH_ASSOC);
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
        <th>Agencia</th>
    </thead>
    <tbody>
        <?php foreach($registros as $registro) : ?>
            <tr>
                <td><?= $registro['nome_banco'] ?></td>
                <td><?= $registro['identificador'] ?></td>
                <td><?= $registro['agencia'] ?></td>
                <td>
                    <a href="/instituicoes.php?dir=cadastros&file=excluir-agencia&excluir=<?= $registro['identificador'] ?>" 
                        class="btn btn-danger">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>