<?php
// Configurações do banco de dados
$servername = "localhost";  // Servidor do banco de dados (geralmente localhost)
$username = "root";         // Usuário do MySQL
$password = "";             // Senha do MySQL
$dbname = "cadastro";      // Nome do banco de dados

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Coletar dados do formulário
$nome= $_POST['nome'];
$sobrenome= $_POST['sobrenome'];
$empresa= $_POST['empresa'];
$email = $_POST['email'];
$ddd= $_POST['ddd'];
$telefone=  $_POST['telefone'];
$sexo= $_POST['sexo'];
$nivel=  $_POST['nivel'];

// Inserir os dados no banco de dados
$sql = "INSERT INTO usuarios (nome, sobrenome, empresa, email, ddd, telefone, sexo, iniciante) VALUES ('$nome', '$sobrenome', '$empresa', '$email', '$ddd',  '$telefone', '$sexo', '$nivel')";


if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Cadastro Realizado!!'')</script>";
    header("Location: tabela.html");
    exit();
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>