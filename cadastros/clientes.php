<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="titulo">Contas</div>

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
    $cpfConfig = [
        "options" => ["min_range" => 0, "max_range" => 11]
    ];

    if(trim($dados['nome_cliente']) === "") {
        $erros['nome_cliente'] = 'Nome do Banco é obrigatório';
    }

    if(trim($dados['nome_banco']) === "") {
        $erros['nome_banco'] = 'Nome do Banco é obrigatório';
    }

    if(trim($dados['sobrenome_cliente']) === "") {
        $erros['sobrenome_cliente'] = 'Sobrenome é obrigatório';
    }

    if(trim($dados['nascimento']) === "") {
        $erros['nascimento'] = 'Data de nascimento é obrigatória';
    } elseif(isset($dados['nascimento'])) {
        $data = DateTime::createFromFormat(
            'd/m/Y', $dados['nascimento']);
        if(!$data) {
            $erros['nascimento'] = 'Data deve estar no padrão dd/mm/aaaa';
        }
    }

    if(strlen($dados['cpf']) !== 11) {
        $erros['cpf'] = 'CPF deve conter 11 números (Apenas números)';
    }

    if(!count($erros)) {
        try {
            
            $insertCliente = "INSERT INTO cliente 
            (nome_banco, identificador, nome_cliente, sobrenome_cliente, nascimento, cpf, agencia)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conexao->prepare($insertCliente);
    
            $stmt->bindParam(1, $nomeBanco);
            $stmt->bindParam(2, $identificador);
            $stmt->bindParam(3, $nomeCliente);
            $stmt->bindParam(4, $sobrenomeCliente);
            $stmt->bindParam(5, $nascimento);
            $stmt->bindParam(6, $cpf);
            $stmt->bindParam(7, $agencia);
    
            $dataFormatada = str_replace("/", "-", $_POST['nascimento']);
            $formato = 'd-m-Y';
            $criandoDataFormatadaSQL = date_create_from_format($formato, $dataFormatada);
            $dataFormatadaSQL = date_format($criandoDataFormatadaSQL, "Y-m-d");
    
    
            $nomeBanco = $dados['nome_banco'];
            $identificador = $dados['cpf'] . 0 . $dados['identificador'] . 0 . $dados['agencia'];
            $nomeCliente = $dados['nome_cliente'];
            $sobrenomeCliente = $dados['sobrenome_cliente'];
            $nascimento = $dataFormatadaSQL;
            $cpf = $dados['cpf'];
            $agencia = $dados['agencia'];
    
            if($stmt->execute()) {
                unset($dados);
                echo '<div class="alert alert-success" role="alert">
                        Cliente cadastrado com SUCESSO!!
                     </div>';
            } else {
                echo '<div class="alert alert-success" role="alert">
                        Ocorreu um erro no cadastro do Cliente!!
                     </div>';
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger" role="alert">
                    Esse cliente já tem cadastro nessa agência!!
                </div>';
        }

    };
}

?>

<form action="/instituicoes.php" method="get">
    <input type="hidden" name="dir" value="cadastros">
    <input type="hidden" name="file" value="clientes">
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

<form action="#" method="post">
    <div class="form-row">
        <div class="form-group col-md-7">
            <label for="nome_banco">Nome do Banco</label>
            <input type="text" class="form-control <?= $erros['nome_banco'] ? 'is-invalid' : ''?>"
                id="nome_banco" name="nome_banco" placeholder="Nome do Banco" 
                value="<?= $registroDois['nome_banco'] ?>">
            <div class="invalid-feedback">
                <?= $erros['nome_banco'] ?>
            </div>
        </div>
        <div class="form-group col-md-5">
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
        <div class="form-group col-md-4">
            <label for="nome_cliente">Nome do Cliente</label>
                <input type="text" 
                class="form-control <?= $erros['nome_cliente'] ? 'is-invalid' : ''?>" 
                id="nome_cliente" name="nome_cliente" placeholder="Nome do Cliente"
                value="<?= $dados['nome_cliente'] ?>">
            <div class="invalid-feedback">
                <?= $erros['nome_cliente'] ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="sobrenome_cliente">Sobrenome do Cliente</label>
            <input type="text" 
                class="form-control <?= $erros['sobrenome_cliente'] ? 'is-invalid' : ''?>" 
                id="sobrenome_cliente" name="sobrenome_cliente" placeholder="Sobrenome do Beneficiário"
                value="<?= $dados['sobrenome_cliente'] ?>">
            <div class="invalid-feedback">
                <?= $erros['sobrenome_cliente'] ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="nascimento">Data de Nascimento</label>
            <input type="text"
                class="form-control <?= $erros['nascimento'] ? 'is-invalid' : ''?>"
                id="nascimento" name="nascimento"
                placeholder="Nascimento"
                value="<?= $dados['nascimento'] ?>">
            <div class="invalid-feedback">
                <?= $erros['nascimento'] ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="cpf">CPF</label>
            <input type="text"
                class="form-control <?= $erros['cpf'] ? 'is-invalid' : ''?>"
                id="cpf" name="cpf"
                placeholder="11122233344"
                value="<?= $dados['cpf'] ?>">
            <div class="invalid-feedback">
                <?= $erros['cpf'] ?>
            </div>
        </div>  
        <div class="form-group col-md-3">
            <label for="agencia">Estado</label>
            <select id="agencia" name ="agencia" required class="custom-select">
                <option value=""selected>Selecione o Estado...</option>
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
            </select>
            <div class="invalid-feedback">
                Selecione o Estado
            </div>
        </div>
    </div>
    <button class="btn btn-success" type="submit">Cadastrar</button>
</form>

<style>
    .display {
        display: none;
    }
</style>