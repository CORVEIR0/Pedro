<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro"; // Nome do banco de dados conforme o arquivo PDF

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Selecionar emails da tabela usuarios
$sql = "SELECT email FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Captura o assunto e a mensagem enviados pelo formulário
    $assunto = $_POST['assunto']; // Assunto do email
    $mensagem = $_POST['mensagem']; // Corpo da mensagem do email
    
    $mail = new PHPMailer(true);
    
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ph801544@gmail.com'; // Substitua com seu e-mail
    $mail->Password = 'ezwk eqfd zdxe ckkm'; // Senha de app do Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('ph801544@gmail.com', 'Pedro Henrique');

    // Verificar e anexar o arquivo, se houver
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $mail->addAttachment($_FILES['arquivo']['tmp_name'], $_FILES['arquivo']['name']);
    }

    $emailEnviados = 0; // Contador de emails enviados

    // Enviar para cada email encontrado
    while ($row = $result->fetch_assoc()) {
        $destinatario = $row['email'];
        if (filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
            try {
                $mail->addAddress($destinatario);
                $mail->isHTML(true);
                $mail->Subject = $assunto;
                $mail->Body = $mensagem;
                
                // Envia o email
                if ($mail->send()) {
                    $emailEnviados++;
                    echo "Email enviado para: $destinatario <br>";
                } else {
                    echo "Falha ao enviar para: $destinatario <br>";
                }
                
                // Limpar o endereço para o próximo loop
                $mail->clearAddresses();
                
            } catch (Exception $e) {
                echo "Erro ao enviar email para {$destinatario}: {$mail->ErrorInfo}<br>";
            }
        } else {
            echo "Email inválido: $destinatario <br>";
        }
    }

    if ($emailEnviados > 0) {
        echo "<script>alert('Emails enviados com sucesso!');</script>";
    } else {
        echo "<script>alert('Nenhum email foi enviado. Verifique os erros.');</script>";
    }

} else {
    echo "Nenhum email encontrado no banco de dados.";
}

// Fechar conexão com o banco de dados
$conn->close();
?>