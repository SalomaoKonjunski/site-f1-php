<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$races = file_exists('data/races.php') ? include('data/races.php') : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Dashboard</title>
</head>
<body>

<h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>!</h2>
<a href="logout.php">Logout</a><br>
<?php if ($_SESSION['user']['role'] == 'admin'): ?>
    <a href="admin.php">Ir para painel de administração</a>
<?php endif; ?>

<div class="card-container">
    <?php foreach ($races as $race): ?>
        <div class="card">
            <img src="images/uploads/<?php echo htmlspecialchars($race['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Imagem da Corrida">
            <h3><?php echo htmlspecialchars($race['title'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($race['date'], ENT_QUOTES, 'UTF-8'); ?>)</h3>
            <p><?php echo htmlspecialchars($race['short'], ENT_QUOTES, 'UTF-8'); ?></p>
            <button onclick="showMore('<?php echo base64_encode($race['desc']); ?>')">Ver Mais</button>
        </div>
    <?php endforeach; ?>
</div>

<script>
function showMore(desc) {
    const content = atob(desc);
    const popup = document.createElement("div");
    popup.style.position = "fixed";
    popup.style.top = 0;
    popup.style.left = 0;
    popup.style.width = "100%";
    popup.style.height = "100%";
    popup.style.background = "white";
    popup.style.zIndex = 1000;
    popup.innerHTML = `<div style="padding:20px;"><p>${content}</p><button onclick="document.body.removeChild(this.parentNode.parentNode)">Mostrar Menos</button></div>`;
    document.body.appendChild(popup);
}
</script>

</body>
</html>