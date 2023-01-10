<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="titulo">Bancos</div>

<?php 
require_once "db/conexao.php";

if(count($_POST) > 0) {
    $dados = $_POST;
    $erros = [];
    $identificadorConfig = [
        "options" => ["min_range" => 0, "max_range" => 999]
    ];

    if(trim($dados['nome_banco']) === "") {
        $erros['nome_banco'] = 'Nome é obrigatório';
    }

    if (!filter_var($dados['identificador'], FILTER_VALIDATE_INT,
    $identificadorConfig)) {
        $erros['identificador'] = 'Identificador inválido (1-999).';
    }
    
    if(trim($dados['qtde_agencia']) != 27) {
        $erros['qtde_agencia'] = 'Coloque 27';
    }
    
    if(!count($erros)) {
        try {

            $insertBanco = "INSERT INTO banco 
            (nome_banco, identificador, qtde_agencia)
            VALUES (?, ?, ?)";
    
            $conexao = novaConexao();
            $stmt = $conexao->prepare($insertBanco);
    
            $stmt->bindParam(1, $nomeBanco);
            $stmt->bindParam(2, $identificador);
            $stmt->bindParam(3, $qtdeAgencia);
    
            $nomeBanco = $dados['nome_banco'];
            $identificador = $dados['identificador'];
            $qtdeAgencia = $dados['qtde_agencia'];
    
            if($stmt->execute()) {
                unset($dados);
                echo '<div class="alert alert-success" role="alert">
                        Banco cadastrado com SUCESSO!!
                     </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        Ocorreu um erro no cadastro do banco!!
                    </div>';
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger" role="alert">
                    Esse identificador já existe, por favor escolha outro e tente novamente!!
                </div>';
        }

    }
}
?>

<?php foreach($erros as $erro): ?>
    <!-- <div class="alert alert-danger" role="alert"> -->
        <?= "" // $erro ?>
    <!-- </div> -->
<?php endforeach ?>


<form action="#" method="post">
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="nome_banco">Nome do Banco</label>
            <input type="text" 
                class="form-control <?= $erros['nome_banco'] ? 'is-invalid' : ''?>" 
                id="nome_banco" name="nome_banco" placeholder="Nome"
                value="<?= $dados['nome_banco'] ?>">
            <div class="invalid-feedback">
                <?= $erros['nome_banco'] ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="identificador">Identificador</label>
            <input type="number" 
                class="form-control <?= $erros['identificador'] ? 'is-invalid' : ''?>"
                id="identificador" name="identificador" placeholder="Identificador"
                value="<?= $dados['identificador'] ?>">
            <div class="invalid-feedback">
                <?= $erros['identificador'] ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="qtde_agencia">Número de Agências</label>
            <input type="number" class="form-control <?= $erros['qtde_agencia'] ? 'is-invalid' : ''?>"
                id="qtde_agencia" name="qtde_agencia" placeholder="27" 
                value="<?= $dados['qtde_agencia'] ?>">
            <div class="invalid-feedback">
                <?= $erros['qtde_agencia'] ?>
            </div>
        </div>
    </div>
    <button class="btn btn-success" type="submit">Cadastrar</button>
</form>

