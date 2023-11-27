<?php
if(!isset($_SESSION)){
    session_start();
}

include_once './conexao.php';
$query_user = "select * from usuarios where email = '".$_POST['email']."'";
$result_user = $conn->prepare($query_user);
$result_user->execute();

if (($result_user) AND ($result_user->rowCount() != 0)) {
    $sysuser = $result_user->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user'] = $sysuser;
    header("Location: /");
} else {
    echo('

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
    </head>
    <body>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <div class="container-fluid mt-5">
            <div class="card">
                <div class="card-body">
                    <h2>Usuário não cadastrado</h2>
                    <br>
                    Redirecionando para a página inicial...
                </div>
            </div>
        </div>
        <script>setTimeout(() => {window.location.href = "/";}, 5000);</script>
    </body>
    </html>
    ');
}
?>