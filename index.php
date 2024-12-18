<?php
// File to store tasks
$tasksFile = 'tasks.txt';

// To add a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        file_put_contents($tasksFile, $task . PHP_EOL, FILE_APPEND);
    }
}

// To remove a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_task'])) {
    $removeTask = $_POST['remove_task'];
    $tasks = file($tasksFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $tasks = array_filter($tasks, fn($t) => $t !== $removeTask);
    file_put_contents($tasksFile, implode(PHP_EOL, $tasks) . PHP_EOL);
}

// Read tasks from file
$tasks = file_exists($tasksFile) ? file($tasksFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP To-Do List</title>
  <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            margin-bottom: 20px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .remove-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .remove-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP To-Do List</h1>

        <!-- Add Task Form -->
        <form action="todo.php" method="POST">
            <input type="text" name="task" placeholder="Enter a new task..." required>
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <!-- Display Tasks -->
        <ul>
            <?php if (!empty($tasks)): ?>
                <?php foreach ($tasks as $task): ?>
                    <li>
                        <span><?php echo htmlspecialchars($task); ?></span>
                        <form action="todo.php" method="POST" style="margin: 0;">
                            <button type="submit" name="remove_task" value="<?php echo htmlspecialchars($task); ?>" class="remove-button">Complete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No tasks available. Add one above!</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
