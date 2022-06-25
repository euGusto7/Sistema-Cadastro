<?php
    // incluir arquivo de configuração
    require_once "config.php";
    // definir as variáveis e inicializar com valores vazios
    $username = $password = "";
    $username_err = $password_err = $login_err = "";
    // processar os dados do formulário quando o formulário é enviado
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // verifique se o nome de usuário esta vazio
        if(!empty(trim($_POST["username"]))){
            $username_err = "Por favor, insira o nome do usuário.";
        }else{
            $username = trim($_POST["username"]);
        }
        // verificar se a senha esta vazia
        if(!empty(trim($_POST["password"]))){
            $password_err = "Por favor, insira sua senha.";
        }else{
            $password = trim($_POST["password"]);
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Login</title>
    <style>
        body{font: 18px Arial;}
        .conteudo{width: 360px; padding: 20px}
    </style>
</head>
<body>
    <div class="conteudo">
    <div class="text-center">
</div>
<div align="center">
<img src="https://www.imagensempng.com.br/icone-usuario-png/">
        <h3>LOGIN<h3>
        <h5><p>Por favor, preencha os campos para fazer o login</p></h5>
</div>
        <?php
            if(!empty($_login_err)){
                echo '<div class="alert alert-danger">'.$login_err.'</div>';
            }
        ?>
        <form actin="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <div class="form-group">
            <label>Nome do usuário</label>
            <input type="text" name="username" class="form-control" <?php echo (!empty($username_err)) ? 'is-invalid' : '';?>" value="<?php echo $username;?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="password" class="form-control" <?php echo (!empty($password_err)) ? 'is-invalid' : '';?>" value="<?php echo $password;?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group"></div>
        <input type="submit" class="btn btn-primary" value="Entrar">
        <input type="reset" class="btn btn-secundary" value="Cancelar">
        </form>
</div>
<p>Não tem uma conta? <a href="registro.php">Inscreva-se agora.</a></p>
</body>
</html>