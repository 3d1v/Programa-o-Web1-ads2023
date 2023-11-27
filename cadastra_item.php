<?php
if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['user'])){
    echo('<script>window.location.href = "/";</script>');
}

include_once './conexao.php';

$query_sysname = "select valor from parametros where id = 1";
$result_sysname = $conn->prepare($query_sysname);
$result_sysname->execute();

if (($result_sysname) AND ($result_sysname->rowCount() != 0)) {
    $sysname = $result_sysname->fetch(PDO::FETCH_ASSOC);
    $sysname = $sysname['valor'];
    //var_dump($row_usuario);
} else {
    $sysname = '';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <header data-bs-theme="dark">
        <div class="collapse text-bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <?php
                        if(isset($_SESSION['user'])){
                    ?>
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4>Menu</h4>
                        <a href="./cadastra_item.php" class="btn btn-secondary"
                            style="height: 5rem;display: table-cell;">
                            <i class="fa fa-plus"></i>
                            <br>
                            Registrar
                        </a>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4>Acesso</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li><span class="text-white">
                                            Usuário:
                                            <br>
                                            <?php echo($_SESSION['user']['nome']); ?>
                                        </span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-grid">
                            <a href="./logout.php" class="btn btn-md btn-danger">Sair</a>
                        </div>
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4><i class="fa fa-info-circle"></i></h4>
                        <p class="text-body-secondary">
                            Faça login para poder publicar seus serviços e recursos!
                        </p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4>Acesso</h4>
                        <div class="card p-1">
                            <form method="POST" action="./login.php">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
                                    Não tem conta? <a href="./cadastrar.php">Cadastre-se <i
                                            class="fa fa-external-link"></i></a>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-md btn-success">Entrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="/" class="navbar-brand d-flex align-items-center">
                    <i class="fa fa-bullseye"></i>&nbsp;<strong>
                        <?php echo($sysname); ?>
                    </strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <?php if(isset($_SESSION['user'])){echo('<i class="text-success fa fa-circle"></i>');} ?>
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>

    <main>
        <div class="container mt-2">
                <div class="card">
                    <form name="cad-usuario" method="POST" action="">
                        <div class="card-body">
                            <span class="h3">Novo recurso/serviço</span>
                            <div class="mt-2" style="display: flex; flex-direction: column;">

                                <div class="mb-3">
                                    <select name="categoria" id="categoria" class="form-select">
                                        <option selected>Selecione o tipo</option>
                                        <option value="1">Recurso</option>
                                        <option value="2">Serviço</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nome do serviço: </label>
                                    <input class="form-control" type="text" name="name" id="name">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Valor: </label>
                                    <input class="form-control" type="number" step="any" name="preco" id="preco">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <textarea class="form-control" name="descricao" id="descricao" rows="3"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div style="display: flex; justify-content: space-between;">
                                <a class="btn btn-sm btn-warning" href="/"><i class="fa fa-arrow-left"></i>
                                    Voltar</a><br>
                                <input class="btn btn-sm btn-success" type="submit" value="Cadastrar" name="CadItem">
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>

    </main>

    <footer class="text-body-secondary py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a class="btn btn-md btn-primary" href="#">Ir para o topo <i class="fa fa-arrow-up"></i></a>
            </p>
            <p class="mb-1">© <b>
                    <?php echo($sysname); ?>
                </b> 2023</p>
        </div>
    </footer>
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
//Receber os dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//Verificar se o usuário clicou no botão
if (!empty($dados['CadItem'])) {

    $empty_input = false;

    $dados = array_map('trim', $dados);
    if (in_array("", $dados)) {
        $empty_input = true;
        echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
    }

    if (!$empty_input) {
        // $query_item = "INSERT INTO serv_rec (name, descricao, categoria, preco) VALUES (:nome, :descricao, :categoria, :preco) ";
        // $cad_item = $conn->prepare($query_item);
        // $cad_item->bindParam(':name', $dados['name'], PDO::PARAM_STR);
        // $cad_item->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        // $cad_item->bindParam(':categoria', $dados['categoria'], PDO::PARAM_INT);
        // $cad_item->bindParam(':preco', $dados['preco']);
        // $cad_item->execute();

        $name       = $dados['name'];
        $descricao  = $_POST['descricao'];
        $categoria  = $_POST['categoria'];
        $preco      = $_POST['preco'];

        $sql = "INSERT INTO serv_rec (name, descricao, categoria, preco) VALUES ('$name', '$descricao', '$categoria', '$preco')";
        if ($conn2->query($sql) === TRUE) {
            echo('<script>window.location.href = "/";</script>');
            exit;
        } else {
            echo "Falha: " . $conn2->error;
        }

        // if ($cad_item->rowCount()) {
        //     unset($dados);
        //     $_SESSION['msg'] =  "<p style='color: green;'>Item cadastrado com sucesso!</p>";
        //     header("Location: index.php");
        // } else {
        //     echo "<p style='color: #f00;'>Erro: Item não cadastrado com sucesso!</p>";
        // }
    }
}
?>