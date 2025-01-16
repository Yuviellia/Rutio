<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="/public/css/variables.css" type="text/css" rel="stylesheet">
    <link href="/public/css/main.css" type="text/css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bf11c142bf.js" crossorigin="anonymous"></script>
    <script src="./public/js/fetch.js" type="text/javascript" defer></script>
    <title>Rutio | To Do List</title>
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="/todo">To Do List</a>
            <a href="/stats">Stats</a>
            <a href="/dashboard">Habit Tracker</a>
            <a href="/logout">Logout</a>
        </nav>

        <div id="header" class="section">
            <h1>Rutio</h1>
            <div class="clock">
                <span id="hours">07</span>:<span id="minutes">46</span> <span id="period">AM</span>
            </div>
        </div>

        <div id="todo-section" class="section">
            <h2>To-Do List</h2>
            <input placeholder="Search task">
            <form action="/import" method="post" enctype="multipart/form-data">
                <input name="file" type="file">
                <div class="messages"><?php if(isset($messages)){foreach($messages as $message) echo $message;}?></div>
                <button type="submit">Upload</button>
            </form>
            <ul class="task-list">
                <span class="foreach">
                <?php foreach($toDo as $task):?>
                    <form action="/deleteD" method="post" enctype="multipart/form-data">
                        <li>
                            <button type="submit" class="submit-button"><i class="fa-solid fa-trash"></i></button>
                            <span><?=$task["task"]?></span>
                            <input type="hidden" name="task" value="<?= htmlspecialchars($task["id"]) ?>">
                        </li>
                    </form>
                <?php endforeach;?>
                </span>
                <form action="/addD" method="post" enctype="multipart/form-data">
                    <li>
                        <button type="submit" class="submit-button"> <i class="fa-solid fa-plus"></i></button>
                        <span><input name="task" type="text" placeholder="Add a new task..." class="task-input"></span>
                    </li>
                </form>
            </ul>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes();
            const period = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('period').textContent = period;
        }
        setInterval(updateClock, 1000);
        updateClock();

        function updateProgressBar(row) {
            const checkboxes = row.querySelectorAll('input[class^="check-"]');
            const progressBar = row.querySelector('.progress-bar');
            const totalDays = checkboxes.length;
            const checkedDays = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
            const percentage = (checkedDays / totalDays) * 100;
            progressBar.style.width = percentage + '%';
        }

        document.querySelectorAll('table tr').forEach(row => {
            const checkboxes = row.querySelectorAll('input[class^="check-"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => updateProgressBar(row));
            });
        });
    </script>
</body>

<template id="tmplt">
    <form action="/deleteD" method="post" enctype="multipart/form-data">
        <li>
            <button type="submit" class="submit-button"><i class="fa-solid fa-trash"></i></button>
            <span>task</span>
            <input type="hidden" name="task" value="id">
        </li>
    </form>
</template>

</html>
