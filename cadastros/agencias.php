<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<h2 class="titulo">Agências</h2>

<?php
require_once "db/conexao.php";

$conexao = novaConexao();


$selecionarAgencia = "SELECT * FROM banco";
$resultado = $conexao->query($selecionarAgencia)->fetchAll(PDO::FETCH_ASSOC);
if(is_Array($resultado)) {
    foreach($resultado as $row) {
        $registros[] = $row;
    };
};

$registrosDois = [];

if($_GET['identificador']) {
    $identificador = $_GET['identificador'];
    
    $selecionarBanco = "SELECT nome_banco, identificador FROM banco WHERE identificador = $identificador";
    $resultadoDois = $conexao->query($selecionarBanco)->fetchAll(PDO::FETCH_ASSOC);
    if(is_Array($resultadoDois)) {
        foreach($resultadoDois as $row) {
            $registrosDois[] = $row;
        };
    };
};

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
    
    if(!count($erros)) {
        try {
            
            $insertAgencia = "INSERT INTO agencia 
            (nome_banco, identificador, agencia)
            VALUES (?, ?, ?)";
            
            $stmt = $conexao->prepare($insertAgencia);
    
            $stmt->bindParam(1, $nomeBanco);
            $stmt->bindParam(2, $identificador);
            $stmt->bindParam(3, $agencia);
    
            $nomeBanco = $dados['nome_banco'];
            $identificador = $dados['identificador'] . 0 . $dados['agencia'];
            $agencia = $dados['agencia'];
    
            if($stmt->execute()) {
                unset($dados);
                echo '<div class="alert alert-success" role="alert">
                        Agência cadastrada com SUCESSO!!
                     </div>';
            } else {
                echo '<div class="alert alert-success" role="alert">
                        Ocorreu um erro no cadastro da agência!!
                     </div>';
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger" role="alert">
                    Já existe uma agência desse banco nesse estado, por favor escolha outro estado!!
                </div>';
        }

    };
};

?>

<form action="/instituicoes.php" method="get">
    <input type="hidden" name="dir" value="cadastros">
    <input type="hidden" name="file" value="agencias">
    <div class="form-group row">
        <label for="identificador">Buscar Banco</label>
        <div class="col-sm-10">
            <select id="identificador" name="identificador" required class="custom-select">
                <option value="" selected>Selecione um banco</option>
                <?php foreach($registros as $registro) : ?>
                    <option value="<?= $registro['identificador'] ?>"><?= $registro['identificador'] . ' - ' . $registro['nome_banco'] ?></option>
                    <?php endforeach ?>
                    <input class="display" type="text">
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-info mb-4">Consultar</button>
        </div>
    </div>
</form>

<?php foreach($registrosDois as $registroDois): ?>
    
<?php endforeach ?>

<?php

?>

<form action="#" method="post">
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="nome">Nome do Banco</label>
            <input type="text" class="form-control <?= $erros['nome_banco'] ? 'is-invalid' : ''?>"
                id="nome" name="nome_banco" placeholder="Nome do Banco" 
                value="<?= $registroDois['nome_banco'] ?>">
            <div class="invalid-feedback">
                <?= $erros['nome_banco'] ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="identificador">Identificador</label>
            <input type="text" class="form-control <?= $erros['identificador'] ? 'is-invalid' : ''?>"
            name="identificador" placeholder="Identificador"
            value="<?= $registroDois['identificador'] ?>">
            <div class="invalid-feedback">
                <?= $erros['identificador'] ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="agencia">Área de Atuação</label>
            <select id="agencia" name="agencia" required class="custom-select">
                <option value="" selected>Selecione o Estado</option>
                <option value="1">Acre (AC)</option>
                <option value="2">Alagoas (AL)</option>
                <option value="3">Amapá (AP)</option>
                <option value="4">Amazonas (AM)</option>
                <option value="5">Bahia (BA)</option>
                <option value="6">Ceará (CE)</option>
                <option value="7">Distrito Federal (DF)</option>
                <option value="8">Espírito Santo (ES)</option>
                <option value="9">Goiás (GO)</option>
                <option value="10">Maranhão (MA)</option>
                <option value="11">Mato Grosso (MT)</option>
                <option value="12">Mato Grosso do Sul (MS)</option>
                <option value="13">Minas Gerais (MG)</option>
                <option value="14">Pará (PA)</option>
                <option value="15">Paraíba (PB)</option>
                <option value="16">Paraná (PR)</option>
                <option value="17">Pernambuco (PE)</option>
                <option value="18">Piauí (PI)</option>
                <option value="19">Rio de Janeiro (RJ)</option>
                <option value="20">Rio Grande do Norte (RN)</option>
                <option value="21">Rio Grande do Sul (RS)</option>
                <option value="22">Rondônia (RO)</option>
                <option value="23">Roraima (RR)</option>
                <option value="24">Santa Catarina (SC)</option>
                <option value="25">São Paulo (SP)</option>
                <option value="26">Sergipe (SE)</option>
                <option value="27">Tocantins (TO)</option>
                <div class="invalid-feedback">
                    Selecione o Estado
                </div>        
            </select>
        </div>
    </div>
    <button class="btn btn-success" type="submit">Cadastrar</button>
</form>

<style>
    .display {
        display: none;
    }
</style>