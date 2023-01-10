<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Instituições Bancárias</title>
</head>
<body>
    <header class="cabecalho">
        <h1>Instituições Bancárias</h1>
    </header>
    <nav class="navegacao">

    </nav>
    <main class="principal">
        <div class="conteudo">
            <?php require_once('principal.php'); ?>
        </div>
    </main>
    <footer class="rodape">
        Micaias Oliveira © <?= date('Y'); ?>
    </footer>
</body>
</html>