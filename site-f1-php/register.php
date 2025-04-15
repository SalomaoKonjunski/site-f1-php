<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Register</title>
</head>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = include('data/users.php');
    $users[] = [
        'username' => $_POST['username'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => 'user'
    ];
    file_put_contents('data/users.php', '<?php return ' . var_export($users, true) . ';');
    header("Location: index.php");
}
?>

<h2>Cadastro de Usuário</h2>
<form method="POST">
    Usuário: <input type="text" name="username" required><br>
    Senha: <input type="password" name="password" required><br>
    <button type="submit">Cadastrar</button>
</form>
