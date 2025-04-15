<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Index</title>
</head>
<body>

<?php
session_start();
header('Content-Type: text/html; charset=UTF-8'); 

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = include('data/users.php');

    
    $_POST['username'] = mb_convert_encoding($_POST['username'], 'UTF-8', 'auto');
    $_POST['password'] = mb_convert_encoding($_POST['password'], 'UTF-8', 'auto');

    foreach ($users as $user) {
        if ($_POST['username'] == $user['username'] && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Usuário ou senha incorretos!";
}
?>

<h2>Login - Fórmula 1</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<div class="form">
<form method="POST">
    Usuário: <input type="text" name="username" required><br>
    Senha: <input type="password" name="password" required><br>
    <button type="submit">Entrar</button>
</form>
</div>
<br>
<a href="register.php">Cadastrar novo usuário</a>

</body>
</html>