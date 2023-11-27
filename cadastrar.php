<?php
session_start();
ob_start();
include_once './conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de novo usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-secondary">
    <div class="row">
        <div style="height: 100vh; display: flex; justify-content: center; align-items: center">
            <div class="col-md-4">
                <div class="card">
                    <form name="cad-usuario" method="POST" action="">
                        <div class="card-body">
                            <span class="h3">Cadastro de novo usuário</span>
                            <div class="mt-2" style="display: flex; flex-direction: column;">
                                <div class="mb-3">
                                    <label class="form-label">Nome: </label>
                                    <input class="form-control" type="text" name="nome" id="nome"
                                        placeholder="Nome completo" value="<?php
                                    if (isset($dados['nome'])) {
                                        echo $dados['nome'];
                                    }
                                    ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">E-mail: </label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        placeholder="Seu melhor e-mail" value="<?php
                                    if (isset($dados['email'])) {
                                        echo $dados['email'];
                                    }
                                    ?>">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div style="display: flex; justify-content: space-between;">
                                <a class="btn btn-sm btn-warning" href="/"><i class="fa fa-arrow-left"></i>
                                    Voltar</a><br>
                                <input class="btn btn-sm btn-success" type="submit" value="Cadastrar" name="CadUsuario">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
//Receber os dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Verificar se o usuário clicou no botão
if (!empty($dados['CadUsuario'])) {
    //var_dump($dados);

    $empty_input = false;

    $dados = array_map('trim', $dados);
    if (in_array("", $dados)) {
        $empty_input = true;
        echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
    } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        $empty_input = true;
        echo "<p style='color: #f00;'>Erro: Necessário preencher com e-mail válido!</p>";
    }

    if (!$empty_input) {
        $query_usuario = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email) ";
        $cad_usuario = $conn->prepare($query_usuario);
        $cad_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $cad_usuario->execute();
        if ($cad_usuario->rowCount()) {
            unset($dados);
            $_SESSION['msg'] =  "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
            header("Location: index.php");
        } else {
            echo "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
        }
    }
}
?>