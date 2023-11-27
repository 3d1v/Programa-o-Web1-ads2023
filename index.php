<?php
if(!isset($_SESSION)){
    session_start();
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

$query = "SELECT *, CONCAT('R$ ',FORMAT(preco,2,'de_DE')) as preco FROM serv_rec";
$result = mysqli_query($conn2, $query);
$item_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"><b>
                            <?php echo($sysname); ?>
                        </b></h1>
                    <p class="lead text-body-secondary">
                        Uma plataforma que visa facilitar o compartilhamento de recursos e serviços dentro de
                        comunidades locais.
                    </p>
                </div>
            </div>
        </section>

        <div class="album py-5 bg-body-tertiary">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php foreach ($item_list as $item): ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title><?php echo $item['name']; ?></title>
                                <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%"
                                    fill="#eceeef" dy=".3em">ícone/imagem</text>
                            </svg>
                            <div class="card-body">
                                <span class="h3"><?php echo $item['name']; ?></span>
                                <p class="card-text">
                                    <?php echo $item['descricao']; ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <?php
                                        if($item['categoria'] == 1){
                                            ?>
                                            <span class="badge bg-primary">Recurso</span>
                                            <?php
                                        } else if($item['categoria'] == 2){
                                            ?>
                                                <span class="badge bg-warning">Serviço</span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <span class="h3 text-body-secondary"><?php echo $item['preco']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                </div>
               
                <?php
                if(count($item_list) == 0){
                    echo('
                    <div class="card bg-primary text-white mb-5">
                        <div class="card-body">
                            <h2>Nenhum recurso ou serviço cadastrado <small>(Por enquanto...)</small></h2>
                            <p>Os recursos e serviços cadastrados irão aparecer aqui.</p>
                        </div>
                    </div>  
                    ');
                }
                ?>
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