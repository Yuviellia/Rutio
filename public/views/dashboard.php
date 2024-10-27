<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="/public/css/variables.css" type="text/css" rel="stylesheet">
    <link href="/public/css/main.css" type="text/css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bf11c142bf.js" crossorigin="anonymous"></script>
    <title>Rutio | Dashboard</title>
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="/todo">To Do List</a>
            <a href="/stats">Stats</a>
            <a href="/dashboard">Habit Tracker</a>
            <a href="">Logout</a>
        </nav>

        <div id="header" class="section">
            <h1>Rutio</h1>
            <div class="clock">
                <span id="hours">07</span>:<span id="minutes">46</span> <span id="period">AM</span>
            </div>
        </div>

        <div id="habit-table-section" class="section">
            <h2>Habit Tracker</h2>
            <?php
            $days = ["mon", "tue", "wed", "thu", "fri", "sat", "sun"];
            if(!isset($startDate)) $startDate = new DateTime();
            $startDate->modify('monday this week');
            ?>

            <p>
                <a href="/dashboard?startDate=<?=(clone $startDate)->modify('-1 week')->format('Y-m-d')?>">&lt;</a>
                <?=$startDate->format('Y-m-d')?>
                <a href="/dashboard?startDate=<?=(clone $startDate)->modify('+1 week')->format('Y-m-d')?>">&gt;</a>
            </p>
            <table>
                <tr>
                    <th style="width: 42%;">Task</th>
                    <th style="width: 6%;">Mon</th>
                    <th style="width: 6%;">Tue</th>
                    <th style="width: 6%;">Wed</th>
                    <th style="width: 6%;">Thu</th>
                    <th style="width: 6%;">Fri</th>
                    <th style="width: 6%;">Sat</th>
                    <th style="width: 6%;">Sun</th>
                    <th style="width: 16%;">Progress</th>
                </tr>
                <?php foreach($tags as $tag):?>
                    <tr>
                        <td>
                            <div class="task-cell">
                                <form action="/deleteG" method="post" enctype="multipart/form-data">
                                    <span><?=$tag["name"]?></span>
                                    <button type="submit" class="submit-button"><i class="fa-solid fa-trash"></i></button>
                                    <input type="hidden" name="tag" value="<?= htmlspecialchars($tag["id"]) ?>">
                                    <input type="hidden" name="startDate" value="<?= htmlspecialchars($startDate->format('Y-m-d')) ?>">
                                </form>
                            </div>
                        </td>
                        <?php
                        foreach ($days as $index => $day):
                            $startDateClone = clone $startDate;
                            $currentDate = $startDateClone->modify('+' . $index . ' days')->format('Y-m-d');

                            $isChecked = false;
                            if (isset($marks[$tag["id"]])) {
                                $i = 0;
                                foreach ($marks[$tag["id"]] as $entry) {
                                    $i++;
                                    if ($entry["date"] === $currentDate) {
                                        $isChecked = true;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <td>
                                <form action="/mark" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($tag["id"]) ?>">
                                    <input type="hidden" name="date" value="<?= htmlspecialchars($currentDate) ?>">
                                    <input type="hidden" name="startDate" value="<?= htmlspecialchars($startDate->format('Y-m-d')) ?>">
                                    <label>
                                        <input type="checkbox" class="check-<?= $day; ?>" name="marked" value="1" <?= $isChecked ? 'checked' : '' ?> onchange="this.form.submit()">
                                    </label>
                                </form>
                            </td>
                        <?php endforeach; ?>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?= $i / 7 * 100;?>%;"></div>

                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td>
                        <div class="task-cell">
                            <form action="/addG" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="startDate" value="<?= htmlspecialchars($startDate->format('Y-m-d')) ?>">
                                <span><input name="tag" type="text" placeholder="Add a new tag..." class="task-input"></span>
                                <button type="submit" class="submit-button"><i class="fa-solid fa-plus"></i></button>
                            </form>
                        </div>
                    </td>
                    <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td>
                    <td><div class="progress"></div></td>
                </tr>
            </table>
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
    </script>
</body>
</html>
