<?php
    /* credenciais do banco de dados. Supondo que você esteja executando o MySQL servidor com configuração padrão(usuario 'root' sem senha) */
    define('DB_SERVER','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSEWORD','');
    define('DB_NAME','login');
    /* tentativa de conexão com banco de dados MySQL */
    try{
        $pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSEWORD);
        // defina o modo de erro PDO para exceção
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("ERROR: não foi possível conectar.". $e->getMessage());
    }

?>