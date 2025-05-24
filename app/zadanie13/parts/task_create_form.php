<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie13");

$login_query = $db->prepare("SELECT id_pracownika, login FROM pracownicy");
$login_query->execute();
$login_query->bind_result($id_pracownika, $login);
$login_query->store_result();

$select = "<select class='form-select' name='subtask_assignees[]'>";
$i = 0;
while ($login_query->fetch()) {
    if ($i++ == 0) {
        $select .= "<option value='$id_pracownika' selected>$login</option>";
    }
    else {
        $select .= "<option value='$id_pracownika'>$login</option>";
    }
}
$select .= "</select>";

?>

<div class="row">
    <form class="col-md-6" style="display: block; margin-bottom: 20px; border: 1px solid lightgray; padding: 16px;" action="/zadanie13/parts/task_create_handle.php" method="post">
        <div class="form-group">
            <label for="todo-title">Tytuł</label>
            <input type="text" id="todo-title" name="task_name" class="form-control" placeholder="Wpisz nazwę całego zadania"  />
        </div>

        <div class="form-group">
            <label for="todo-tasks-number">Ilość podzadań</label>
            <input type="number" id="todo-tasks-number" name="subtask_count" class="form-control" value="1" min="1" max="40" />
        </div>

        <!-- Create subtask for each number -->
        <div id="todo-tasks"></div>
        <script>
            $("#todo-tasks-number").change(function() {
                const tasksNumber = $("#todo-tasks-number").val();
                const tasks = $("#todo-tasks");
                tasks.empty();

                for (let i = 0; i < tasksNumber; i++) {
                    const template = `
                        <div class="form-group" style="border: 1px solid lightgray; padding: 16px; margin-top: 4px;">
                            <label for="todo-task-${i}">Wpisz nazwę pozadania ${i + 1}:</label>
                            <input type="text" id="todo-task-${i}" class="form-control" placeholder="Wpisz nazwę podzadania" name="subtask_names[]" />
                            <label for="todo-task-${i}">Przypisz pracownika do pozadania ${i + 1}:</label>
                            <?php echo $select; ?>
                        </div>
                    `;
                    tasks.append(template);
                }
            });

            $("#todo-tasks-number").change();
        </script>

        <input type="submit" value="Utwórz zadanie" class="btn btn-secondary" style="display: block; margin-top: 5px;" />
    </form>
</div>
