<?php
session_start();
include_once './conexao.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listagem de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
    <h1>Listagem de usuários do sistema</h1>
    <a class="btn btn-sm btn-primary" href="usuarios.php"><i class="fa fa-repeat"></i> Atualizar</a>
    <a class="btn btn-sm btn-primary" href="cadastrar.php">Cadastrar</a>
    <?php
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    // Receber o número da página
    $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    // Setar a quantidade de registros por página
    $limite_resultado = 40;

    // Calcular o inicio da visualização
    $inicio = ($limite_resultado * $pagina) - $limite_resultado;

    $query_usuarios = "SELECT id, nome, email FROM usuarios ORDER BY id DESC LIMIT $inicio, $limite_resultado";
    $result_usuarios = $conn->prepare($query_usuarios);
    $result_usuarios->execute();

    if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
        ?>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th style="text-align: end;">Ações</th>
            </tr>
            <?php
            while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
                extract($row_usuario);
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $email; ?></td>
                    <td style="text-align: end;">
                        <a class="btn btn-sm btn-primary" href='visualizar.php?id=<?php echo $id; ?>'>Visualizar</a>
                        <a class="btn btn-sm btn-primary" href='editar.php?id=<?php echo $id; ?>'>Editar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php

        // Contar a quantidade de registros no BD
        $query_qnt_registros = "SELECT COUNT(id) AS num_result FROM usuarios";
        $result_qnt_registros = $conn->prepare($query_qnt_registros);
        $result_qnt_registros->execute();
        $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

        // Quantidade de página
        $qnt_pagina = ceil($row_qnt_registros['num_result'] / $limite_resultado);

        // Máximo de link
        $maximo_link = 2;

        echo "<br><br><a href='index.php?page=1'>Primeira</a> ";

        for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
            if ($pagina_anterior >= 1) {
                echo "<a href='index.php?page=$pagina_anterior'>$pagina_anterior</a> ";
            }
        }

        echo "$pagina ";

        for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
            if ($proxima_pagina <= $qnt_pagina) {
                echo "<a href='index.php?page=$proxima_pagina'>$proxima_pagina</a> ";
            }
        }

        echo "<a href='index.php?page=$qnt_pagina'>Última</a> ";
    } else {
        echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
    }
    ?>
    </div>
</body>
</html>
