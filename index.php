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

// Função para excluir uma tarefa
if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];
    $deleteSql = "DELETE FROM tasks WHERE id = $taskId";
    $conn->query($deleteSql);
}

// Função para excluir todas as tarefas
if (isset($_POST['delete_all'])) {
    $deleteAllSql = "DELETE FROM tasks";
    $conn->query($deleteAllSql);
}

// Função para buscar uma tarefa por ID
function getTaskById($conn, $taskId) {
    $sql = "SELECT * FROM tasks WHERE id = $taskId";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Função para atualizar uma tarefa
if (isset($_POST['update_task'])) {
    $taskId = $_POST['task_id'];
    $updatedTaskName = $_POST['updated_task_name'];
    $updateSql = "UPDATE tasks SET task_name = '$updatedTaskName' WHERE id = $taskId";
    $conn->query($updateSql);
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

<body>
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
                    <div class="item-da-lista">
                        <?php echo $row['task_name']; ?>
                        <div>
                            <a class="editar" href="#" onclick="editTask(<?php echo $row['id']; ?>, '<?php echo $row['task_name']; ?>')">Editar</a>
                            <a class="finalizado" href="?delete=<?php echo $row['id']; ?>">Excluir</a>
                        </div>
                    </div>
                    <div id="edit-form" style="display:none;">
                        <p>Editar Tarefa:</p>
                        <form method="POST">
                            <input type="hidden" id="edit-task-id" name="task_id">
                            <input type="text" id="edit-task-name" name="updated_task_name" required>
                            <button type="submit" name="update_task">Salvar</button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
        <form method="POST" class="form-finalizado">
            <button type="submit" name="delete_all">Apagar todas as tarefas</button>
        </form>
    </div>
    

    
    <script>
        function editTask(id, name) {
            document.getElementById("edit-task-id").value = id;
            document.getElementById("edit-task-name").value = name;
            document.getElementById("edit-form").style.display = "block";
        }
    </script>
    
    <?php $conn->close(); ?>
</body>
</html>
