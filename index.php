<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lista_de_tarefas";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para adicionar uma nova tarefa
if (isset($_POST['task_name'])) {
    $taskName = $_POST['task_name'];
    $sql = "INSERT INTO tasks (task_name) VALUES ('$taskName')";
    $conn->query($sql);
}

// Função para exibir a lista de tarefas
if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];
    $deleteSql = "DELETE FROM tasks WHERE id = $taskId";
    $conn->query($deleteSql);
}

$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

    <h1>Lista de Tarefas</h1>
    <form method="POST">
        <input type="text" name="task_name" placeholder="Digite uma nova tarefa" required>
        <button type="submit">Adicionar</button>
    </form>
    
    <div class="div-tarefas">
        <h2>Tarefas:</h2>
        <ul>
            <?php while($row = $result->fetch_assoc()): ?>
                <li>
                    <?php echo $row['task_name']; ?>
                    <a class="finalizado" href="?delete=<?php echo $row['id']; ?>">Excluir</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    
    <?php $conn->close(); ?>
</body>
</html>
