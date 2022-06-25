    
<?php
    require_once "config.php";
    $username = $password = $confim_password = '';
    $username_err = $password_err = $confirm_password_err = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["username"]))){
            $username_err = "Por favor coloque um nome de usuário";
        }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))){
            $username_err = "O nome de usuário pode conter apenas letras, números e o underline";
        }else{
            // prepara uma declaração selecionada
            $sql = "SELECT id FROM usuario WHERE username = :username";
            if($stmt = $pdo->prepare($sql)){
                // vincule as variáveis a instrução preparada como parâmetros
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                // definir parâmetros
                $param_username = trim($_POST['username']);
                // tente executar a declaração preparada
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $username_err = "Este nome de usuário já está em uso.";
                    }else{
                        $username = trim($_POST['username']);
                    }
                }else{
                    echo "OPs! Algo deu errado. Por favor, tente novamente mais tarde.";
                }
                // fechar declaração
                unset($stmt);
            }
        }
        // validar a senha
        if(empty(trim($_POST['password']))){
          $password_err = "Por favor insira uma senha.";
        }elseif(strlen(trim($_POST['password'])) < 6){
            $password_err = "A senha deve ter pelo menos 6 caracteres";
        }else{
            $password = trim($_POST['password']);
        }
        // validar o confirmar senha
        if(empty(trim($_POST['confirm_password']))){
            $confirm_password_err = "Por favor, confirme a sua senha";
        }else{
            $confim_password = trim($_POST['confirm_password']);
            if(empty($password_err) && ($password != $confim_password)){
                $confirm_password_err =  "A senha não confere.";
            }
        }
        // verifique os erros de entrada antes de inserir no banco de dados
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            // prepara uma declaração de inserção
            $sql = "INSERT INTO usuario (username, password) VALUES (:username, :password)";
            if($stmt = $pdo->prepare($sql)){
                // vincule as variáveis a instrução preparada como parâmetro
                $stmt->bindParam(":username",$param_username, PDO::PARAM_STR);
                $stmt->bindParam(":password",$param_password, PDO::PARAM_STR);
                // definir os parâmetros
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                // tente executar a declaração preparada
                if($stmt->execute()){
                    // redireciona para a pagina de login
                    header("location: login.php");
                }else{
                    echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
                }
            }
        }
        // fechar declaração
        unset($pdo);
    }
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body{font: 18px Arial;}
        .conteudo{width: 360px; padding: 20px}

    </style>
</head>
<body>
    <div class="conteudo">
        <h3>CADASTRO</h3>
        <p>Por favor, preencha este formulário para criar a sua conta</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method ="POST">
            <div class="form-group">
                <label>Nome do Usuário</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : '';?>" value ="<?php echo $username;?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : '';?>" value ="<?php echo $password;?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : '';?>" value ="<?php echo $confim_password;?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="Criar conta">
                <input type="reset" class="btn btn-secondary m1-2" value="Apagar dados">
            </div>
            <p>Já tem conta? <a href="login.php">Entre aqui</a></p>

        </form>
    
    </div>
</body>
</html>