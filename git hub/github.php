<?php
// Function to read tasks from a file
function getTasks() {
    $filename = "tasks.txt";
    if (!file_exists($filename)) {
        return [];
    }
    $tasks = file($filename, FILE_IGNORE_NEW_LINES);
    return $tasks;
}

// Function to add a new task
if (isset($_POST['add_task'])) {
    $new_task = trim($_POST['task']);
    if (!empty($new_task)) {
        file_put_contents('tasks.txt', $new_task . PHP_EOL, FILE_APPEND);
    }
}

// Function to remove a completed task
if (isset($_GET['remove'])) {
    $task_to_remove = $_GET['remove'];
    $tasks = getTasks();
    unset($tasks[$task_to_remove]);
    file_put_contents('tasks.txt', implode(PHP_EOL, $tasks) . PHP_EOL);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>My To-Do List</h1>

    <!-- Form to add new task -->
    <form action="index.php" method="POST" class="add-task-form">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="add_task">Add Task</button>
    </form>

    <!-- Display tasks -->
    <ul class="task-list">
        <?php
        $tasks = getTasks();
        foreach ($tasks as $index => $task) {
            echo "<li>
                    <span>$task</span>
                    <a href='?remove=$index' class='remove-task'>Mark as Completed</a>
                  </li>";
        }
        ?>
    </ul>

</div>
</html>


</body>