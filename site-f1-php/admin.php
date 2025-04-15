<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>admin</title>
</head>
<?php
session_start();
if ($_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$races = file_exists('data/races.php') ? include('data/races.php') : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        unset($races[$_POST['delete']]);
    } else {
        $imageName = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "images/uploads/" . $imageName);
        $races[] = [
            'title' => $_POST['title'],
            'date' => $_POST['date'],
            'short' => $_POST['short'],
            'desc' => $_POST['desc'],
            'image' => $imageName
        ];
    }
    file_put_contents('data/races.php', '<?php return ' . var_export($races, true) . ';');
    header("Location: admin.php");
    exit;
}
?>

<div class="card-container">
    
    <?php foreach ($races as $race): ?>
        <div class="card">
            
            <img src="./images/?php echo htmlspecialchars($race['image']); ?>" alt="Imagem da Corrida">
            <h3><?php echo htmlspecialchars($race['title']); ?> (<?php echo htmlspecialchars($race['date']); ?>)</h3>
            <p><?php echo htmlspecialchars($race['short']); ?></p>
            <button onclick="showMore('<?php echo base64_encode($race['desc']); ?>')">Ver Mais</button>
            
        </div>
    <?php endforeach; ?>
</div>
<h2>Painel Admin</h2>
<a href="dashboard.php">Voltar</a>
<form method="POST" enctype="multipart/form-data">
    <h3>Adicionar Corrida</h3>
    Título: <input type="text" name="title"><br>
    Data: <input type="year" name="date"><br>
    Resumo: <textarea name="short"></textarea><br>
    Descrição Completa: <textarea name="desc"></textarea><br>
    Imagem: <input type="file" name="image"><br>
    <button type="submit">Adicionar</button>
</form>

<h3>Corridas Existentes</h3>
<?php foreach ($races as $index => $race): ?>
 <div class="card-container" > 
 <div class="card">
    <img src="images/uploads/<?php echo $race['image']; ?>" alt="Imagem da Corrida">
        <strong><?php echo htmlspecialchars($race['title']); ?> (<?php echo htmlspecialchars($race['date']); ?>)</strong>
        <form method="POST">
            <input type="hidden" name="delete" value="<?php echo $index; ?>">
            <button type="submit">Remover</button>
        </form>
        </div> 
    </div>
<?php endforeach; ?>