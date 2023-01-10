<nav class="boxes">
    <div class="box">
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=bancos">
                    Cadastrar Banco
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=editar-banco">
                    Editar Banco
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=excluir-banco">
                    Excluir Banco
                </a>
            </li>
        </ul>
    </div>
    <div class="box">
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=agencias">
                    Cadastrar Agencia
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=excluir-agencia">
                    Excluir Agencia
                </a>
            </li>
        </ul>
    </div>
    <div class="box">
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=clientes">
                    Cadastrar Cliente
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=editar-cliente">
                    Editar nome e sobrenome do cliente
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="instituicoes.php?dir=cadastros&file=excluir-cliente">
                    Excluir Cliente
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
.boxes {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.box {
    flex-basis: 32%;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 2px solid gray;
}
</style>